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
            ->where('date', '<=', date('Y-m-d'))
            ->get();
        // ->take('')

        // mendapatkan data kas
        $accountDataKas = AccountData::where('main_id', 1)
            ->groupBy('main_detail_id')
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
        // return $dataKas;
        // return [$dataPersediaan, $dataPersediaanTotal];

        return view('pages.backend.report.reportNeraca', compact('dataKas', 'dataKasTotal', 'accountDataKas', 'accountDataPersediaan', 'dataPersediaan', 'dataPersediaanTotal'));
    }
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
    public function jurnalTransaksiStock()
    {
        // return 'asdd';
        $transaction = StockTransaction::with('item')->get();

        // $accountPersediaan = AccountData::where('branch_id', $getEmployee->branch_id)
        //     ->where('active', 'Y')
        //     ->where('main_id', 3)
        //     ->where('main_detail_id', 11)
        //     ->first();

        // $accountBiayaBarang = AccountData::where('branch_id', $getEmployee->branch_id)
        //     ->where('active', 'Y')
        //     ->where('main_id', 7)
        //     ->where('main_detail_id', 29)
        //     ->first();

        $dataRusak = [];
        for ($i=0; $i <count($transaction) ; $i++) { 
            if ($transaction[$i]->type == 'In') {
                
            }elseif ($transaction[$i]->type == 'Out') {
                if ($transaction[$i]->reason == 'Rusak') {

                    $accountPersediaan = AccountData::where('branch_id', $transaction[$i]->branch_id)
                        ->where('active', 'Y')
                        ->where('main_id', 3)
                        ->where('main_detail_id', 11)
                        ->first();
                    array_push($dataRusak,[$transaction[$i]->id,$transaction[$i]->code,$transaction[$i]->qty*$transaction[$i]->item->buy,[$accountPersediaan->name,$accountPersediaan->id]]);
               
                }elseif ($transaction[$i]->reason == 'Rusak') {
                
                }
            }
        }

        return $dataRusak;

        $idJournalHpp = DB::table('journals')->max('id') + 1;
        Journal::create([
            'id' => $idJournalHpp,
            'code' => $this->code('KK', $idJournalHpp),
            'year' => date('Y'),
            'date' => $dateConvert,
            'type' => 'Biaya',
            'total' => str_replace(',', '', $req->totalHpp),
            'ref' => $kode,
            'description' => 'HPP ' . $kode,
            'created_at' => date('Y-m-d h:i:s'),
        ]);

      
        // JURNAL HPP
        $accountCodeHpp = [$accountBiayaHpp->id, $accountPersediaan->id];
        // return $accountCodeHpp;
        $totalHpp = [str_replace(',', '', $req->totalHpp), str_replace(',', '', $req->totalHpp)];

        $descriptionHpp = ['Pengeluaran Harga Pokok Penjualan ' . $kode, 'Biaya Harga Pokok Penjualan' . $kode];
        $DKHpp = ['D', 'K'];
        for ($i = 0; $i < count($totalHpp); $i++) {
            if ($totalHpp[$i] != 0) {
                $idDetailhpp = DB::table('journal_details')->max('id') + 1;
                JournalDetail::create([
                    'id' => $idDetailhpp,
                    'journal_id' => $idJournalHpp,
                    'account_id' => $accountCodeHpp[$i],
                    'total' => $totalHpp[$i],
                    'description' => $descriptionHpp[$i],
                    'debet_kredit' => $DKHpp[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }
        }
        return $data;
    }
}
