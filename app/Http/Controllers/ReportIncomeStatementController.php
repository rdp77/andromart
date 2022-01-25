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
        $Air = 0;
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
            }
        }
        $PendapatanKotor = $PendapatanBersih+$Diskon;
        $data = array();
        return view('pages.backend.report.reportIncomeStatement', compact('data','PendapatanKotor','PendapatanBersih','Diskon','HPP','listrik','atk','gaji'));
    }
}
