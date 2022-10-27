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

        // return $this->dataModal($jurnal);
        $dataModal = $this->dataModal($jurnal)[0];
        $dataModalTotal = $this->dataModal($jurnal)[1];

        $labaBerjalan = $this->labaBerjalan('',$jurnal);
        // return $dataKas;
        // return [$dataPersediaan, $dataPersediaanTotal];

        return view('pages.backend.report.reportNeraca', compact('dataKas', 'dataKasTotal', 'accountDataKas', 'accountDataPersediaan', 'dataPersediaan','dataPenyusutan','dataPenyusutanTotal', 'dataPersediaanTotal','dataAsset','dataAssetTotal','dataModal','dataModalTotal','labaBerjalan'));
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
                    // if ($branch == '') {
                    // } else {
                    //     $q->where('branch_id', $branch);
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
                    // if ($branch == '') {
                    // } else {
                    //     $q->where('branch_id', $branch);
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

    public function dataModal($jurnal)
    {
        $accountDataModal = AccountData::where('main_id', 9)
                ->where(function ($q) {
                    // if ($branch == '') {
                    // } else {
                    //     $q->where('branch_id', $branch);
                    // }
                })->get();

        $dataModal = [];
        $total = 0;
        for ($i = 0; $i < count($accountDataModal); $i++) {
            
            $dataModal[$i]['total'] = 0;
            // $dataModal[$i]['akun'] = $accountDataModal[$i]->main_detail_id;
            // $dataModal[$i]['namaAkun'] = $accountDataModal[$i]->name;
            $dataModal[$i]['jurnal'] = [];
            $dataModal[$i]['dk'] = [];
            $dataModal[$i]['code'] = [];
            $dataModal[$i]['akun'] = $accountDataModal[$i]->main_detail_id;
            $dataModal[$i]['akun_nama'] = $accountDataModal[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataModal[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataModal[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataModal[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataModal[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataModal[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataModal[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataModal[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'K') {
                            $dataModal[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataModal[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $dataModal[$i]['total'];
        }
        return [$dataModal, $total];
    }


    public function labaBerjalan($branch,$jurnal)
    {
        // return $req->all();
        // if ($req->type == 'Bulan') {
        //     $date1 = date('Y-m-01', strtotime($req->bulan));
        //     $date2 = date('Y-m-t', strtotime($req->bulan));
        // } elseif ($req->type == 'Quartal') {
        //     if ($req->Quartal == 'Q1') {
        //         $q1month1 = date('01-01');
        //         $q1month2 = date('03-t');
        //     } elseif ($req->Quartal == 'Q2') {
        //         $q1month1 = date('04-01');
        //         $q1month2 = date('06-t');
        //     } elseif ($req->Quartal == 'Q3') {
        //         $q1month1 = date('07-01');
        //         $q1month2 = date('09-t');
        //     } elseif ($req->Quartal == 'Q4') {
        //         $q1month1 = date('10-01');
        //         $q1month2 = date('12-t');
        //     }
        //     $date1 = $req->typeQuartalTahun . '-' . $q1month1;
        //     $date2 = $req->typeQuartalTahun . '-' . $q1month2;
        // } elseif ($req->type == 'Tahun') {
        //     $date1 = date('m-01');
        //     $date2 = date('m-t');

        //     $date1 = $req->typeTahun . '-' . $q1month1;
        //     $date2 = $req->typeTahun . '-' . $q1month2;
        // } else {
            $date1 = date('Y-m-01', strtotime(date('Y-m-d')));
            $date2 = date('Y-m-t', strtotime(date('Y-m-d')));
        // }
        // return [$date1,$date2];
        // return $req->all();
        // if ($req->dateS == null) {
        //     $dateParams = date('F Y');
        // } else {
        //     $dateParams = $req->dateS;
        // }
       

        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

        // $branch = Branch::get();
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
                if ($branch == '') {
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
                    if (($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 30 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $DiskonPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 31 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $DiskonService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                }
            }
        }

        $accountDataBiaya = AccountData::where('main_id', 6)
            ->where(function ($q) use ($branch) {
                if ($branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $branch);
                }
            })
            ->get();
        // $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
        //     ->where('date', '>=', $date1)
        //     ->where('date', '<=', $date2)
        //     ->get();

        $dataBiaya = [];
        $totalDataBiaya = 0;
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
            $totalDataBiaya+=$dataBiaya[$i]['total'] ;
        }
        $accountDataPendapatanLainLain = AccountData::where('main_id', 10)
            ->where(function ($q) use ($branch) {
                if ($branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $branch);
                }
            })
            ->get();

        $dataPendapatanLainLain = [];
        $dataPendapatanLainLainTotal = 0;
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
            $dataPendapatanLainLainTotal+=$dataPendapatanLainLain[$i]['total'];
        }
        // return $dataPendapatanLainLain;

        $accountDataBeban = AccountData::where('main_id', 7)->where(function ($q) use ($branch) {
                if ($branch == '') {
                    # code...
                } else {
                    $q->where('branch_id', $branch);
                }
            })->get();

        $dataBeban = [];
        $dataBebanTotal = 0;
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
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'K') {
                            $dataBeban[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataBeban[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            if (!str_contains($accountDataBeban[$i]->name, 'Fee Back Office') && !str_contains($accountDataBeban[$i]->name, 'Sharing Profit') && !str_contains($accountDataBeban[$i]->name, 'Mutasi') && !str_contains($accountDataBeban[$i]->name, 'Transfer') && !str_contains($accountDataBeban[$i]->name, 'Biaya HPP')) {
                $dataBebanTotal-=$dataBeban[$i]['total'];
            }
        }
        // return $dataBeban;

        $accountDataPenyusutan = AccountData::where('main_id', 11)
                ->where(function ($q) use ($branch){
                    if ($branch == '') {
                    } else {
                        $q->where('branch_id', $branch);
                    }
                })->get();

        $dataPenyusutan = [];
        $dataPenyusutanTotal = 0;
        for ($i = 0; $i < count($accountDataPenyusutan); $i++) {
            $dataPenyusutan[$i]['total'] = 0;
            $dataPenyusutan[$i]['akun'] = $accountDataPenyusutan[$i]->main_detail_id;
            $dataPenyusutan[$i]['namaAkun'] = $accountDataPenyusutan[$i]->name;
            $dataPenyusutan[$i]['jurnal'] = [];
            $dataPenyusutan[$i]['dk'] = [];
            $dataPenyusutan[$i]['code'] = [];
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataPenyusutan[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataPenyusutan[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataPenyusutan[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataPenyusutan[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataPenyusutan[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataPenyusutan[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataPenyusutan[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataPenyusutan[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataPenyusutan[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $dataPenyusutanTotal-=$dataPenyusutan[$i]['total'];
        }
        // return $dataPenyusutan;

        // laba kotor
        $pendapatanKotor = $totalService-$DiskonService+$totalPenjualan-$DiskonPenjualan+$dataPendapatanLainLainTotal-$HPP;
   
        $labaKotor = $pendapatanKotor;
        $labaKotorNum = number_format($pendapatanKotor,0,'.',',');
        // biaya
        $beban =  $sharingProfit+$dataBebanTotal+$dataPenyusutanTotal;
        $bebanNum =  number_format($sharingProfit+$dataBebanTotal+$dataPenyusutanTotal,0,'.',',');
        // return [$totalDataBiaya];
        $totalDataBiaya = $totalDataBiaya;
        $totalDataBiayaNum = number_format($totalDataBiaya,0,'.',',');

        $gajiNum = number_format($gaji,0,'.',',');

        // return [number_format($sharingProfit,0,'.',','),number_format($dataBebanTotal,0,'.',','),number_format($dataPenyusutanTotal,0,'.',',')]; 
        $ttl = $labaKotor-$beban-$totalDataBiaya-$gaji;
        // return [$labaKotorNum,$bebanNum,$totalDataBiayaNum,number_format($ttl,0,'.',',')];
        return $ttl;
     }

    
}
