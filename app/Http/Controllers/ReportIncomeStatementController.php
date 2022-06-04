<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccountMain;
use App\Models\AccountMainDetail;
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

        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

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
        $totalService = 0;
        $totalPenjualan = 0;
        $DiskonPenjualan = 0;
        $DiskonService = 0;

        $data = [];
        for ($i = 0; $i < count($jurnal); $i++) {
            for ($j = 0; $j < count($jurnal[$i]->JournalDetail); $j++) {
                $data[] = $jurnal[$i]->JournalDetail[$j]->total;
                
                if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6' || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == '5') {
                    $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                    $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                }

                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 5) {
                    $PendapatanBersih += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 8) {
                    $Diskon += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 30) {
                    $DiskonPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 31) {
                    $DiskonService += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29) {
                    $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 10) {
                    $listrik += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15) {
                    $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 13) {
                    $air += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14) {
                    $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 16) {
                    $sewaRuko += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 17) {
                    $hosting += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 18) {
                    $thr += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 19) {
                    $meeting += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 20) {
                    $internet += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 23) {
                    $biayaSosial += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 24) {
                    $wisata += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 25) {
                    $qurban += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 26) {
                    $atk += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 21) {
                    $iuranBulanan += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 3) {
                    $operasional += $jurnal[$i]->JournalDetail[$j]->total;
                }
            }
        }

        $accountDataBiaya = AccountData::where('main_id',6)->get();
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            // ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
            ->where('date', '>=', date('Y-m-01', strtotime($dateParams)))
            ->where('date', '<=', date('Y-m-t', strtotime($dateParams)))
            // ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
            ->get();

        $dataBiaya = [];
        for ($i=0; $i <count($accountDataBiaya) ; $i++) { 
            if (
                
                $accountDataBiaya[$i]->opening_date <= date('Y-m-t', strtotime($req->dateS)) 
                // && $accountDataBiaya[$i]->opening_date >= date('Y-m-01', strtotime($req->dateS))
            ) {
                $dataBiaya[$i]['total'] = $accountDataBiaya[$i]->opening_balance;
            }else{
                $dataBiaya[$i]['total'] = 0;
            }
            $dataBiaya[$i]['akun'] = $accountDataBiaya[$i]->main_detail_id;
            $dataBiaya[$i]['namaAkun'] = $accountDataBiaya[$i]->name;
            $dataBiaya[$i]['jurnal'] = [];
            $dataBiaya[$i]['dk'] = [];
            for ($j=0; $j <count($jurnal) ; $j++) {
                for ($k=0; $k <count($jurnal[$j]->JournalDetail) ; $k++) { 
                    if ($accountDataBiaya[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataBiaya[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataBiaya[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataBiaya[$i]['jurnal'],$jurnal[$j]->total);
                        // array_push($dataBiaya[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataBiaya[$i]['dk'],$jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataBiaya[$i]['total'] += $jurnal[$j]->total;
                        }else{
                            $dataBiaya[$i]['total'] -= $jurnal[$j]->total;
                        }
                    }
                } 
            }
        }

        $accountDataBiaya = AccountData::where('main_id',7)->get();
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            // ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
            ->where('date', '>=', date('Y-m-01', strtotime($dateParams)))
            ->where('date', '<=', date('Y-m-t', strtotime($dateParams)))
            // ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
            ->get();

        $dataBeban = [];
        for ($i=0; $i <count($accountDataBiaya) ; $i++) { 
            if (
                
                $accountDataBiaya[$i]->opening_date <= date('Y-m-t', strtotime($req->dateS)) 
                // && $accountDataBiaya[$i]->opening_date >= date('Y-m-01', strtotime($req->dateS))
            ) {
                $dataBeban[$i]['total'] = $accountDataBiaya[$i]->opening_balance;
            }else{
                $dataBeban[$i]['total'] = 0;
            }
            $dataBeban[$i]['akun'] = $accountDataBiaya[$i]->main_detail_id;
            $dataBeban[$i]['namaAkun'] = $accountDataBiaya[$i]->name;
            $dataBeban[$i]['jurnal'] = [];
            $dataBeban[$i]['dk'] = [];
            for ($j=0; $j <count($jurnal) ; $j++) {
                for ($k=0; $k <count($jurnal[$j]->JournalDetail) ; $k++) { 
                    if ($accountDataBiaya[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataBiaya[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataBeban[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataBeban[$i]['jurnal'],$jurnal[$j]->total);
                        // array_push($dataBeban[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataBeban[$i]['dk'],$jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataBeban[$i]['total'] += $jurnal[$j]->total;
                        }else{
                            $dataBeban[$i]['total'] -= $jurnal[$j]->total;
                        }
                    }
                } 
            }
        }
        // return $data;

        $PendapatanKotor = $PendapatanBersih + $Diskon;
        // $data = [];
        return view('pages.backend.report.reportIncomeStatement', compact('data', 'PendapatanKotor', 'PendapatanBersih', 'Diskon', 'HPP', 'listrik', 'atk', 'gaji', 'air', 'sharingProfit', 'sewaRuko', 'hosting', 'thr', 'meeting', 'internet', 'biayaSosial', 'wisata', 'qurban', 'iuranBulanan', 'bebanSewa', 'operasional','totalService','totalPenjualan','DiskonPenjualan','DiskonService','dataBiaya','dataBeban'));
    }
    public function printReportIncomeStatement(Request $req)
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

        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

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
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 5) {
                    $PendapatanBersih += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 8) {
                    $Diskon += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29) {
                    $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 10) {
                    $listrik += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15) {
                    $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 13) {
                    $air += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14) {
                    $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 16) {
                    $sewaRuko += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 17) {
                    $hosting += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 18) {
                    $thr += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 19) {
                    $meeting += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 20) {
                    $internet += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 23) {
                    $biayaSosial += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 24) {
                    $wisata += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 25) {
                    $qurban += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 26) {
                    $atk += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 21) {
                    $iuranBulanan += $jurnal[$i]->JournalDetail[$j]->total;
                }
                if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 3) {
                    $operasional += $jurnal[$i]->JournalDetail[$j]->total;
                }
            }
        }
        $PendapatanKotor = $PendapatanBersih + $Diskon;
        $data = [];
        return view('pages.backend.report.reportPrintIncomeStatement', compact('data', 'PendapatanKotor', 'PendapatanBersih', 'Diskon', 'HPP', 'listrik', 'atk', 'gaji', 'air', 'sharingProfit', 'sewaRuko', 'hosting', 'thr', 'meeting', 'internet', 'biayaSosial', 'wisata', 'qurban', 'iuranBulanan', 'bebanSewa', 'operasional'));
    }
}
