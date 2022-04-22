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
use App\Models\Branch;
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

class ReportSummaryController extends Controller
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

    public function reportSummary(Request $req)
    {
        $data = Journal::with('JournalDetail')->get();
        $branch = Branch::get();
        if ($req->startDate == null || $req->startDate == '') {
            $startDate = date('Y-m-d');
        } else {
            $startDate = $this->DashboardController->changeMonthIdToEn($req->startDate);
        }
        if ($req->endDate == null || $req->endDate == '') {
            $endDate = date('Y-m-d');
        } else {
            $endDate = $this->DashboardController->changeMonthIdToEn($req->endDate);
        }

        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
        // return $data;
        // return [$startDate,$endDate];
        // return $dateStart;
        $totalPenjualan = 0;
        $totalDiskonPenjualan = 0;
        $totalBersihPenjualan = 0;
        $totalHPPPenjualan = 0;
        $totalService = 0;
        $totalSparepartService = 0;
        $totalDiskonService = 0;
        $totalPembelian = 0;
        $tempPembelian = [];
        $tempDiskon = [];
        $totalPengeluaran = 0;
        if ($req->cabang == null || $req->cabang == '') {
            // return 'aas';
            $cabang = '-';
        }else{
            // return 'as';
            $cabang = $req->cabang;

        }
        // return $cabang;
        // return $data;
        // return $data[0]->JournalDetail[0]->AccountData;
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]->JournalDetail); $j++) {
                // if ($data[$i]->JournalDetail[$j]->AccountData == '12' || $data[$i]->JournalDetail[$j]->AccountData == '29') {
                // }else{
                if ($cabang != '-') {
                    if ($data[$i]->JournalDetail[$j]->AccountData->branch_id == $req->cabang) {
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '5') {
                            $totalService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '31') {
                            $totalDiskonService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6') {
                            $totalSparepartService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                            $totalPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '30') {
                            $totalDiskonPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                            $totalBersihPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '29') {
                            $totalHPPPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '12' && $data[$i]->JournalDetail[$j]->debet_kredit == 'D') {
                            $totalPembelian += $data[$i]->JournalDetail[$j]->total;
                            // array_push( $tempPembelian,$data[$i]->JournalDetail[$j]);
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '14' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '15' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '16' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '17' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '18') {
                            $totalPengeluaran += $data[$i]->JournalDetail[$j]->total;
                        }
                    }
                }else{
                    if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '5') {
                            $totalService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '31') {
                            $totalDiskonService += $data[$i]->JournalDetail[$j]->total;
                            // array_push( $tempDiskon,$data[$i]->JournalDetail[$j]->total);
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6') {
                            $totalSparepartService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                            $totalPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '30') {
                            $totalDiskonPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                            $totalBersihPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '29') {
                            $totalHPPPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '12' && $data[$i]->JournalDetail[$j]->debet_kredit == 'D') {
                            $totalPembelian += $data[$i]->JournalDetail[$j]->total;
                            // array_push( $tempPembelian,$data[$i]->JournalDetail[$j]);
                           
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '14' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '15' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '16' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '17' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '18') {
                            $totalPengeluaran += $data[$i]->JournalDetail[$j]->total;
                        }
                }

                // }S
            }
        }
        // return $totalSparepartService;
        // return [$totalBersihPenjualan,$totalHPPPenjualan];
        return view('pages.backend.report.reportSummary', compact('branch', 'totalPenjualan', 'totalPembelian', 'totalPengeluaran', 'totalDiskonPenjualan', 'totalService', 'totalDiskonService','totalSparepartService','totalBersihPenjualan','totalHPPPenjualan'));
    }
    public function searchReportSummary(Request $req)
    {
        // return $req->all();
        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $this->DashboardController->changeMonthIdToEn($req->dateS))
            ->where('date', '<=', $this->DashboardController->changeMonthIdToEn($req->dateE))
            // ->where(function ($query) {
            // return $query->where('this_too', 'LIKE', '%fake%');
            // })
            ->get();

        if (count($data) == 0) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message, 'tipe' => $req->tipe, 'cabang' => $req->cabang]);
    }
}
