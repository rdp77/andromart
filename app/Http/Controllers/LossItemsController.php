<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Warranty;
use App\Models\LossItems;
use App\Models\LossItemsDetail;
use App\Models\ServiceDetail;
use App\Models\ServiceStatusMutation;
use Illuminate\Http\Request;
use App\Models\AccountData;
use App\Models\AccountMainDetail;
use App\Models\Journal;
use App\Models\JournalDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;
// use DB;

class LossItemsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(4, 'view');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }
        if ($req->ajax()) {
            $data = LossItems::with(['Technician'])
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">';
                    // $actionBtn .= '<a class="dropdown-item" href="' . route('service-payment.edit', $row->id) . '"><i class="far fa-edit"></i> Edit</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('loss-items.show', $row->id) . '"><i class="far fa-eye"></i> Lihat</a>';
                    // $actionBtn .= '<a class="dropdown-item" href="' . route('service.printServicePayment', $row->id) . '"><i class="fas fa-print"></i> Print</a>';
                    $actionBtn .= '<a onclick="jurnal(' . "'" . $row->code . "'" . ')" class="dropdown-item" style="cursor:pointer;"><i class="fas fa-file-alt"></i> Jurnal</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                    $actionBtn .= '</div></div>';

                    return $actionBtn;
                })
                ->addColumn('dateFormat', function ($row) {
                    return Carbon::parse($row->date)
                        ->locale('id')
                        ->isoFormat('LL');
                })
                ->addColumn('dateRange', function ($row) {
                    return Carbon::parse($row->date_start)
                        ->locale('id')
                        ->isoFormat('LL') .
                        ' S/D  ' .
                        Carbon::parse($row->date_end)
                            ->locale('id')
                            ->isoFormat('LL');
                })
                ->addColumn('totalValue', function ($row) {
                    return number_format($row->total, 0, '.', ',');
                })
                ->rawColumns(['action', 'dateRange', 'dateFormat', 'totalValue'])
                ->make(true);
        }

        return view('pages.backend.finance.lossItems.indexLossItems');
        // $var = 'as';
        // $data = Service::where('technician_id', Auth::user()->id)->get();
        // $employee = Employee::get();
        // $accountMain = AccountMainDetail::where('main_id',1)->get();
        // $accountData = AccountData::get();
        // return view('pages.backend.finance.loss_items.lossItems', compact('data', 'employee','accountMain','accountData'));
    }
    public function lossItemsLoadDataService(Request $req)
    {
        // return $req->all();
        $data = Service::with(['ServiceDetail', 'ServiceDetail.Items', 'ServiceStatusMutation', 'ServiceStatusMutation.Technician', 'LossItemsDetail', 'LossItemsDetail.LossItems'])
            ->where('date', '>=', $this->DashboardController->changeMonthIdToEn($req->dateS))
            ->where('date', '<=', $this->DashboardController->changeMonthIdToEn($req->dateE))
            // ->where('work_status', 'Diambil')
            ->where('total_loss', '!=', 0)
            ->where(function ($query) use ($req) {
                $query->where('technician_id', $req->id)->orWhere('technician_replacement_id', $req->id);
            })
            ->get();

        if (count($data) == 0) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message]);
    }
    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('loss_items')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $year . $month . $index;
    }

    public function store(Request $req)
    {
        // return $req->all();
        // return array_sum($req->totalAll);

        DB::beginTransaction();
        try {
            $totalLoss = array_sum($req->totalAllLoss);
            $checkData = LossItems::where('date_start', $this->DashboardController->changeMonthIdToEn($req->startDate))
                ->where('date_end', $this->DashboardController->changeMonthIdToEn($req->endDate))
                ->where('employe_id', $req->technicianId)
                ->get();
            if (count($checkData) != 0) {
                return Response::json(['status' => 'fail', 'message' => 'Data Sudah Ada']);
            }
            $index = DB::table('loss_items')->max('id') + 1;
            $kodeLoss = $this->code('LOS', $index);
            $kode = $this->codeJournals('LOS', $index);

            LossItems::create([
                'id' => $index,
                'code' => $kodeLoss,
                'date' => date('Y-m-d'),
                'date_start' => $this->DashboardController->changeMonthIdToEn($req->startDate),
                'date_end' => $this->DashboardController->changeMonthIdToEn($req->endDate),
                'employe_id' => $req->technicianId,
                'total' => $req->totalValueLoss,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            for ($i = 0; $i < count($req->idDetailLoss); $i++) {
                if ($req->payDetailLoss[$i] == 'Belum Bayar') {
                    LossItemsDetail::create([
                        // 'id' => $i + 1,
                        'loss_items_id' => $index,
                        'service_id' => $req->idDetailLoss[$i],
                        'total' => $req->totalDetailLoss[$i],
                        'created_by' => Auth::user()->name,
                        'created_at' => date('Y-m-d h:i:s'),
                    ]);
                }
            }
            // jurnal karyawan megembalikan uang loss
            $idJournal = DB::table('journals')->max('id') + 1;
            Journal::create([
                'id' => $idJournal,
                'code' => $this->codeJournals('DD', $idJournal),
                'year' => date('Y'),
                'date' => date('Y-m-d'),
                'type' => 'Pendapatan',
                'total' => str_replace(',', '', $req->totalValueLoss),
                'ref' => $kodeLoss,
                'description' => 'Pembayaran Barang Loss',
                'created_at' => date('Y-m-d h:i:s'),
                // 'updated_at'=>date('Y-m-d h:i:s'),
            ]);

            $cariCabang = AccountData::where('id', $req->accountData)->first();
            $accountLossTeknisi = AccountData::where('branch_id', $cariCabang->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 10)
                ->where('main_detail_id', 41)
                ->first();

            $accountCode = [$req->accountData];
            $totalBayar = [str_replace(',', '', $req->totalValueLoss)];
            $description = ['Pembayaran Teknisi Barang LOSS'];
            $DK = ['D'];

            for ($i = 0; $i < count($req->idDetailLoss); $i++) {
                if ($req->payDetailLoss[$i] == 'Belum Bayar') {
                    array_push($accountCode, $accountLossTeknisi->id);
                    array_push($totalBayar, $req->totalDetailLoss[$i]);
                    array_push($description, 'Pembayaran Teknisi Barang LOSS Detail');
                    array_push($DK, 'K');
                }
            }
            // return $accountCode;
            for ($i = 0; $i < count($accountCode); $i++) {
                $idDetail = DB::table('journal_details')->max('id') + 1;
                JournalDetail::create([
                    'id' => $idDetail,
                    'journal_id' => $idJournal,
                    'account_id' => $accountCode[$i],
                    'total' => $totalBayar[$i],
                    'description' => $description[$i],
                    'debet_kredit' => $DK[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }

            // jurnal toko mengeluarkan uang loss
            $idJournalToko = DB::table('journals')->max('id') + 1;
            Journal::create([
                'id' => $idJournalToko,
                'code' => $this->codeJournals('KK', $idJournalToko),
                'year' => date('Y'),
                'date' => date('Y-m-d'),
                'type' => 'Biaya',
                'total' => str_replace(',', '', $totalLoss),
                'ref' => $kodeLoss,
                'description' => 'Pengeluaran Toko Barang Loss',
                'created_at' => date('Y-m-d h:i:s'),
                // 'updated_at'=>date('Y-m-d h:i:s'),
            ]);

            $cariCabangToko = AccountData::where('id', $req->accountData)->first();
            $accountLossToko = AccountData::where('branch_id', $cariCabangToko->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 6)
                ->where('main_detail_id', 42)
                ->first();

            $accountCodeToko = [$req->accountData];
            $totalBayarToko = [str_replace(',', '', $totalLoss)];
            $descriptionToko = ['Pengeluaran Toko Barang LOSS'];
            $DKToko = ['K'];

            for ($i = 0; $i < count($req->idDetailLoss); $i++) {
                if ($req->payDetailLoss[$i] == 'Belum Bayar') {
                    array_push($accountCodeToko, $accountLossToko->id);
                    array_push($totalBayarToko, $req->totalAllLoss[$i]);
                    array_push($descriptionToko, 'Pengeluaran Toko Barang LOSS Detail');
                    array_push($DKToko, 'D');
                }
            }
            // return $DKToko;

            for ($i = 0; $i < count($accountCodeToko); $i++) {
                $idDetailToko = DB::table('journal_details')->max('id') + 1;
                JournalDetail::create([
                    'id' => $idDetailToko,
                    'journal_id' => $idJournalToko,
                    'account_id' => $accountCodeToko[$i],
                    'total' => $totalBayarToko[$i],
                    'description' => $descriptionToko[$i],
                    'debet_kredit' => $DKToko[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }


            DB::commit();
            // return 's';
            return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            // return $th;
            return Response::json(['status' => 'error', 'message' => $th->getMessage()]);
        }
        // return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
    }
    public function codeJournals($type)
    {
        $getEmployee = Employee::with('branch')
            ->where('user_id', Auth::user()->id)
            ->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('journals')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function destroy(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $this->DashboardController->createLog($req->header('user-agent'), $req->ip(), 'Menghapus Data Loss Items');
            $checkLossItems = DB::table('loss_items')
                ->where('id', $id)
                ->first();
            $checkJournals = DB::table('journals')
                ->where('ref', $checkLossItems->code)
                ->get();
            // return $checkJournals;
            DB::table('journals')
                ->whereIn('id', [$checkJournals[0]->id,$checkJournals[1]->id])
                ->delete();

            DB::table('journal_details')
                ->whereIn('journal_id', [$checkJournals[0]->id,$checkJournals[1]->id])
                ->delete();

            DB::table('loss_items')
                ->where('id', $id)
                ->delete();

            DB::table('loss_items_detail')
                ->where('loss_items_id', $id)
                ->delete();

            DB::commit();
            return Response::json(['status' => 'success', 'message' => 'Data Terhapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            // return$th;
            return Response::json(['status' => 'error', 'message' => $th->getMessage()]);
        }
        return Response::json(['status' => 'success']);
    }

    public function show($id)
    {
        $data = LossItems::with('LossItemsDetail', 'LossItemsDetail.Service')
                ->where('code', $id)
                ->first();

        if (isset($data) == 1) {
            $data = $data;
        }else{
            $data = LossItems::with('LossItemsDetail', 'LossItemsDetail.Service')
                ->where('id', $id)
                ->first();
        }
        // return $data;
        return view('pages.backend.finance.lossItems.showLossItems', ['data' => $data]);
    }
    public function lossItemsCheckJournals(Request $req)
    {
        $data = Journal::with('JournalDetail.AccountData')
            ->where('ref', $req->id)
            ->get();
        return Response::json(['status' => 'success', 'jurnal' => $data]);
    }
}
