<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
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

class ReportNeracaController extends Controller
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
        // return $this->jurnalTransaksiStock();

        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            // ->where('date', '>=', date('Y-m-01'))
            ->where('date', '<=', date('Y-m-t'))
            ->get();
        // ->take('')

        // mendapatkan data kas
        $accountDataKas = AccountData::where('main_id', 1)
            // ->groupBy('main_detail_id')
            ->get();
        $dataKas = $this->dataKas($jurnal)[0];
        $dataKasTotal = $this->dataKas($jurnal)[1];
        // return $this->dataKas($jurnal);
        // mendapatkan data persediaan
        $accountDataPersediaan = AccountData::where('main_id', 3)
            ->groupBy('main_detail_id')
            ->get();
        // return $this->dataPersediaan($jurnal);
        $dataPersediaan = $this->dataPersediaan($jurnal)[0];
        $dataPersediaanTotal = $this->dataPersediaan($jurnal)[1];

        $dataPenyusutan = $this->dataPenyusutan($jurnal)[0];
        $dataPenyusutanTotal = $this->dataPenyusutan($jurnal)[1];

        $dataAsset = $this->dataAsset($jurnal)[0];
        $dataAssetTotal = $this->dataAsset($jurnal)[1];
        // return $dataKas;
        // return [$dataPersediaan, $dataPersediaanTotal];

        return view('pages.backend.report.reportNeraca', compact('dataKas', 'dataKasTotal', 'accountDataKas', 'accountDataPersediaan', 'dataPersediaan','dataPenyusutan','dataPenyusutanTotal', 'dataPersediaanTotal','dataAsset','dataAssetTotal'));
    }

    // mencari data kas secara
    public function dataKas($jurnal)
    {
        $accountData = AccountData::where('main_id', 1)->get();

        $dataKas = [];
        $total = 0;
        for ($i = 0; $i < count($accountData); $i++) {
            if ($accountData[$i]->opening_date <= date('Y-m-d')) {
                $dataKas[$i]['total'] = $accountData[$i]->opening_balance;
            } else {
                $dataKas[$i]['total'] = 0;
            }
            $dataKas[$i]['akun'] = $accountData[$i]->main_detail_id;
            $dataKas[$i]['akun_id'] = $accountData[$i]->id;
            $dataKas[$i]['akun_nama'] = $accountData[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountData[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountData[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataKas[$i]['total'] += $jurnal[$j]->total;
                        } else {
                            $dataKas[$i]['total'] -= $jurnal[$j]->total;
                        }
                    }
                }
            }
            $total += $dataKas[$i]['total'];
        }
        return [$dataKas, $total];
    }
    public function dataPersediaan($jurnal)
    {
        $accountData = AccountData::where('main_id', 3)->get();

        $dataKas = [];
        $total = 0;
        for ($i = 0; $i < count($accountData); $i++) {
            if ($accountData[$i]->opening_date <= date('Y-m-d')) {
                $dataKas[$i]['total'] = $accountData[$i]->opening_balance;
            } else {
                $dataKas[$i]['total'] = 0;
            }
            $dataKas[$i]['akun'] = $accountData[$i]->main_detail_id;
            $dataKas[$i]['akun_nama'] = $accountData[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountData[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountData[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataKas[$i][$j]['jurnal_name']  = $jurnal[$j]->JournalDetail[$k]->AccountData->name;
                        // $dataKas[$i][$j]['jurnal_id']    = $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id;
                        // $dataKas[$i][$j]['jurnal_id']    = $jurnal[$j]->ref;
                        // $dataKas[$i][$j]['jurnal_total'] = $jurnal[$j]->total;
                        // $dataKas[$i][$j]['jurnal_dk']    = $jurnal[$j]->JournalDetail[$k]->debet_kredit;

                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataKas[$i]['total'] += $jurnal[$j]->total;
                        } else {
                            $dataKas[$i]['total'] -= $jurnal[$j]->total;
                        }
                    }
                }
            }
            $total += $dataKas[$i]['total'];
        }
        return [$dataKas, $total];
    }
    public function dataPenyusutan($jurnal)
    {
        $accountDataPenyusutan = AccountData::where('main_id', 12)
                ->where(function ($q) {
                    // if ($req->branch == '') {
                    // } else {
                    //     $q->where('branch_id', $req->branch);
                    // }
                })->get();

        $dataPenyusutan = [];
        $total = 0;
        for ($i = 0; $i < count($accountDataPenyusutan); $i++) {
            
            $dataPenyusutan[$i]['total'] = 0;
            // $dataPenyusutan[$i]['akun'] = $accountDataPenyusutan[$i]->main_detail_id;
            // $dataPenyusutan[$i]['namaAkun'] = $accountDataPenyusutan[$i]->name;
            $dataPenyusutan[$i]['jurnal'] = [];
            $dataPenyusutan[$i]['dk'] = [];
            $dataPenyusutan[$i]['code'] = [];
            $dataPenyusutan[$i]['akun'] = $accountDataPenyusutan[$i]->main_detail_id;
            $dataPenyusutan[$i]['akun_nama'] = $accountDataPenyusutan[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataPenyusutan[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataPenyusutan[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataPenyusutan[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataPenyusutan[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataPenyusutan[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataPenyusutan[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataPenyusutan[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'K') {
                            $dataPenyusutan[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataPenyusutan[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $dataPenyusutan[$i]['total'];
        }
        return [$dataPenyusutan, $total];
    }
    public function dataAsset($jurnal)
    {
        $accountDataAsset = AccountData::where('main_id', 13)
                ->where(function ($q) {
                    // if ($req->branch == '') {
                    // } else {
                    //     $q->where('branch_id', $req->branch);
                    // }
                })->get();

        $dataAsset = [];
        $total = 0;
        for ($i = 0; $i < count($accountDataAsset); $i++) {
            
            $dataAsset[$i]['total'] = 0;
            // $dataAsset[$i]['akun'] = $accountDataAsset[$i]->main_detail_id;
            // $dataAsset[$i]['namaAkun'] = $accountDataAsset[$i]->name;
            $dataAsset[$i]['jurnal'] = [];
            $dataAsset[$i]['dk'] = [];
            $dataAsset[$i]['code'] = [];
            $dataAsset[$i]['akun'] = $accountDataAsset[$i]->main_detail_id;
            $dataAsset[$i]['akun_nama'] = $accountDataAsset[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataAsset[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataAsset[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataAsset[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataAsset[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataAsset[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataAsset[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataAsset[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataAsset[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataAsset[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $dataAsset[$i]['total'];
        }
        return [$dataAsset, $total];
    }
}
