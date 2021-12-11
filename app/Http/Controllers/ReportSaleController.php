<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class ReportSaleController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function index()
    {

    }

    public function reportSale()
    {
        return view('pages.backend.report.reportSale');
    }

    public function dataLoad(Request $req)
    {
        $startDate = $req->startDate;
        $endDate = $req->endDate;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);
        // return $sum;

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
