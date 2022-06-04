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

    public function index(Request $req)
    {
        $data = Service::where('technician_id', Auth::user()->id)->get();
        $accountMain = AccountMainDetail::where('main_id',1)->get();
        $accountData = AccountData::get();
        $employee = Employee::get();
        return view('pages.backend.finance.sharing_profit.sharingProfit', compact('data', 'employee','accountData','accountMain'));
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
            
            // if ($checkTotalBelumBayar == 0) {
            //     DB::rollback();
            //     return Response::json(['status' => 'fail', 'message' => 'Semua Telah dibayar']);
            // }

            // return $req->all();
            // $checkData = SharingProfit::where('date_start', $this->DashboardController->changeMonthIdToEn($req->startDate))
            //     ->where('date_end', $this->DashboardController->changeMonthIdToEn($req->endDate))
            //     ->where('employe_id', $req->technicianId)
            //     ->get();
            // if (count($checkData) != 0) {
            //     DB::rollback();
            //     return Response::json(['status' => 'fail', 'message' => 'Data Sudah Ada']);
            // }
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
                // 'updated_at'=>date('Y-m-d h:i:s'),
            ]);

            $accountSharingProfit  = AccountData::where('branch_id', Auth::user()->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 7)
                ->where('main_detail_id', 14)
                ->first();
            // $accountKas            = AccountData::where('active', 'Y')
            //     ->where('main_id', $req->accountMain)
            //     ->where('main_detail_id',$req->accountData)
            //     ->first();
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

    public function edit($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.editService', ['Service' => $Service, 'member' => $member]);
    }
    public function printService($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.printService', ['Service' => $Service, 'member' => $member]);
    }

    // public function update($id, Request $req)
    // {

    //     Service::where('id', $id)
    //         ->update([
    //         'sales_id'   => $req->salesId,
    //         'liquid_date'=> date('Y-m-d',strtotime($req->liquidDate)),
    //         'total'      => str_replace(",", '',$req->total),
    //         'updated_by' => Auth::user()->name,
    //         'updated_at' => date('Y-m-d h:i:s'),
    //     ]);

    //     $Service = Service::find($id);
    //     $this->DashboardController->createLog(
    //         $req->header('user-agent'),
    //         $req->ip(),
    //         'Mengubah Service ' . Service::find($id)->name
    //     );

    //     $Service->save();

    //     return Redirect::route('service.index')
    //         ->with([
    //             'status' => 'Berhasil merubah Dana Kredit',
    //             'type' => 'success'
    //         ]);
    // }

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
        $data = Service::where('technician_id', Auth::user()->id)->get();
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
