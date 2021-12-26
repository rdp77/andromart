<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ReportServiceController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function index()
    {
        //
    }

    public function reportService()
    {
        return view('pages.backend.report.reportService');
    }

    public function dataLoad(Request $req)
    {
        $startDate = $req->startDate;
        $endDate = $req->endDate;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServiceLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
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
