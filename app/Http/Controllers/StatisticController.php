<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\SummaryBalance;
use App\Models\SummaryJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class StatisticController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }
    function getAge($date1,$date2) {
        $date1 = date('Ymd', strtotime($date1));
        $diff = date('Ymd',strtotime($date2)) - $date1;
        return substr($diff, 0, -4);
    }
    public function filterDataStatistic(Request $req)
    {
        if ($req->filter == 'Bulan') {
            $date1 = date('Y-m-01', strtotime($req->month1));
            $date2 = date('Y-m-01', strtotime($req->month2));
        } elseif ($req->filter == 'Tahun') {
            $date1 = date('m-01');
            $date2 = date('m-01');
            $date1 = $req->year1 . '-' . '01' . '-' . '01';
            $date2 = $req->year2 . '-' . '01' . '-' . '31';
        }
        // return [];
        // $newEndingDate = date("Y", strtotime(date("Y-m-d", strtotime($date1)) . " + 1 year"));
        // return [$newEndingDate];
        //  $year1 = date('Y',strtotime($date1));
        // return date("Y", strtotime("+".'1'." year", $year1));
        // return $diff+1;
        $dataJournals = [];
        $dateFiltering = [];
        if ($req->filter == 'Bulan') {
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);

            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);

            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            $length = $diff+1;
            for ($i=0; $i <$diff+1 ; $i++) { 
                $dataJournals[] = SummaryJournal::where('date','=',date("Y-m-d", strtotime("+".$i." month", $ts1)))->get();
                $dateFiltering[] = date("d F Y", strtotime("+".$i." month", $ts1));
            }
        }else{
            $years = $this->getAge($date1,$date2);
            $length = $years;
            for ($i=0; $i <$years+1 ; $i++) { 
                $dataJournals[] = SummaryJournal::whereYear('date','=',date("Y", strtotime(date("Y-m-d", strtotime($date1)) . "+".$i." year")))->get();
                $dateFiltering[] = date("Y", strtotime(date("Y-m-d", strtotime($date1)) . "+".$i." year"));
            }
        }
        
        // return $dataJournals;
        // return $dateMonth;

        $data = [];
     
        for ($i=0; $i <count($dataJournals) ; $i++) { 
            $totalService[$i] = 0;
            $totalPenjualan[$i] = 0;
            $totalPendapatanLainLain[$i] = 0;
            $totalPendapatanKotor[$i] = 0;
            $totalPendapatanBersih[$i] = 0;
            $totalLabaBersih[$i] = 0;
            $totalHPP[$i] = 0;
            $totalBeban[$i] = 0;
            $totalBiaya[$i] = 0;
            for ($j=0; $j <count($dataJournals[$i]) ; $j++) { 
                // service
                if ($dataJournals[$i][$j]->account_data == 3 || 
                    $dataJournals[$i][$j]->account_data == 4 || 
                    $dataJournals[$i][$j]->account_data == 5 || 
                    $dataJournals[$i][$j]->account_data == 6) {
                    if ($req->branch == '') {
                        $data[$i]['service'][] = $dataJournals[$i][$j]->total;
                        $totalService[$i] += $dataJournals[$i][$j]->total; 
                    }else{
                        if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                            $data[$i]['service'][] = $dataJournals[$i][$j]->total;
                            $totalService[$i] += $dataJournals[$i][$j]->total; 
                        }
                    }
                }
                if ($dataJournals[$i][$j]->account_data == 53 || 
                    $dataJournals[$i][$j]->account_data == 54 ) { 
                        if ($req->branch == '') {
                            $data[$i]['service_diskon'][] = $dataJournals[$i][$j]->total;
                            $totalService[$i] -= $dataJournals[$i][$j]->total; 
                        }else{
                            if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                                $data[$i]['service_diskon'][] = $dataJournals[$i][$j]->total;
                                $totalService[$i] -= $dataJournals[$i][$j]->total; 
                            }
                        }

                }
                // penjualan
                if ($dataJournals[$i][$j]->account_data == 47 || 
                    $dataJournals[$i][$j]->account_data == 48 ){
                        if ($req->branch == '') {
                            $data[$i]['penjualan'][] = $dataJournals[$i][$j]->total;
                            $totalPenjualan[$i] += $dataJournals[$i][$j]->total; 
                        }else{
                            if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                                $data[$i]['penjualan'][] = $dataJournals[$i][$j]->total;
                                $totalPenjualan[$i] += $dataJournals[$i][$j]->total; 
                            }
                        }
                }
                if ($dataJournals[$i][$j]->account_data == 55 || 
                    $dataJournals[$i][$j]->account_data == 56 ) { 
                        if ($req->branch == '') {
                            $data[$i]['penjualan_diskon'][] = $dataJournals[$i][$j]->total;
                            $totalPenjualan[$i] -= $dataJournals[$i][$j]->total; 
                        }else{
                            if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                                $data[$i]['penjualan_diskon'][] = $dataJournals[$i][$j]->total;
                                $totalPenjualan[$i] -= $dataJournals[$i][$j]->total; 
                            }
                        }
                }
                // pendapatan lain lain
                if ($dataJournals[$i][$j]->account_main_id == 10){
                    if ($req->branch == '') {
                        $data[$i]['pendapatanLainLain'][] = $dataJournals[$i][$j]->total;
                        $totalPendapatanLainLain[$i] += $dataJournals[$i][$j]->total; 
                    }else{
                        if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                            $data[$i]['pendapatanLainLain'][] = $dataJournals[$i][$j]->total;
                            $totalPendapatanLainLain[$i] += $dataJournals[$i][$j]->total; 
                        }
                    }
                }
                // HPP
                if ($dataJournals[$i][$j]->account_detail_id == 29){
                    if ($req->branch == '') {
                        $data[$i]['HPP'][] = $dataJournals[$i][$j]->total;
                        $totalHPP[$i] += $dataJournals[$i][$j]->total; 
                    }else{
                        if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                            $data[$i]['HPP'][] = $dataJournals[$i][$j]->total;
                            $totalHPP[$i] += $dataJournals[$i][$j]->total; 
                        }
                    }
                }
                // BEBAN
                if ($dataJournals[$i][$j]->account_main_id == 7){
                    if ($req->branch == '') {
                        if ($dataJournals[$i][$j]->account_detail_id == 28 || $dataJournals[$i][$j]->account_detail_id == 29) {
                          
                        }else{
                            $data[$i]['Beban'][] = $dataJournals[$i][$j]->total;
                            $totalBeban[$i] += $dataJournals[$i][$j]->total; 
                        }
                    }else{
                        if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                            if ($dataJournals[$i][$j]->account_detail_id == 28 || $dataJournals[$i][$j]->account_detail_id == 29) {
                          
                            }else{
                                $data[$i]['Beban'][] = $dataJournals[$i][$j]->total;
                                $totalBeban[$i] += $dataJournals[$i][$j]->total; 
                            }
                        }
                    }
                }
                // HPP
                if ($dataJournals[$i][$j]->account_main_id == 6){
                    if ($req->branch == '') {
                        $data[$i]['Biaya'][] = $dataJournals[$i][$j]->total;
                        $totalBiaya[$i] += $dataJournals[$i][$j]->total; 
                    }else{
                        if ($dataJournals[$i][$j]->branch_id == $req->branch) {
                            $data[$i]['Biaya'][] = $dataJournals[$i][$j]->total;
                            $totalBiaya[$i] += $dataJournals[$i][$j]->total; 
                        }
                    }
                }
            }
            $totalPendapatanKotor[$i] = $totalService[$i]+$totalPenjualan[$i]+$totalPendapatanLainLain[$i];
            $totalPendapatanBersih[$i] = $totalService[$i]+$totalPenjualan[$i]+$totalPendapatanLainLain[$i]-$totalHPP[$i];
            $totalLabaBersih[$i] = $totalService[$i]+$totalPenjualan[$i]+$totalPendapatanLainLain[$i]-$totalHPP[$i]-$totalBiaya[$i]-$totalBeban[$i];
        }
        // return [$totalBeban,$totalBiaya];
        // return [$totalService,$totalPenjualan,$totalPendapatanLainLain];

        if ($req->type == 'Service') {
            return ['data'=>$totalService,'types'=>'Service','date'=>$dateFiltering,'length'=>$length];
        }elseif ($req->type == 'Penjualan') {
            return ['data'=>$totalPenjualan,'types'=>'Penjualan','date'=>$dateFiltering,'length'=>$length];
        }elseif ($req->type == 'Pendapatan Kotor') {
            return ['data'=>$totalPendapatanKotor,'types'=>'Pendapatan Kotor','date'=>$dateFiltering,'length'=>$length];
        }elseif ($req->type == 'Laba Bersih') {
            return ['data'=>$totalLabaBersih,'types'=>'Laba Bersih','date'=>$dateFiltering,'length'=>$length];
        }elseif ($req->type == 'Pendapatan Bersih') {
            return ['data'=>$totalPendapatanBersih,'types'=>'Pendapatan Bersih','date'=>$dateFiltering,'length'=>$length];
        }

    }
   
}
