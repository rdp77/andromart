<?php

namespace App\Http\Controllers;

use App\Models\AccountData;
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
// use DB;

class ReportCashBalanceController extends Controller
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
        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '<=', date('Y-m-d'))
            ->get();

        // return $data;
        $totalKasBankMukmin['K'] = [];
        $totalKasBankMukmin['D'] = [];
        $totalKasKecilMukmin['K'] = [];
        $totalKasKecilMukmin['D'] = [];
        $totalKasBankJenggolo['K'] = [];
        $totalKasBankJenggolo['D'] = [];
        $totalKasKecilJenggolo['K'] = [];
        $totalKasKecilJenggolo['D'] = [];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]->JournalDetail); $j++) {

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D'  && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['D'][$i] = $data[$i]->total;
                }
            }
        }
        $dataSaldoKas = $this->checkSaldoKas(date('Y-m-d'));
        // CEK TOTAL KAS J KECIL D K
        $totalKasKecilJenggoloValuesD = array_values($totalKasKecilJenggolo['D']);
        $totalKasKecilJenggoloValuesK = array_values($totalKasKecilJenggolo['K']);
        $totalKasKecilJenggoloValD = 0;
        $totalKasKecilJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesD); $i++) {
            $totalKasKecilJenggoloValD += $totalKasKecilJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesK); $i++) {
            $totalKasKecilJenggoloValK += $totalKasKecilJenggoloValuesK[$i];
        }
        $totalKasKecilJenggoloFix = $dataSaldoKas[1]['total'] + $totalKasKecilJenggoloValD - $totalKasKecilJenggoloValK;
        // return [$dataSaldoKas[1]['total'],$totalKasKecilJenggoloValD];
        // return $totalKasKecilJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasKecilMukminValuesD = array_values($totalKasKecilMukmin['D']);
        $totalKasKecilMukminValuesK = array_values($totalKasKecilMukmin['K']);
        $totalKasKecilMukminValD = 0;
        $totalKasKecilMukminValK = 0;
        for ($i = 0; $i < count($totalKasKecilMukminValuesD); $i++) {
            $totalKasKecilMukminValD += $totalKasKecilMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilMukminValuesK); $i++) {
            $totalKasKecilMukminValK += $totalKasKecilMukminValuesK[$i];
        }
        $totalKasKecilMukminFix = $dataSaldoKas[0]['total'] + $totalKasKecilMukminValD - $totalKasKecilMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // CEK TOTAL KAS J KECIL D K
        $totalKasBankJenggoloValuesD = array_values($totalKasBankJenggolo['D']);
        $totalKasBankJenggoloValuesK = array_values($totalKasBankJenggolo['K']);
        $totalKasBankJenggoloValD = 0;
        $totalKasBankJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasBankJenggoloValuesD); $i++) {
            $totalKasBankJenggoloValD += $totalKasBankJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankJenggoloValuesK); $i++) {
            $totalKasBankJenggoloValK += $totalKasBankJenggoloValuesK[$i];
        }
        $totalKasBankJenggoloFix =  $dataSaldoKas[3]['total'] + $totalKasBankJenggoloValD - $totalKasBankJenggoloValK;

        // return $totalKasBankJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasBankMukminValuesD = array_values($totalKasBankMukmin['D']);
        $totalKasBankMukminValuesK = array_values($totalKasBankMukmin['K']);
        $totalKasBankMukminValD = 0;
        $totalKasBankMukminValK = 0;
        for ($i = 0; $i < count($totalKasBankMukminValuesD); $i++) {
            $totalKasBankMukminValD += $totalKasBankMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankMukminValuesK); $i++) {
            $totalKasBankMukminValK += $totalKasBankMukminValuesK[$i];
        }
        $totalKasBankMukminFix =  $dataSaldoKas[2]['total'] + $totalKasBankMukminValD - $totalKasBankMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // return [$totalKasKecilMukminFix, $totalKasKecilJenggoloFix, $totalKasBankMukminFix, $totalKasBankJenggoloFix];

        $accountOpening = AccountData::with('accountMainDetail')->where('main_id', '1')->get();
        // return $accountOpening;
        $totalKCCJ = 0;
        $totalKCCM = 0;
        $totalKBCM = 0;
        $totalKBCJ = 0;
        // if ($accountOpening[0]->name == 'Kas Kecil Cabang Pusat') {
        //     if ($accountOpening[0]->opening_date < date('Y-m-d')) {
        //         $totalKCCJ =  $accountOpening[0]->opening_balance;
        //     }
        // } else if ($accountOpening[1]->name == 'Kas Kecil Cabang Mukmin') {
        //     if ($accountOpening[1]->opening_date < date('Y-m-d')) {
        //         $totalKCCM =  $accountOpening[1]->opening_balance;
        //     }
        // } else if ($accountOpening[2]->name == 'Kas Bank Cabang Pusat') {
        //     if ($accountOpening[2]->opening_date < date('Y-m-d')) {
        //         $totalKBCM =  $accountOpening[2]->opening_balance;
        //     }
        // } else if ($accountOpening[3]->name == 'Kas Bank Cabang Pusat') {
        //     if ($accountOpening[3]->opening_date < date('Y-m-d')) {
        //         $totalKBCJ =  $accountOpening[3]->opening_balance;
        //     }
        // }
     
        if ($accountOpening[0]->name == 'Kas Kecil Cabang Pusat') {
            if ($accountOpening[0]->opening_date >= date('Y-m-01') && $accountOpening[0]->opening_date <= date('Y-m-d')) {
                $totalKCCJ =  $accountOpening[0]->opening_balance;
            }
        } 
         if ($accountOpening[1]->name == 'Kas Kecil Cabang Mukmin') {
            if ($accountOpening[1]->opening_date >= date('Y-m-01') && $accountOpening[1]->opening_date <= date('Y-m-d')) {
                $totalKCCM =  $accountOpening[1]->opening_balance;
            }
        } 
         if ($accountOpening[2]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[2]->opening_date >= date('Y-m-01') && $accountOpening[2]->opening_date <= date('Y-m-d')) {
                $totalKBCM =  $accountOpening[2]->opening_balance;
            }
        } 
         if ($accountOpening[3]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[3]->opening_date >= date('Y-m-01') && $accountOpening[3]->opening_date <= date('Y-m-d')) {
                $totalKBCJ =  $accountOpening[3]->opening_balance;
            }
        }
        // return$totalKCCM;

        $dtFix = [
            ['total' => $totalKasKecilMukminFix + $totalKCCM, 'nama' => 'Kas Kecil Cabang Mukmin'],
            ['total' => $totalKasKecilJenggoloFix + $totalKCCJ, 'nama' => 'Kas Kecil Cabang Jenggolo'],
            ['total' => $totalKasBankMukminFix + $totalKBCM, 'nama' => 'Kas Bank JAGO Cabang Mukmin'],
            ['total' => $totalKasBankJenggoloFix + $totalKBCJ, 'nama' => 'Kas Bank Cabang Jenggolo']
        ];
        return view('pages.backend.report.reportCashBalance', compact('dtFix'));
    }
    public function searchReportCashBalance(Request $req)
    {
        // return $req->all();
        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
            ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
            ->get();

        // return $data;
        $totalKasBankMukmin['K'] = [];
        $totalKasBankMukmin['D'] = [];
        $totalKasKecilMukmin['K'] = [];
        $totalKasKecilMukmin['D'] = [];
        $totalKasBankJenggolo['K'] = [];
        $totalKasBankJenggolo['D'] = [];
        $totalKasKecilJenggolo['K'] = [];
        $totalKasKecilJenggolo['D'] = [];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]->JournalDetail); $j++) {

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D'  && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['D'][$i] = $data[$i]->total;
                }
            }
        }
        // Cek Data Saldo Kas Sebelumnya
        $dataSaldoKas = $this->checkSaldoKas($req->dateS);

        // CEK TOTAL KAS J KECIL D K
        $totalKasKecilJenggoloValuesD = array_values($totalKasKecilJenggolo['D']);
        $totalKasKecilJenggoloValuesK = array_values($totalKasKecilJenggolo['K']);
        $totalKasKecilJenggoloValD = 0;
        $totalKasKecilJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesD); $i++) {
            $totalKasKecilJenggoloValD += $totalKasKecilJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesK); $i++) {
            $totalKasKecilJenggoloValK += $totalKasKecilJenggoloValuesK[$i];
        }
        $totalKasKecilJenggoloFix = $dataSaldoKas[1]['total'] + $totalKasKecilJenggoloValD - $totalKasKecilJenggoloValK;

        // return $totalKasKecilJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasKecilMukminValuesD = array_values($totalKasKecilMukmin['D']);
        $totalKasKecilMukminValuesK = array_values($totalKasKecilMukmin['K']);
        $totalKasKecilMukminValD = 0;
        $totalKasKecilMukminValK = 0;
        for ($i = 0; $i < count($totalKasKecilMukminValuesD); $i++) {
            $totalKasKecilMukminValD += $totalKasKecilMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilMukminValuesK); $i++) {
            $totalKasKecilMukminValK += $totalKasKecilMukminValuesK[$i];
        }
        $totalKasKecilMukminFix = $dataSaldoKas[0]['total'] + $totalKasKecilMukminValD - $totalKasKecilMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // CEK TOTAL KAS J KECIL D K
        $totalKasBankJenggoloValuesD = array_values($totalKasBankJenggolo['D']);
        $totalKasBankJenggoloValuesK = array_values($totalKasBankJenggolo['K']);
        $totalKasBankJenggoloValD = 0;
        $totalKasBankJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasBankJenggoloValuesD); $i++) {
            $totalKasBankJenggoloValD += $totalKasBankJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankJenggoloValuesK); $i++) {
            $totalKasBankJenggoloValK += $totalKasBankJenggoloValuesK[$i];
        }
        $totalKasBankJenggoloFix = $dataSaldoKas[3]['total'] + $totalKasBankJenggoloValD - $totalKasBankJenggoloValK;

        // return $totalKasBankJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasBankMukminValuesD = array_values($totalKasBankMukmin['D']);
        $totalKasBankMukminValuesK = array_values($totalKasBankMukmin['K']);
        $totalKasBankMukminValD = 0;
        $totalKasBankMukminValK = 0;
        for ($i = 0; $i < count($totalKasBankMukminValuesD); $i++) {
            $totalKasBankMukminValD += $totalKasBankMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankMukminValuesK); $i++) {
            $totalKasBankMukminValK += $totalKasBankMukminValuesK[$i];
        }
        $totalKasBankMukminFix = $dataSaldoKas[2]['total'] + $totalKasBankMukminValD - $totalKasBankMukminValK;
        // return $totalKasKecilMukminFix;

        $accountOpening = AccountData::with('accountMainDetail')->where('main_id', '1')->get();
        // return $accountOpening;
        $totalKCCJ = 0;
        $totalKCCM = 0;
        $totalKBCM = 0;
        $totalKBCJ = 0;
        if ($accountOpening[0]->name == 'Kas Kecil Cabang Pusat') {
            if ($accountOpening[0]->opening_date >= date('Y-m-01', strtotime($req->dateS)) && $accountOpening[0]->opening_date <= date('Y-m-t', strtotime($req->dateS))) {
                $totalKCCJ =  $accountOpening[0]->opening_balance;
            }
        } 
         if ($accountOpening[1]->name == 'Kas Kecil Cabang Mukmin') {
            if ($accountOpening[1]->opening_date >= date('Y-m-01', strtotime($req->dateS)) && $accountOpening[1]->opening_date <= date('Y-m-t', strtotime($req->dateS))) {
                $totalKCCM =  $accountOpening[1]->opening_balance;
            }
        } 
         if ($accountOpening[2]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[2]->opening_date >= date('Y-m-01', strtotime($req->dateS)) && $accountOpening[2]->opening_date <= date('Y-m-t', strtotime($req->dateS))) {
                $totalKBCM =  $accountOpening[2]->opening_balance;
            }
        } 
         if ($accountOpening[3]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[3]->opening_date >= date('Y-m-01', strtotime($req->dateS)) && $accountOpening[3]->opening_date <= date('Y-m-t', strtotime($req->dateS))) {
                $totalKBCJ =  $accountOpening[3]->opening_balance;
            }
        }
        // return$totalKCCJ;

        // return['debet'=>$totalKasKecilJenggoloValD,'kredit'=>$totalKasKecilJenggoloValK,'total'=>$totalKasKecilJenggoloFix,'saldoSebelumnya'=>$dataSaldoKas[0]['total'],'openingBalance'=>$totalKCCJ];


        // return [$totalKasKecilMukminFix, $totalKasKecilJenggoloFix, $totalKasBankMukminFix, $totalKasBankJenggoloFix];
        $dtFix = [
            ['total' =>  $totalKasKecilMukminFix + $totalKCCM, 'nama' => 'Kas Kecil Cabang Mukmin'],
            ['total' =>  $totalKasKecilJenggoloFix + $totalKCCJ, 'nama' => 'Kas Kecil Cabang Jenggolo'],
            ['total' =>  $totalKasBankMukminFix + $totalKBCM, 'nama' => 'Kas Bank JAGO Cabang Mukmin'],
            ['total' =>  $totalKasBankJenggoloFix + $totalKBCJ, 'nama' => 'Kas Bank Cabang Jenggolo']
        ];

        // if(count($data) == 0){
        // $message = 'empty';
        // }else{
        $message = 'exist';
        // }

        return Response::json(['status' => 'success', 'result' => $dtFix, 'message' => $message, 'date' => $req->dateS]);
    }
    public function checkSaldoKas($date)
    {
        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '<=', date('Y-m-01', strtotime($date)))
            // ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
            ->get();

        // return $data;
        $totalKasBankMukmin['K'] = [];
        $totalKasBankMukmin['D'] = [];
        $totalKasKecilMukmin['K'] = [];
        $totalKasKecilMukmin['D'] = [];
        $totalKasBankJenggolo['K'] = [];
        $totalKasBankJenggolo['D'] = [];
        $totalKasKecilJenggolo['K'] = [];
        $totalKasKecilJenggolo['D'] = [];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]->JournalDetail); $j++) {

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D'  && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['D'][$i] = $data[$i]->total;
                }
            }
        }
        // CEK TOTAL KAS J KECIL D K
        $totalKasKecilJenggoloValuesD = array_values($totalKasKecilJenggolo['D']);
        $totalKasKecilJenggoloValuesK = array_values($totalKasKecilJenggolo['K']);
        $totalKasKecilJenggoloValD = 0;
        $totalKasKecilJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesD); $i++) {
            $totalKasKecilJenggoloValD += $totalKasKecilJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesK); $i++) {
            $totalKasKecilJenggoloValK += $totalKasKecilJenggoloValuesK[$i];
        }
        $totalKasKecilJenggoloFix = $totalKasKecilJenggoloValD - $totalKasKecilJenggoloValK;

        // return $totalKasKecilJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasKecilMukminValuesD = array_values($totalKasKecilMukmin['D']);
        $totalKasKecilMukminValuesK = array_values($totalKasKecilMukmin['K']);
        $totalKasKecilMukminValD = 0;
        $totalKasKecilMukminValK = 0;
        for ($i = 0; $i < count($totalKasKecilMukminValuesD); $i++) {
            $totalKasKecilMukminValD += $totalKasKecilMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilMukminValuesK); $i++) {
            $totalKasKecilMukminValK += $totalKasKecilMukminValuesK[$i];
        }
        $totalKasKecilMukminFix = $totalKasKecilMukminValD - $totalKasKecilMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // CEK TOTAL KAS J KECIL D K
        $totalKasBankJenggoloValuesD = array_values($totalKasBankJenggolo['D']);
        $totalKasBankJenggoloValuesK = array_values($totalKasBankJenggolo['K']);
        $totalKasBankJenggoloValD = 0;
        $totalKasBankJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasBankJenggoloValuesD); $i++) {
            $totalKasBankJenggoloValD += $totalKasBankJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankJenggoloValuesK); $i++) {
            $totalKasBankJenggoloValK += $totalKasBankJenggoloValuesK[$i];
        }
        $totalKasBankJenggoloFix = $totalKasBankJenggoloValD - $totalKasBankJenggoloValK;

        // return $totalKasBankJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasBankMukminValuesD = array_values($totalKasBankMukmin['D']);
        $totalKasBankMukminValuesK = array_values($totalKasBankMukmin['K']);
        $totalKasBankMukminValD = 0;
        $totalKasBankMukminValK = 0;
        for ($i = 0; $i < count($totalKasBankMukminValuesD); $i++) {
            $totalKasBankMukminValD += $totalKasBankMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankMukminValuesK); $i++) {
            $totalKasBankMukminValK += $totalKasBankMukminValuesK[$i];
        }
        $totalKasBankMukminFix = $totalKasBankMukminValD - $totalKasBankMukminValK;
        $accountOpening = AccountData::with('accountMainDetail')->where('main_id', '1')->get();
        // return $accountOpening;
        $totalKCCJ = 0;
        $totalKCCM = 0;
        $totalKBCM = 0;
        $totalKBCJ = 0;
        if ($accountOpening[0]->name == 'Kas Kecil Cabang Pusat') {
            if ($accountOpening[0]->opening_date <= date('Y-m-01', strtotime($date))) {
                $totalKCCJ =  $accountOpening[0]->opening_balance;
            }
        }
        if ($accountOpening[1]->name == 'Kas Kecil Cabang Mukmin') {
            if ($accountOpening[1]->opening_date <= date('Y-m-01', strtotime($date))) {
                $totalKCCM =  $accountOpening[1]->opening_balance;
            }
        }
        if ($accountOpening[2]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[2]->opening_date <= date('Y-m-01', strtotime($date))) {
                $totalKBCM =  $accountOpening[2]->opening_balance;
            }
        }
        if ($accountOpening[3]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[3]->opening_date <= date('Y-m-01', strtotime($date))) {
                $totalKBCJ =  $accountOpening[3]->opening_balance;
            }
        }
        // return $totalKCCM;
        $dtFix = [
            ['total' => $totalKasKecilMukminFix + $totalKCCM, 'nama' => 'Kas Kecil Cabang Mukmin'],
            ['total' => $totalKasKecilJenggoloFix + $totalKCCJ, 'nama' => 'Kas Kecil Cabang Jenggolo'],
            ['total' => $totalKasBankMukminFix + $totalKBCM, 'nama' => 'Kas Bank JAGO Cabang Mukmin'],
            ['total' => $totalKasBankJenggoloFix + $totalKBCJ, 'nama' => 'Kas Bank Cabang Jenggolo']
        ];

        return $dtFix;
    }
}
