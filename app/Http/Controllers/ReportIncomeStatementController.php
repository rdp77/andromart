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
        // return $req->all();
        if ($req->type == 'Bulan') {
            $date1 = date('Y-m-01', strtotime($req->bulan));
            $date2 = date('Y-m-t', strtotime($req->bulan));
        } elseif ($req->type == 'Quartal') {
            if ($req->Quartal == 'Q1') {
                $q1month1 = date('01-01');
                $q1month2 = date('03-t');
            } elseif ($req->Quartal == 'Q2') {
                $q1month1 = date('04-01');
                $q1month2 = date('06-t');
            } elseif ($req->Quartal == 'Q3') {
                $q1month1 = date('07-01');
                $q1month2 = date('09-t');
            } elseif ($req->Quartal == 'Q4') {
                $q1month1 = date('10-01');
                $q1month2 = date('12-t');
            }
            $date1 = $req->typeQuartalTahun . '-' . $q1month1;
            $date2 = $req->typeQuartalTahun . '-' . $q1month2;
        } elseif ($req->type == 'Tahun') {
            $date1 = date('m-01');
            $date2 = date('m-t');

            $date1 = $req->typeTahun . '-' . $q1month1;
            $date2 = $req->typeTahun . '-' . $q1month2;
        } else {
            $date1 = date('Y-m-01', strtotime(date('Y-m-d')));
            $date2 = date('Y-m-t', strtotime(date('Y-m-d')));
        }
        // return [$date1,$date2];
        // return $req->all();
        // if ($req->dateS == null) {
        //     $dateParams = date('F Y');
        // } else {
        //     $dateParams = $req->dateS;
        // }
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $date1)
            ->where('date', '<=', $date2)
            ->get();

        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

        $branch = Branch::get();
        // return $account;
        // return $accountData;
        $HPP = 0;
        $gaji = 0;
        $totalService = 0;
        $sharingProfit = 0;
        $totalPenjualan = 0;
        $DiskonPenjualan = 0;
        $DiskonService = 0;

        $data = [];
        for ($i = 0; $i < count($jurnal); $i++) {
            for ($j = 0; $j < count($jurnal[$i]->JournalDetail); $j++) {
                $data[] = $jurnal[$i]->JournalDetail[$j]->total;
                if ($req->branch == '') {
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
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

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14 ) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                } else {
                    if (($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 30 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $DiskonPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 31 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $DiskonService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                }
            }
        }

        $accountDataBiaya = AccountData::where('main_id', 6)
            ->where(function ($q) use ($req) {
                if ($req->branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $req->branch);
                }
            })
            ->get();
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $date1)
            ->where('date', '<=', $date2)
            ->get();

        $dataBiaya = [];
        for ($i = 0; $i < count($accountDataBiaya); $i++) {
            $dataBiaya[$i]['total'] = 0;
            $dataBiaya[$i]['akun'] = $accountDataBiaya[$i]->main_detail_id;
            $dataBiaya[$i]['namaAkun'] = $accountDataBiaya[$i]->name;
            $dataBiaya[$i]['jurnal'] = [];
            $dataBiaya[$i]['dk'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataBiaya[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataBiaya[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataBiaya[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataBiaya[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataBiaya[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataBiaya[$i]['dk'], [$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataBiaya[$i]['total'] +=$jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataBiaya[$i]['total'] -=$jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
        }
        $accountDataPendapatanLainLain = AccountData::where('main_id', 10)
            ->where(function ($q) use ($req) {
                if ($req->branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $req->branch);
                }
            })
            ->get();

        $dataPendapatanLainLain = [];
        for ($i = 0; $i < count($accountDataPendapatanLainLain); $i++) {
            $dataPendapatanLainLain[$i]['total'] = 0;
            $dataPendapatanLainLain[$i]['akun'] = $accountDataPendapatanLainLain[$i]->main_detail_id;
            $dataPendapatanLainLain[$i]['namaAkun'] = $accountDataPendapatanLainLain[$i]->name;
            $dataPendapatanLainLain[$i]['jurnal'] = [];
            $dataPendapatanLainLain[$i]['dk'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataPendapatanLainLain[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataPendapatanLainLain[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataPendapatanLainLain[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataPendapatanLainLain[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataPendapatanLainLain[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataPendapatanLainLain[$i]['dk'], [$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataPendapatanLainLain[$i]['total'] -=$jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataPendapatanLainLain[$i]['total'] +=$jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
        }
        // return $dataPendapatanLainLain;

        $accountDataBeban = AccountData::where('main_id', 7)->where(function ($q) use ($req) {
                if ($req->branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $req->branch);
                }
            })->get();
        // $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
        //     // ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
        //     ->where('date', '>=', $date1)
        //     ->where('date', '<=', $date2)
           
        //     // ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
        //     ->get();

        $dataBeban = [];
        for ($i = 0; $i < count($accountDataBeban); $i++) {
            $dataBeban[$i]['total'] = 0;
            $dataBeban[$i]['akun'] = $accountDataBeban[$i]->main_detail_id;
            $dataBeban[$i]['namaAkun'] = $accountDataBeban[$i]->name;
            $dataBeban[$i]['jurnal'] = [];
            $dataBeban[$i]['dk'] = [];
            $dataBeban[$i]['code'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataBeban[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataBeban[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataBeban[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataBeban[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataBeban[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataBeban[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataBeban[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataBeban[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataBeban[$i]['total'] -= 0;
                        }
                    }
                }
            }
        }
        // return $dataBeban;

        // $data = [];
        return view('pages.backend.report.reportIncomeStatement', compact('HPP', 'gaji', 'sharingProfit', 'totalService', 'totalPenjualan', 'DiskonPenjualan', 'DiskonService', 'dataBiaya', 'dataBeban', 'branch','dataPendapatanLainLain'));
    }
    public function printReportIncomeStatement(Request $req)
    {
        // return $req->all();
        if ($req->type == 'Bulan') {
            $date1 = date('Y-m-01', strtotime($req->bulan));
            $date2 = date('Y-m-t', strtotime($req->bulan));
        } elseif ($req->type == 'Quartal') {
            if ($req->Quartal == 'Q1') {
                $q1month1 = date('01-01');
                $q1month2 = date('03-t');
            } elseif ($req->Quartal == 'Q2') {
                $q1month1 = date('04-01');
                $q1month2 = date('06-t');
            } elseif ($req->Quartal == 'Q3') {
                $q1month1 = date('07-01');
                $q1month2 = date('09-t');
            } elseif ($req->Quartal == 'Q4') {
                $q1month1 = date('10-01');
                $q1month2 = date('12-t');
            }
            $date1 = $req->typeQuartalTahun . '-' . $q1month1;
            $date2 = $req->typeQuartalTahun . '-' . $q1month2;
        } elseif ($req->type == 'Tahun') {
            $date1 = date('m-01');
            $date2 = date('m-t');

            $date1 = $req->typeTahun . '-' . $q1month1;
            $date2 = $req->typeTahun . '-' . $q1month2;
        } else {
            $date1 = date('Y-m-01', strtotime(date('Y-m-d')));
            $date2 = date('Y-m-t', strtotime(date('Y-m-d')));
        }
        // return [$date1,$date2];
        // return $req->all();
        // if ($req->dateS == null) {
        //     $dateParams = date('F Y');
        // } else {
        //     $dateParams = $req->dateS;
        // }
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $date1)
            ->where('date', '<=', $date2)
            ->get();

        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

        $branch = Branch::get();
        // return $account;
        // return $accountData;
        $HPP = 0;
        $gaji = 0;
        $totalService = 0;
        $sharingProfit = 0;
        $totalPenjualan = 0;
        $DiskonPenjualan = 0;
        $DiskonService = 0;

        $data = [];
        for ($i = 0; $i < count($jurnal); $i++) {
            for ($j = 0; $j < count($jurnal[$i]->JournalDetail); $j++) {
                $data[] = $jurnal[$i]->JournalDetail[$j]->total;
                if ($req->branch == '') {
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
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

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14 ) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                } else {
                    if (($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 30 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $DiskonPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 31 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $DiskonService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $req->branch) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                }
            }
        }

        $accountDataBiaya = AccountData::where('main_id', 6)
            ->where(function ($q) use ($req) {
                if ($req->branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $req->branch);
                }
            })
            ->get();
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $date1)
            ->where('date', '<=', $date2)
            ->get();

        $dataBiaya = [];
        for ($i = 0; $i < count($accountDataBiaya); $i++) {
            $dataBiaya[$i]['total'] = 0;
            $dataBiaya[$i]['akun'] = $accountDataBiaya[$i]->main_detail_id;
            $dataBiaya[$i]['namaAkun'] = $accountDataBiaya[$i]->name;
            $dataBiaya[$i]['jurnal'] = [];
            $dataBiaya[$i]['dk'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataBiaya[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataBiaya[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataBiaya[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataBiaya[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataBiaya[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataBiaya[$i]['dk'], [$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataBiaya[$i]['total'] +=$jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataBiaya[$i]['total'] -=$jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
        }
        $accountDataPendapatanLainLain = AccountData::where('main_id', 10)
            ->where(function ($q) use ($req) {
                if ($req->branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $req->branch);
                }
            })
            ->get();

        $dataPendapatanLainLain = [];
        for ($i = 0; $i < count($accountDataPendapatanLainLain); $i++) {
            $dataPendapatanLainLain[$i]['total'] = 0;
            $dataPendapatanLainLain[$i]['akun'] = $accountDataPendapatanLainLain[$i]->main_detail_id;
            $dataPendapatanLainLain[$i]['namaAkun'] = $accountDataPendapatanLainLain[$i]->name;
            $dataPendapatanLainLain[$i]['jurnal'] = [];
            $dataPendapatanLainLain[$i]['dk'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataPendapatanLainLain[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataPendapatanLainLain[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataPendapatanLainLain[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataPendapatanLainLain[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataPendapatanLainLain[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataPendapatanLainLain[$i]['dk'], [$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataPendapatanLainLain[$i]['total'] -=$jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataPendapatanLainLain[$i]['total'] +=$jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
        }
        // return $dataPendapatanLainLain;

        $accountDataBeban = AccountData::where('main_id', 7)->where(function ($q) use ($req) {
                if ($req->branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $req->branch);
                }
            })->get();
        // $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
        //     // ->where('date', '<=', date('Y-m-t', strtotime($req->dateS)))
        //     ->where('date', '>=', $date1)
        //     ->where('date', '<=', $date2)
           
        //     // ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
        //     ->get();

        $dataBeban = [];
        for ($i = 0; $i < count($accountDataBeban); $i++) {
            $dataBeban[$i]['total'] = 0;
            $dataBeban[$i]['akun'] = $accountDataBeban[$i]->main_detail_id;
            $dataBeban[$i]['namaAkun'] = $accountDataBeban[$i]->name;
            $dataBeban[$i]['jurnal'] = [];
            $dataBeban[$i]['dk'] = [];
            $dataBeban[$i]['code'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataBeban[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataBeban[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataBeban[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataBeban[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataBeban[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataBeban[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataBeban[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataBeban[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataBeban[$i]['total'] -= 0;
                        }
                    }
                }
            }
        }
        // return $dataBeban;

        // $data = [];
        return view('pages.backend.report.reportPrintIncomeStatement', compact('HPP', 'gaji', 'sharingProfit', 'totalService', 'totalPenjualan', 'DiskonPenjualan', 'DiskonService', 'dataBiaya', 'dataBeban', 'branch','dataPendapatanLainLain'));
    }
}
