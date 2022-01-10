<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Employee;

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
        $branch = Branch::get();
        return view('pages.backend.report.reportService',compact('branch'));
    }

    public function dataLoad(Request $req)
    {
        $startDate = $req->startDate;
        $endDate = $req->endDate;
        $branch = $req->branch_id;
        if($branch == null || $branch == ''){
            $data = Service::with(['Type', 'Brand'])
            ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
            ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
            ->orderBy('id', 'desc')->get();
        }else{
            $data = Service::with(['Type', 'Brand'])
            ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
            ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
            ->where('branch_id',$branch)
            ->orderBy('id', 'desc')->get();
        }
        

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('sharing_profit_store');
        $tr = count($data);

        
        return view('pages.backend.report.reportServiceLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function dataEmployeeLoad(Request $req)
    {
        $branch = $req->branch_id;
        if($branch == null || $branch == ''){
            $employe = Employee::with('Service1','Service2')->get();
        }else{
            $employe = Employee::with('Service1','Service2')->where('branch_id',$branch)->get();
        }
        $date1 = $this->DashboardController->changeMonthIdToEn($req->startDate);
        $date2 = $this->DashboardController->changeMonthIdToEn($req->endDate);
        // return $employe;
        $data = [];
        for ($i=0; $i <count($employe) ; $i++) { 
            $data[$i]['karyawan'] = $employe[$i]->name;
            $dtsv1 = 0;
            $dtsv2 = 0;
            for ($j=0; $j <count($employe[$i]->Service1) ; $j++) { 
                $dtsv1++;
            }
            for ($j=0; $j <count($employe[$i]->Service2) ; $j++) { 
                $dtsv2++;
            }
            $data[$i]['service1'] = $dtsv1;
            $data[$i]['service2'] = $dtsv2;
        }
        return $data;
        return view('pages.backend.report.reportEmployeeServiceLoad', compact('data'));
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
