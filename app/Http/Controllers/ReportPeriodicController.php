<?php

namespace App\Http\Controllers;

use App\Models\AccountMain;
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
use App\Models\AccountData;
use App\Models\Branch;

// use DB;

class ReportPeriodicController extends Controller
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
            ->where('date', '<', date('Y-m-01', strtotime($dateParams)))
            ->get();

        $account = AccountMain::with('accountMainDetail','accountMainDetail.accountData')->get();
        $accountData = AccountData::get();
        $branch = Branch::get();
        // return $account;
        // return $accountData;

        // return $data;
        $data = array();
        // $data['main']['main_detail'][] = array();
        for ($i = 0; $i < count($account); $i++) {
            $data[$i]['main'] = $account[$i]->name;
            // array_push($data['main'],$account[$i]->name);

            for ($j = 0; $j < count($account[$i]->accountMainDetail); $j++) {
                $data[$i]['main_detail'][$j]['detail'] = $account[$i]->accountMainDetail[$j]->name;

                // mengecek jurnal sebelum bulan ini
                for ($m = 0; $m < count($branch); $m++) {
                    $data[$i]['main_detail'][$j]['branch'][$m]['saldoAwal'] = 0;
                    $data[$i]['main_detail'][$j]['branch'][$m]['nama'] = $branch[$m]->name;
                    $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalFix'] = 0;

                    for ($k = 0; $k < count($jurnal); $k++) {
                        for ($l = 0; $l < count($jurnal[$k]->JournalDetail); $l++) {
                            if (($jurnal[$k]->JournalDetail[$l]->accountData->main_id ==  $account[$i]->id) && ($jurnal[$k]->JournalDetail[$l]->accountData->main_detail_id ==  $account[$i]->accountMainDetail[$j]->id)) {
                                if (isset($jurnal[$k]->JournalDetail[$l]->accountData->code)) {

                                    if ($jurnal[$k]->JournalDetail[$l]->accountData->branch_id == $branch[$m]->id) {
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['code'] = $jurnal[$k]->JournalDetail[$l]->accountData->code;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['total']  = $jurnal[$k]->JournalDetail[$l]->total;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['ref']  = $jurnal[$k]->ref;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['debet_kredit']  = $jurnal[$k]->JournalDetail[$l]->debet_kredit;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['date']  = date('d F Y', strtotime($jurnal[$k]->date));
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['acc_debet_kredit']  = $jurnal[$k]->JournalDetail[$l]->accountData->debet_kredit;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'][$k]['desc']  = $jurnal[$k]->JournalDetail[$l]->description;
                                    }
                                    if (isset($data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw'])) {
                                        $data[$i]['main_detail'][$j]['branch'][$m]['jurnal'] = array_values($data[$i]['main_detail'][$j]['branch'][$m]['JurnalRaw']);
                                    }
                                }
                            }
                        }
                    }
                }
                for ($z=0; $z <count($account[$i]->accountMainDetail[$j]->accountData) ; $z++) {
                    if( $account[$i]->id == $account[$i]->accountMainDetail[$j]->accountData[$z]->main_detail_id){
                        $data[$i]['main_detail'][$j]['branch'][$z]['saldoAwal'] = $account[$i]->accountMainDetail[$j]->accountData[$z]->opening_balance;
                    }
                }
                if (count($jurnalSebelumnya) == 0) {
                    for ($z=0; $z <count($account[$i]->accountMainDetail[$j]->accountData) ; $z++) {
                    if( $account[$i]->id == $account[$i]->accountMainDetail[$j]->accountData[$z]->main_detail_id){
                        $data[$i]['main_detail'][$j]['branch'][$z]['SaldoAkhirJurnalFix'] = $account[$i]->accountMainDetail[$j]->accountData[$z]->opening_balance;
                    }
                }
                }else{
                    for ($k = 0; $k < count($jurnalSebelumnya); $k++) {
                    for ($l = 0; $l < count($jurnalSebelumnya[$k]->JournalDetail); $l++) {
                        // mengecek jurnal detail main id sama dengan id akun 
                        if (($jurnalSebelumnya[$k]->JournalDetail[$l]->accountData->main_id ==  $account[$i]->id) && ($jurnalSebelumnya[$k]->JournalDetail[$l]->accountData->main_detail_id == $account[$i]->accountMainDetail[$j]->id)) {
                            // isset mengecek apakah ada account id tsb
                            if (isset($jurnalSebelumnya[$k]->JournalDetail[$l]->accountData->code)) {
                                // perulangan cabang
                                for ($m = 0; $m < count($branch); $m++) {
                                    $data[$i]['main_detail'][$j]['branch'][$m]['nama'] = $branch[$m]->name;
                                    // mengecek apakah cabang sama dengan perulangan cabang
                                    if ($jurnalSebelumnya[$k]->JournalDetail[$l]->accountData->branch_id == $branch[$m]->id) {
                                        $data[$i]['main_detail'][$j]['branch'][$m]['openingBalance'] = $jurnalSebelumnya[$k]->JournalDetail[$l]->accountData->opening_balance;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['saldoAkhirJurnalRaw'][$k]['total']  = $jurnalSebelumnya[$k]->JournalDetail[$l]->total;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['saldoAkhirJurnalRaw'][$k]['debet_kredit']  = $jurnalSebelumnya[$k]->JournalDetail[$l]->debet_kredit;
                                        $data[$i]['main_detail'][$j]['branch'][$m]['saldoAkhirJurnalRaw'][$k]['acc_debet_kredit']  = $jurnalSebelumnya[$k]->JournalDetail[$l]->accountData->debet_kredit;
                                    }
                                    // mengecek apakah saldoAkhirJurnalRaw ada
                                    if (isset($data[$i]['main_detail'][$j]['branch'][$m]['saldoAkhirJurnalRaw'])) {
                                        // mengurutkan array menjadi dari 0 dst

                                        $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray'] = array_values($data[$i]['main_detail'][$j]['branch'][$m]['saldoAkhirJurnalRaw']);

                                        // mendefinisikan jurnal DK
                                        $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalDK'] = 0;

                                        // melakukan perulangan pada reindex array untuk mendapatkan totalnya
                                        for ($n = 0; $n < count($data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray']); $n++) {
                                            // mengecek apakah dia DEBET / KREDIT
                                            if ($data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray'][$n]['debet_kredit'] == 'D') {
                                                $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalDK'] += $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray'][$n]['total'];
                                            } else {
                                                // mengecek apakah dia KREDIT pada master, dan kredit pada jurnal , maka bernilai +
                                                if ($data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray'][$n]['acc_debet_kredit'] == 'K') {
                                                    $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalDK'] += $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray'][$n]['total'];
                                                } else {
                                                    $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalDK'] -= $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalReindexArray'][$n]['total'];
                                                }
                                            }
                                        }
                                        // Menambah Saldo Akir Jurnal Opening Balance + Saldo Jurnal
                                        $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalFix'] = $data[$i]['main_detail'][$j]['branch'][$m]['saldoAwal']  + $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalDK'];
                                    }else{
                                        $data[$i]['main_detail'][$j]['branch'][$m]['SaldoAkhirJurnalFix'] =  $data[$i]['main_detail'][$j]['branch'][$m]['saldoAwal'];
                                    }
                                }
                            }
                        }
                    }
                }
                }
                
            }
        }
        // return $data;
        return view('pages.backend.report.reportPeriodic', compact('data'));
    }
}
