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

        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '<=', date('Y-m-d'))
            ->get();
        return view('pages.backend.report.reportPeriodic', compact('data'));
    }

    public function searchReportPeriodic(Request $req)
    {
        // return $req->all();
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
            ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
            ->get();

        $account = accountMain::with('accountMainDetail')->get();
        $accountData = accountData::get();
        // return $data;
        // return $accountData;

        // return $data;
        $data = array();
        // $data['main']['main_detail'][] = array();
        for ($i = 0; $i < count($account); $i++) {
            $data[$i]['main'] = $account[$i]->name;
            // array_push($data['main'],$account[$i]->name);
            for ($j = 0; $j < count($account[$i]->accountMainDetail); $j++) {
                $data[$i]['main_detail'][$j]['detail'] = $account[$i]->accountMainDetail[$j]->name;
                for ($k = 0; $k < count($jurnal); $k++) {
                    for ($l = 0; $l < count($jurnal[$k]->JournalDetail); $l++) {
                        if (($jurnal[$k]->JournalDetail[$l]->accountData->main_id ==  $account[$i]->id) && ($jurnal[$k]->JournalDetail[$l]->accountData->main_detail_id ==  $account[$i]->accountMainDetail[$j]->id)) {
                            if (isset($jurnal[$k]->JournalDetail[$l]->accountData->code)) {
                                $data[$i]['main_detail'][$j]['JurnalRaw'][$k]['code'] = $jurnal[$k]->JournalDetail[$l]->accountData->code;
                                $data[$i]['main_detail'][$j]['JurnalRaw'][$k]['total']  = $jurnal[$k]->JournalDetail[$l]->total;
                                $data[$i]['main_detail'][$j]['JurnalRaw'][$k]['ref']  = $jurnal[$k]->ref;
                                $data[$i]['main_detail'][$j]['JurnalRaw'][$k]['type']  = $jurnal[$k]->JournalDetail[$l]->debet_kredit;
                            }
                        }
                            
                    }
                    if (isset($data[$i]['main_detail'][$j]['JurnalRaw'])) {
                        $data[$i]['main_detail'][$j]['jurnal'] = array_values($data[$i]['main_detail'][$j]['JurnalRaw']);
                    }
                }
            }
        }
        // return $data;
        // return $data;
     
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;


        

        if (count($data) == 0) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message, 'date' => $req->dateS]);
    }
}
