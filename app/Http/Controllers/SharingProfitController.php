<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Service;
use App\Models\SharingProfit;
use App\Models\SharingProfitDetail;
use App\Models\ServiceDetail;
use App\Models\SaleDetail;

use App\Models\AccountData;
use App\Models\AccountMainDetail;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\ServiceStatusMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\carbon;
// use DB;
use Yajra\DataTables\DataTables;

class SharingProfitController extends Controller
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

    // public function index(Request $req)
    // {
    //     $data = Service::where('technician_id', Auth::user()->id)->get();
    //     $accountMain = AccountMainDetail::where('main_id',1)->get();
    //     $accountData = AccountData::get();
    //     $employee = Employee::get();
    //     return view('pages.backend.finance.sharing_profit.sharingProfit', compact('data', 'employee','accountData','accountMain'));
    // }
    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(4, 'view');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }
        if ($req->ajax()) {
            $data = SharingProfit::with(['Technician'])
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
                    $actionBtn .= '<a class="dropdown-item" href="' . route('sharing-profit.show', $row->id) . '"><i class="far fa-eye"></i> Lihat</a>';
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
                        ->isoFormat('LL'). ' S/D  '.Carbon::parse($row->date_end)
                        ->locale('id')
                        ->isoFormat('LL');
                })
                ->addColumn('totalValue', function ($row) {
                    return number_format($row->total, 0, '.', ',');
                })
                ->rawColumns(['action', 'dateRange', 'dateFormat','totalValue'])
                ->make(true);
        }

        return view('pages.backend.finance.sharingProfit.indexSharingProfit');
    }
    public function create()
    {
        $data = Service::where('technician_id', Auth::user()->id)->get();
        $accountMain = AccountMainDetail::where('main_id',1)->get();
        $accountData = AccountData::get();
        $employee = Employee::get();
        return view('pages.backend.finance.sharingProfit.createSharingProfit', compact('data', 'employee','accountData','accountMain'));
    }
    public function sharingProfitLoadDataService(Request $req)
    {
        // return $req->all();
        $date1 = $this->DashboardController->changeMonthIdToEn($req->dateS);
        $date2 = $this->DashboardController->changeMonthIdToEn($req->dateE);
        $data = Service::with(['ServiceDetail', 'ServiceDetail.Items', 'ServiceStatusMutation', 'ServiceStatusMutation.Technician', 'SharingProfitDetail', 'SharingProfitDetail.SharingProfit'])
            // ->whereHas('ServicePayment', function ($query) use ($date1,$date2) {
            //     // return $query->where('IDUser', '=', 1);
            //     return $query->where('date', '>=',$date1)
            //                  ->where('date', '<=',$date2);
            // })
            ->where('payment_date', '>=', $this->DashboardController->changeMonthIdToEn($req->dateS))
            ->where('payment_date', '<=', $this->DashboardController->changeMonthIdToEn($req->dateE))
            ->where('work_status', 'Diambil')
            ->where('payment_status', 'Lunas')
            ->where(function ($query) use ($req) {
                $query->where('technician_id', $req->id)
                    ->orWhere('technician_replacement_id', $req->id);
            })
            ->orderBy('payment_date','ASC')
            ->get();

        $sharingProfitSaleSales = SaleDetail::with(['sale'])
            ->whereHas('sale', function ($q) use ($date1, $date2) {
                $q->where('date', '>=', $date1); // '=' is optional
                $q->where('date', '<=', $date2); // '=' is optional
            })->with('sale.SharingProfitDetail', 'sale.SharingProfitDetail.SharingProfit')
            ->where('sales_id', $req->id)
            ->get();

        $sharingProfitSaleBuyer = SaleDetail::with('sale')
            ->whereHas('sale', function ($q) use ($date1, $date2) {
                $q->where('date', '>=', $date1); // '=' is optional
                $q->where('date', '<=', $date2); // '=' is optional
            })->with('sale.SharingProfitDetail', 'sale.SharingProfitDetail.SharingProfit')
            ->where('buyer_id', $req->id)
            ->get();
        // return $sharingProfitSaleSales;
        $checkdataExist = count($data) + count($sharingProfitSaleSales) + count($sharingProfitSaleBuyer);
        if ($checkdataExist == 0) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message, 'sharingProfitSaleSales' => $sharingProfitSaleSales, 'sharingProfitSaleBuyer' => $sharingProfitSaleBuyer]);
    }
    public function code($type, $index)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        // $index = DB::table('service')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $year . $month . $index;
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
    public function store(Request $req)
    {
        // return $req->all();  
        DB::beginTransaction();
        try {
            $checkTotalBelumBayar = 0;
            for ($i = 0; $i < count($req->payDetail); $i++) {
                if ($req->payDetail[$i] == 'Belum Bayar') {
                    $checkTotalBelumBayar+=$i;
                }
            }
            
            $getEmployee =  Employee::with('branch')->where('user_id', $req->technicianId)->first();

            $index = DB::table('sharing_profit')->max('id') + 1;
            $kode = $this->code('SHP', $index);
            SharingProfit::create([
                // 'id' => $index,
                'code' => $kode,
                'date' => date('Y-m-d'),
                'date_start' => $this->DashboardController->changeMonthIdToEn($req->startDate),
                'date_end' => $this->DashboardController->changeMonthIdToEn($req->endDate),
                'employe_id' => $req->technicianId,
                'total' => $req->totalValue,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);


            $idJournal = DB::table('journals')->max('id') + 1;
            Journal::create([
                'id' => $idJournal,
                'code' => $this->codeJournals('KK', $idJournal),
                'year' => date('Y'),
                'date' => date('Y-m-d'),
                'type' => 'Biaya',
                'total' => str_replace(",", '', $req->totalValue),
                'ref' => $kode,
                'description' => 'Pembagian Sharing Profit',
                'created_at' => date('Y-m-d h:i:s'),

            ]);

            $cariCabang = AccountData::where('id', $req->accountData)->first();
 
            $accountSharingProfit  = AccountData::where('branch_id', $cariCabang->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 7)
                ->where('main_detail_id', 14)
                ->first();

            $accountCode = [
                $req->accountData,
            ];
            $totalBayar = [
                str_replace(",", '', $req->totalValue),
            ];
            $description = [
                'Pengeluaran Untuk Sharing Profit',
            ];
            $DK = [
                'K',
            ];

            for ($i = 0; $i < count($req->codeDetail); $i++) {
                if ($req->payDetail[$i] == 'Belum Bayar') {
                    SharingProfitDetail::create([
                        // 'id' => $i + 1,
                        'sharing_profit_id' => $index,
                        'type' => $req->typeDetail[$i],
                        'ref' => $req->codeDetail[$i],
                        'total' => $req->totalDetail[$i],
                        'created_by' => Auth::user()->name,
                        'created_at' => date('Y-m-d h:i:s'),
                    ]);
                    array_push($accountCode, $accountSharingProfit->id);
                    array_push($totalBayar, $req->totalDetail[$i]);
                    array_push($description, 'Pembagian Sharing Profit Detail');
                    array_push($DK, 'D');
                }
            }
            // return [$DK, $description,$totalBayar,$accountCode];


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

            DB::commit();
            return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }


    public function show($id)
    {
        $data = SharingProfit::with('SharingProfitDetail','SharingProfitDetail.Service','SharingProfitDetail.Sale')->where('id', $id)->first();
        // return $data;
        return view('pages.backend.finance.sharingProfit.showSharingProfit', ['data' => $data]);
    }

    public function destroy(Request $req, $id)
    {
      
        DB::beginTransaction();
        try {
            $this->DashboardController->createLog($req->header('user-agent'), $req->ip(), 'Menghapus Data Sharing Profit');
            $checkSharingProfit = DB::table('sharing_profit')
                ->where('id', $id)
                ->first();
            $checkJournals = DB::table('journals')
                ->where('ref', $checkSharingProfit->code)
                ->get();
           
            DB::table('journals')
                ->where('id', $checkJournals[0]->id)
                ->delete();

            DB::table('journal_details')
                ->where('journal_id', $checkJournals[0]->id)
                ->delete();

            DB::table('sharing_profit')
                ->where('id', $id)
                ->delete();

            DB::table('sharing_profit_detail')
                ->where('sharing_profit_id', $id)
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
    public function sharingProfitCheckJournals(Request $req)
    {
        $data = Journal::with('JournalDetail.AccountData')
            ->where('ref', $req->id)
            ->get();
        return Response::json(['status' => 'success', 'jurnal' => $data]);
    }
}
