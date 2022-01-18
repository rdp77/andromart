<?php

namespace App\Http\Controllers;

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
        $data = Journal::with('JournalDetail','JournalDetail.AccountData')
        ->where('date','<=',date('Y-m-d'))
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
        for ($i=0; $i <count($data) ; $i++) { 
            for ($j=0; $j <count($data[$i]->JournalDetail) ; $j++) {

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasKecilMukmin['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D'  && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasKecilMukmin['D'][$i] = $data[$i]->total; 
                }

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasKecilJenggolo['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasKecilJenggolo['D'][$i] = $data[$i]->total; 
                }

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K'&& $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasBankMukmin['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasBankMukmin['D'][$i] = $data[$i]->total; 
                }

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasBankJenggolo['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasBankJenggolo['D'][$i] = $data[$i]->total; 
                }
            }
        }
        // CEK TOTAL KAS J KECIL D K
        $totalKasKecilJenggoloValuesD = array_values($totalKasKecilJenggolo['D']);
        $totalKasKecilJenggoloValuesK = array_values($totalKasKecilJenggolo['K']);
        $totalKasKecilJenggoloValD = 0;
        $totalKasKecilJenggoloValK = 0;
        for ($i=0; $i <count($totalKasKecilJenggoloValuesD) ; $i++) { 
            $totalKasKecilJenggoloValD += $totalKasKecilJenggoloValuesD[$i];
        }
        for ($i=0; $i <count($totalKasKecilJenggoloValuesK) ; $i++) { 
            $totalKasKecilJenggoloValK += $totalKasKecilJenggoloValuesK[$i];
        }
        $totalKasKecilJenggoloFix = $totalKasKecilJenggoloValD-$totalKasKecilJenggoloValK;

        // return $totalKasKecilJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasKecilMukminValuesD = array_values($totalKasKecilMukmin['D']);
        $totalKasKecilMukminValuesK = array_values($totalKasKecilMukmin['K']);
        $totalKasKecilMukminValD = 0;
        $totalKasKecilMukminValK = 0;
        for ($i=0; $i <count($totalKasKecilMukminValuesD) ; $i++) { 
            $totalKasKecilMukminValD += $totalKasKecilMukminValuesD[$i];
        }
        for ($i=0; $i <count($totalKasKecilMukminValuesK) ; $i++) { 
            $totalKasKecilMukminValK += $totalKasKecilMukminValuesK[$i];
        }
        $totalKasKecilMukminFix = $totalKasKecilMukminValD-$totalKasKecilMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // CEK TOTAL KAS J KECIL D K
        $totalKasBankJenggoloValuesD = array_values($totalKasBankJenggolo['D']);
        $totalKasBankJenggoloValuesK = array_values($totalKasBankJenggolo['K']);
        $totalKasBankJenggoloValD = 0;
        $totalKasBankJenggoloValK = 0;
        for ($i=0; $i <count($totalKasBankJenggoloValuesD) ; $i++) { 
            $totalKasBankJenggoloValD += $totalKasBankJenggoloValuesD[$i];
        }
        for ($i=0; $i <count($totalKasBankJenggoloValuesK) ; $i++) { 
            $totalKasBankJenggoloValK += $totalKasBankJenggoloValuesK[$i];
        }
        $totalKasBankJenggoloFix = $totalKasBankJenggoloValD-$totalKasBankJenggoloValK;

        // return $totalKasBankJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasBankMukminValuesD = array_values($totalKasBankMukmin['D']);
        $totalKasBankMukminValuesK = array_values($totalKasBankMukmin['K']);
        $totalKasBankMukminValD = 0;
        $totalKasBankMukminValK = 0;
        for ($i=0; $i <count($totalKasBankMukminValuesD) ; $i++) { 
            $totalKasBankMukminValD += $totalKasBankMukminValuesD[$i];
        }
        for ($i=0; $i <count($totalKasBankMukminValuesK) ; $i++) { 
            $totalKasBankMukminValK += $totalKasBankMukminValuesK[$i];
        }
        $totalKasBankMukminFix = $totalKasBankMukminValD-$totalKasBankMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;


        $dtFix = [
        ['total'=>$totalKasKecilMukminFix,'nama'=>'Kas Kecil Cabang Mukmin'],
        ['total'=>$totalKasKecilJenggoloFix,'nama'=>'Kas Kecil Cabang Jenggolo'],
        ['total'=>$totalKasBankMukminFix,'nama'=>'Kas Bank Cabang Mukmin'],
        ['total'=>$totalKasBankJenggoloFix,'nama'=>'Kas Bank Cabang Jenggolo']];
        return view('pages.backend.report.reportCashBalance',compact('dtFix'));
    }
  
    public function searchReportIncomeSpending(Request $req)
    {
        // return $req->all();
        $data = Journal::with('JournalDetail','JournalDetail.AccountData')
        ->where('date','>=',date('Y-m-01',strtotime($req->dateS)))
        ->where('date','<=',date('Y-m-t',strtotime($req->dateS)))
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
        for ($i=0; $i <count($data) ; $i++) { 
            for ($j=0; $j <count($data[$i]->JournalDetail) ; $j++) {

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasKecilMukmin['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D'  && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasKecilMukmin['D'][$i] = $data[$i]->total; 
                }

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasKecilJenggolo['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasKecilJenggolo['D'][$i] = $data[$i]->total; 
                }

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K'&& $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasBankMukmin['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2){
                    $totalKasBankMukmin['D'][$i] = $data[$i]->total; 
                }

                if($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasBankJenggolo['K'][$i] = $data[$i]->total; 
                }
                else if($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1){
                    $totalKasBankJenggolo['D'][$i] = $data[$i]->total; 
                }
            }
        }
        // CEK TOTAL KAS J KECIL D K
        $totalKasKecilJenggoloValuesD = array_values($totalKasKecilJenggolo['D']);
        $totalKasKecilJenggoloValuesK = array_values($totalKasKecilJenggolo['K']);
        $totalKasKecilJenggoloValD = 0;
        $totalKasKecilJenggoloValK = 0;
        for ($i=0; $i <count($totalKasKecilJenggoloValuesD) ; $i++) { 
            $totalKasKecilJenggoloValD += $totalKasKecilJenggoloValuesD[$i];
        }
        for ($i=0; $i <count($totalKasKecilJenggoloValuesK) ; $i++) { 
            $totalKasKecilJenggoloValK += $totalKasKecilJenggoloValuesK[$i];
        }
        $totalKasKecilJenggoloFix = $totalKasKecilJenggoloValD-$totalKasKecilJenggoloValK;

        // return $totalKasKecilJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasKecilMukminValuesD = array_values($totalKasKecilMukmin['D']);
        $totalKasKecilMukminValuesK = array_values($totalKasKecilMukmin['K']);
        $totalKasKecilMukminValD = 0;
        $totalKasKecilMukminValK = 0;
        for ($i=0; $i <count($totalKasKecilMukminValuesD) ; $i++) { 
            $totalKasKecilMukminValD += $totalKasKecilMukminValuesD[$i];
        }
        for ($i=0; $i <count($totalKasKecilMukminValuesK) ; $i++) { 
            $totalKasKecilMukminValK += $totalKasKecilMukminValuesK[$i];
        }
        $totalKasKecilMukminFix = $totalKasKecilMukminValD-$totalKasKecilMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // CEK TOTAL KAS J KECIL D K
        $totalKasBankJenggoloValuesD = array_values($totalKasBankJenggolo['D']);
        $totalKasBankJenggoloValuesK = array_values($totalKasBankJenggolo['K']);
        $totalKasBankJenggoloValD = 0;
        $totalKasBankJenggoloValK = 0;
        for ($i=0; $i <count($totalKasBankJenggoloValuesD) ; $i++) { 
            $totalKasBankJenggoloValD += $totalKasBankJenggoloValuesD[$i];
        }
        for ($i=0; $i <count($totalKasBankJenggoloValuesK) ; $i++) { 
            $totalKasBankJenggoloValK += $totalKasBankJenggoloValuesK[$i];
        }
        $totalKasBankJenggoloFix = $totalKasBankJenggoloValD-$totalKasBankJenggoloValK;

        // return $totalKasBankJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasBankMukminValuesD = array_values($totalKasBankMukmin['D']);
        $totalKasBankMukminValuesK = array_values($totalKasBankMukmin['K']);
        $totalKasBankMukminValD = 0;
        $totalKasBankMukminValK = 0;
        for ($i=0; $i <count($totalKasBankMukminValuesD) ; $i++) { 
            $totalKasBankMukminValD += $totalKasBankMukminValuesD[$i];
        }
        for ($i=0; $i <count($totalKasBankMukminValuesK) ; $i++) { 
            $totalKasBankMukminValK += $totalKasBankMukminValuesK[$i];
        }
        $totalKasBankMukminFix = $totalKasBankMukminValD-$totalKasBankMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;


        $dtFix = [
        ['total'=>$totalKasKecilMukminFix,'nama'=>'Kas Kecil Cabang Mukmin'],
        ['total'=>$totalKasKecilJenggoloFix,'nama'=>'Kas Kecil Cabang Jenggolo'],
        ['total'=>$totalKasBankMukminFix,'nama'=>'Kas Bank Cabang Mukmin'],
        ['total'=>$totalKasBankJenggoloFix,'nama'=>'Kas Bank Cabang Jenggolo']];
        
        if(count($data) == 0){
            $message = 'empty';
        }else{
            $message = 'exist';
        }

        return Response::json(['status' => 'success','result'=>$dtFix,'message'=>$message,'date'=>$req->dateS]);
    }
}
