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
use App\Models\Branch;
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
        $Branch = Branch::get();
    
        return view('pages.backend.report.reportNeraca', compact('Branch'));
    }
    public function printReportNeraca (Request $req)
    {
        $branch = $req->branch;
        $checkBranch = Branch::where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('id', $branch);
                                        }
                                    })->first();
        // return $this->jurnalTransaksiStock();
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', date('Y-05-01'))
            ->where('date', '<=', date('Y-m-t'))
            ->get();
        // ->take('')

        // mendapatkan data kas
        // $accountDataKas = AccountData::where('main_id', 1)
        //     // ->groupBy('main_detail_id')
        //     ->get();
        $dataKas = $this->dataKas($jurnal,$branch)[0];
        $dataKasTotal = $this->dataKas($jurnal,$branch)[1];
        // $this->dataKas($jurnal,$branch)[2];


        // return $this->dataKas($jurnal);
        // mendapatkan data persediaan
        $accountDataPersediaan = AccountData::where('main_id', 3)
            ->groupBy('main_detail_id')
            ->get();
        // return $this->dataPersediaan($jurnal);
        $dataPersediaan = $this->dataPersediaan($jurnal,$branch)[0];
        $dataPersediaanTotal = $this->dataPersediaan($jurnal,$branch)[1];

        $dataPenyusutan = $this->dataPenyusutan($jurnal,$branch)[0];
        $dataPenyusutanTotal = $this->dataPenyusutan($jurnal,$branch)[1];

        $dataAsset = $this->dataAsset($jurnal,$branch)[0];
        $dataAssetTotal = $this->dataAsset($jurnal,$branch)[1];

        // return $this->dataModal($jurnal,$branch);
        $dataModal = $this->dataModal($jurnal,$branch)[0];
        $dataModalTotal = $this->dataModal($jurnal,$branch)[1];

        $dataUangDimuka = $this->dataUangDimuka($jurnal,$branch)[0];
        $dataUangDimukaTotal = $this->dataUangDimuka($jurnal,$branch)[1];

        $dataPendapatanDimuka = $this->dataPendapatanDimuka($jurnal,$branch)[0];
        $dataPendapatanDimukaTotal = $this->dataPendapatanDimuka($jurnal,$branch)[1];

        $dataMutasiTransfer = $this->dataMutasiTransfer($jurnal,$branch)[0];
        $dataMutasiTransferTotal = $this->dataMutasiTransfer($jurnal,$branch)[1];

        $labaBerjalan = $this->labaBerjalan($jurnal,$branch);
        // return $dataKas;
        // return [$dataPersediaan, $dataPersediaanTotal];

        return view('pages.backend.report.printReportNeraca', compact('dataKas', 'dataKasTotal',  'accountDataPersediaan', 'dataPersediaan','dataPenyusutan','dataPenyusutanTotal', 'dataPersediaanTotal','dataAsset','dataAssetTotal','dataModal','dataModalTotal','labaBerjalan','checkBranch','dataUangDimuka','dataUangDimukaTotal','dataPendapatanDimuka','dataPendapatanDimukaTotal','branch','dataMutasiTransfer','dataMutasiTransferTotal'));
    }

    // mencari data kas secara
    public function dataKas($jurnal,$branch)
    {
        $accountData = AccountData::where('main_id', 1)
                                  ->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
                                    })
                                    ->get();

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

    
    public function dataPersediaan($jurnal,$branch)
    {
        $accountData = AccountData::where('main_id', 3)->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
                                    })->get();

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
    public function dataPenyusutan($jurnal,$branch)
    {
        $accountDataPenyusutan = AccountData::where('main_id', 12)
        ->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
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
    public function dataAsset($jurnal,$branch)
    {
        $accountDataAsset = AccountData::where('main_id', 13)
        ->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
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

    public function dataModal($jurnal,$branch)
    {
        $accountDataModal = AccountData::where('main_id', 9)
        ->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
                                    })->get();

        $dataModal = [];
        $total = 0;
        for ($i = 0; $i < count($accountDataModal); $i++) {
            if ($accountDataModal[$i]->opening_date <= date('Y-m-t')) {
                $dataModal[$i]['total'] = $accountDataModal[$i]->opening_balance;
            } else {
                $dataModal[$i]['total'] = 0;
            }
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
    public function dataUangDimuka($jurnal,$branch)
    {
        $accountUangDimuka = AccountData::where('main_id', 4)->where('main_detail_id', 12)
        ->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
                                    })->get();

        $UangDimuka = [];
        $total = 0;
        for ($i = 0; $i < count($accountUangDimuka); $i++) {
            
            $UangDimuka[$i]['total'] = 0;
            // $UangDimuka[$i]['akun'] = $accountUangDimuka[$i]->main_detail_id;
            // $UangDimuka[$i]['namaAkun'] = $accountUangDimuka[$i]->name;
            $UangDimuka[$i]['jurnal'] = [];
            $UangDimuka[$i]['dk'] = [];
            $UangDimuka[$i]['code'] = [];
            $UangDimuka[$i]['akun'] = $accountUangDimuka[$i]->main_detail_id;
            $UangDimuka[$i]['akun_nama'] = $accountUangDimuka[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountUangDimuka[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountUangDimuka[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $UangDimuka[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($UangDimuka[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($UangDimuka[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($UangDimuka[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($UangDimuka[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $UangDimuka[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $UangDimuka[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $UangDimuka[$i]['total'];
        }
        return [$UangDimuka, $total];
    }

    public function dataPendapatanDimuka($jurnal,$branch)
    {
        $accountPendapatanDimuka = AccountData::where('main_id', 4)->where('main_detail_id', 4)
        ->where(function ($q) use ($branch) {
                                        if ($branch == '') {
                                        } else {
                                            $q->where('branch_id', $branch);
                                        }
                                    })->get();

        $PendapatanDimuka = [];
        $total = 0;
        for ($i = 0; $i < count($accountPendapatanDimuka); $i++) {
            
            $PendapatanDimuka[$i]['total'] = 0;
            // $PendapatanDimuka[$i]['akun'] = $accountPendapatanDimuka[$i]->main_detail_id;
            // $PendapatanDimuka[$i]['namaAkun'] = $accountPendapatanDimuka[$i]->name;
            $PendapatanDimuka[$i]['jurnal'] = [];
            $PendapatanDimuka[$i]['dk'] = [];
            $PendapatanDimuka[$i]['code'] = [];
            $PendapatanDimuka[$i]['akun'] = $accountPendapatanDimuka[$i]->main_detail_id;
            $PendapatanDimuka[$i]['akun_nama'] = $accountPendapatanDimuka[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountPendapatanDimuka[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountPendapatanDimuka[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $PendapatanDimuka[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($PendapatanDimuka[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($PendapatanDimuka[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($PendapatanDimuka[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($PendapatanDimuka[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'K') {
                            $PendapatanDimuka[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $PendapatanDimuka[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $PendapatanDimuka[$i]['total'];
        }
        return [$PendapatanDimuka, $total];
    }

    public function dataMutasiTransfer($jurnal,$branch)
    {
        $accountMutasiTransfer = AccountData::where('main_id', 14)->where('main_detail_id', 60)
                                            ->where(function ($q) use ($branch) {
                                                if ($branch == '') {
                                                } else {
                                                    $q->where('branch_id', $branch);
                                                }
                                            })->get();

        $MutasiTransfer = [];
        $total = 0;
        for ($i = 0; $i < count($accountMutasiTransfer); $i++) {
            
            $MutasiTransfer[$i]['total'] = 0;
            // $MutasiTransfer[$i]['akun'] = $accountMutasiTransfer[$i]->main_detail_id;
            // $MutasiTransfer[$i]['namaAkun'] = $accountMutasiTransfer[$i]->name;
            $MutasiTransfer[$i]['jurnal'] = [];
            $MutasiTransfer[$i]['dk'] = [];
            $MutasiTransfer[$i]['code'] = [];
            $MutasiTransfer[$i]['akun'] = $accountMutasiTransfer[$i]->main_detail_id;
            $MutasiTransfer[$i]['akun_nama'] = $accountMutasiTransfer[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountMutasiTransfer[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountMutasiTransfer[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $MutasiTransfer[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($MutasiTransfer[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($MutasiTransfer[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($MutasiTransfer[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($MutasiTransfer[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $MutasiTransfer[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $MutasiTransfer[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $MutasiTransfer[$i]['total'];
        }
        return [$MutasiTransfer, $total];
    }

    public function labaBerjalan($jurnal,$branch)
    {
        // return $req->all();
        $date1 = date('Y-m-01', strtotime(date('Y-m-d')));
        $date2 = date('Y-m-t', strtotime(date('Y-m-d')));
        $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

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
                } else {
                    $q->where('branch_id', $branch);
                }
                })
            ->get();

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

        $accountDataBeban = AccountData::where('main_id', 7)
                                       ->where(function ($q) use ($branch) {
                                            if ($branch == '') {
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
                                            ->where(function ($q) use ($branch) {
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
        $totalDataBiaya = $totalDataBiaya;
        $totalDataBiayaNum = number_format($totalDataBiaya,0,'.',',');

        $gajiNum = number_format($gaji,0,'.',',');

        $ttl = $labaKotor-$beban-$totalDataBiaya-$gaji;
        return $ttl;
     }

    
}
