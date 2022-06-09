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
        $data = Service::where('technician_id', Auth::user()->id)->get();
        $employee = Employee::get();
        $accountMain = AccountMainDetail::where('main_id',1)->get();
        $accountData = AccountData::get();
        return view('pages.backend.finance.loss_items.lossItems', compact('data', 'employee','accountMain','accountData'));
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
                $query->where('technician_id', $req->id)
                    ->orWhere('technician_replacement_id', $req->id);
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
        $index = DB::table('service')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $year . $month . $index;
    }

    public function store(Request $req)
    {
        // return $req->all();
        // return array_sum($req->totalAll);

        DB::beginTransaction();
        try {
            $totalLoss = array_sum($req->totalAll);
            $checkData = LossItems::where('date_start', $this->DashboardController->changeMonthIdToEn($req->startDate))
                ->where('date_end', $this->DashboardController->changeMonthIdToEn($req->endDate))
                ->where('employe_id', $req->technicianId)
                ->get();
            if (count($checkData) != 0) {
                return Response::json(['status' => 'fail', 'message' => 'Data Sudah Ada']);
            }
            $index = DB::table('loss_items')->max('id') + 1;
            $kode =  $this->codeJournals('LOS', $index);

            LossItems::create([
                'id' => $index,
                'code' => $kode,
                'date' => date('Y-m-d'),
                'date_start' => $this->DashboardController->changeMonthIdToEn($req->startDate),
                'date_end' => $this->DashboardController->changeMonthIdToEn($req->endDate),
                'employe_id' => $req->technicianId,
                'total' => $req->totalValue,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            for ($i = 0; $i < count($req->idDetail); $i++) {
                LossItemsDetail::create([
                    'id' => $i + 1,
                    'loss_items_id' => $index,
                    'service_id' => $req->idDetail[$i],
                    'total' => $req->totalDetail[$i],
                    'created_by' => Auth::user()->name,
                    'created_at' => date('Y-m-d h:i:s'),
                ]);
            }
            // jurnal karyawan megembalikan uang loss
            $idJournal = DB::table('journals')->max('id') + 1;
            Journal::create([
                'id' => $idJournal,
                'code' => $this->codeJournals('DD', $idJournal),
                'year' => date('Y'),
                'date' => date('Y-m-d'),
                'type' => 'Pendapatan',
                'total' => str_replace(",", '', $req->totalValue),
                'ref' => $kode,
                'description' => 'Pembayaran Barang Loss',
                'created_at' => date('Y-m-d h:i:s'),
                // 'updated_at'=>date('Y-m-d h:i:s'),
            ]);
            
            $cariCabang = AccountData::where('id', $req->accountData)->first();
            $accountLossTeknisi  = AccountData::where('branch_id', $cariCabang->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 10)
                ->where('main_detail_id', 41)
                ->first();

            $accountCode = [
                $req->accountData,
            ];
            $totalBayar = [
                str_replace(",", '', $req->totalValue),
            ];
            $description = [
                'Pembayaran Teknisi Barang LOSS',
            ];
            $DK = [
                'D',
            ];

            for ($i = 0; $i < count($req->idDetail); $i++) {
                array_push($accountCode, $accountLossTeknisi->id);
                array_push($totalBayar, $req->totalDetail[$i]);
                array_push($description, 'Pembayaran Teknisi Barang LOSS Detail');
                array_push($DK, 'K');
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
                'total' => str_replace(",", '', $totalLoss),
                'ref' => $kode,
                'description' => 'Pengeluaran Toko Barang Loss',
                'created_at' => date('Y-m-d h:i:s'),
                // 'updated_at'=>date('Y-m-d h:i:s'),
            ]);

            $cariCabangToko = AccountData::where('id', $req->accountData)->first();
            $accountLossToko  = AccountData::where('branch_id', $cariCabangToko->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 6)
                ->where('main_detail_id', 42)
                ->first();

            $accountCodeToko = [
                $req->accountData,
            ];
            $totalBayarToko = [
                str_replace(",", '', $totalLoss),
            ];
            $descriptionToko = [
                'Pengeluaran Toko Barang LOSS',
            ];
            $DKToko = [
                'K',
            ];

            for ($i = 0; $i < count($req->idDetail); $i++) {
                array_push($accountCodeToko, $accountLossToko->id);
                array_push($totalBayarToko, $req->totalAll[$i]);
                array_push($descriptionToko, 'Pengeluaran Toko Barang LOSS Detail');
                array_push($DKToko, 'D');
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
            return $th;
        }
        // return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
    }
    public function codeJournals($type)
    {
        $getEmployee =  Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('journals')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Kredit'
        );
        ServiceDetail::where('service_id', $id)->destroy($id);
        return Response::json(['status' => 'success']);
    }
    public function serviceFormUpdateStatus()
    {
        $data     = Service::where('technician_id', Auth::user()->id)->get();
        $employee = Employee::get();
        return view('pages.backend.transaction.service.indexFormUpdateService', compact('data', 'employee'));
    }
    public function serviceFormUpdateStatusLoadData(Request $req)
    {
        $data = Service::with(['ServiceDetail', 'ServiceDetail.Items', 'ServiceStatusMutation', 'ServiceStatusMutation.Technician'])->where('id', $req->id)->first();

        if ($data == null) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message]);
    }

    public function serviceFormUpdateStatusSaveData(Request $req)
    {
        try {
            // return $req->all();
            $index = ServiceStatusMutation::where('service_id', $req->id)->count() + 1;
            if ($req->status == 'Mutasi') {
                $technician_replacement_id = $req->technicianId;
            } else {
                $technician_replacement_id = null;
            }


            Service::where('id', $req->id)->update([
                'work_status' => $req->status,
                'technician_replacement_id' => $technician_replacement_id,
            ]);
            ServiceStatusMutation::create([
                'service_id' => $req->id,
                'technician_id' => Auth::user()->id,
                'index' => $index,
                'status' => $req->status,
                'description' => $req->description,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            return Response::json(['status' => 'success', 'message' => 'Sukses Menyimpan Data']);
        } catch (\Throwable $th) {
            return Response::json(['status' => 'error', 'message' => $th]);
        }
    }
}