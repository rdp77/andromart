<?php

namespace App\Http\Controllers;

use App\Models\accountMain;
use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Warranty;
use App\Models\SharingProfit;
use App\Models\SharingProfitDetail;
use App\Models\ServiceDetail;
use App\Models\ServiceStatusMutation;
use App\Models\Journal;
use App\Models\JournalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;
use App\Models\accountData;
use App\Models\Branch;

// use DB;

class ReportIncomeStatementController extends Controller
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
        // return $req->dateS;
        if ($req->dateS == null) {
            $dateParams = date('F Y');
        } else {
            $dateParams = $req->dateS;
        }
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', date('Y-m-01', strtotime($dateParams)))
            ->where('date', '<=', date('Y-m-t', strtotime($dateParams)))
            ->get();




        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->get();

        $account = accountMain::with('accountMainDetail', 'accountMainDetail.accountData')->get();
        $accountData = accountData::get();
        $branch = Branch::get();
        // return $account;
        // return $accountData;
        $PendapatanKotor = 0;
        $Diskon = 0;
        $PendapatanBersih = 0;
        $HPP = 0;
        $listrik = 0;
        $gaji = 0;
        $atk = 0;
        $air = 0;
        $sharingProfit = 0;
        $sewaRuko = 0;
        $hosting = 0;
        $thr = 0;
        $meeting = 0;
        $internet = 0;
        $biayaSosial = 0;
        $meeting = 0;
        $wisata = 0;
        $qurban = 0;
        $sosialInternal = 0;
        $iuranBulanan = 0;
        $bebanSewa = 0;
        $operasional = 0;
        
        $data = [];
        for ($i = 0; $i < count($jurnal); $i++) {
            for ($j = 0; $j < count($jurnal[$i]->JournalDetail); $j++) {
                $data[] = $jurnal[$i]->JournalDetail[$j]->total;
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 5) {
                    $PendapatanBersih +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 8) {
                    $Diskon +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 29) {
                    $HPP +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 10) {
                    $listrik +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 15) {
                    $gaji +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 13) {
                    $air +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 14) {
                    $sharingProfit +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 16) {
                    $sewaRuko +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 17) {
                    $hosting +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 18) {
                    $thr +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 19) {
                    $meeting +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 20) {
                    $internet +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 23) {
                    $biayaSosial +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 24) {
                    $wisata +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 25) {
                    $qurban +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 26) {
                    $atk +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 21) {
                    $iuranBulanan +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 3) {
                    $operasional +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                
                
            }
        }
        $PendapatanKotor = $PendapatanBersih+$Diskon;
        $data = array();
        return view('pages.backend.report.reportIncomeStatement', compact('data','PendapatanKotor','PendapatanBersih','Diskon','HPP','listrik','atk','gaji','air',
        'sharingProfit',
        'sewaRuko',
        'hosting',
        'thr',
        'meeting',
        'internet',
        'biayaSosial',
        'wisata',
        'qurban','iuranBulanan','bebanSewa','operasional'));
    }
    public function printReportIncomeStatement (Request $req)
    {
        if ($req->dateS == null) {
            $dateParams = date('F Y');
        } else {
            $dateParams = $req->dateS;
        }
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', date('Y-m-01', strtotime($dateParams)))
            ->where('date', '<=', date('Y-m-t', strtotime($dateParams)))
            ->get();




        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->get();

        $account = accountMain::with('accountMainDetail', 'accountMainDetail.accountData')->get();
        $accountData = accountData::get();
        $branch = Branch::get();
        // return $account;
        // return $accountData;
        $PendapatanKotor = 0;
        $Diskon = 0;
        $PendapatanBersih = 0;
        $HPP = 0;
        $listrik = 0;
        $gaji = 0;
        $atk = 0;
        $air = 0;
        $sharingProfit = 0;
        $sewaRuko = 0;
        $hosting = 0;
        $thr = 0;
        $meeting = 0;
        $internet = 0;
        $biayaSosial = 0;
        $meeting = 0;
        $wisata = 0;
        $qurban = 0;
        $sosialInternal = 0;
        $iuranBulanan = 0;
        $bebanSewa = 0;
        $operasional = 0;
        
        $data = [];
        for ($i = 0; $i < count($jurnal); $i++) {
            for ($j = 0; $j < count($jurnal[$i]->JournalDetail); $j++) {
                $data[] = $jurnal[$i]->JournalDetail[$j]->total;
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 5) {
                    $PendapatanBersih +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 8) {
                    $Diskon +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 29) {
                    $HPP +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 10) {
                    $listrik +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 15) {
                    $gaji +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 13) {
                    $air +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 14) {
                    $sharingProfit +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 16) {
                    $sewaRuko +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 17) {
                    $hosting +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 18) {
                    $thr +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 19) {
                    $meeting +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 20) {
                    $internet +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 23) {
                    $biayaSosial +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 24) {
                    $wisata +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 25) {
                    $qurban +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 26) {
                    $atk +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 21) {
                    $iuranBulanan +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id  == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id  == 3) {
                    $operasional +=$jurnal[$i]->JournalDetail[$j]->total;
                }
                
                
            }
        }
        $PendapatanKotor = $PendapatanBersih+$Diskon;
        $data = array();
        return view('pages.backend.report.reportPrintIncomeStatement', compact('data','PendapatanKotor','PendapatanBersih','Diskon','HPP','listrik','atk','gaji','air',
        'sharingProfit',
        'sewaRuko',
        'hosting',
        'thr',
        'meeting',
        'internet',
        'biayaSosial',
        'wisata',
        'qurban','iuranBulanan','bebanSewa','operasional'));
    }
}
