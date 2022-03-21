<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReportServiceController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function reportService()
    {
        $branchUser = Auth::user()->employee->branch_id;
        $type = Type::get();

        if (Auth::user()->role_id == 1) {
            $branch = Branch::get();
        } elseif (Auth::user()->role_id == 2) {
            $branch = Branch::where('area_id', Auth::user()->employee->branch->area_id)->get();
        } else {
            $branch = Branch::where('id', Auth::user()->employee->branch_id)->get();
        }
        $technician = Employee::where('branch_id', $branchUser)->get();

        return view('pages.backend.report.reportService',compact('type', 'technician', 'branch'));
    }

    public function dataLoad(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate1;
        $endDate = $req->endDate1;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServiceLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function typeLoad(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate2;
        $endDate = $req->endDate2;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('series', $req->type_id)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('series', $req->type_id)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServiceLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function technicianLoad(Request $req)
    {
        $startDate = $req->startDate3;
        $endDate = $req->endDate3;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('technician_id', $req->technician_id)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('technician_id', $req->technician_id)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServiceLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function branchLoad(Request $req)
    {
        $startDate = $req->startDate4;
        $endDate = $req->endDate4;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $req->branch_id)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $req->branch_id)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServiceLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function printPeriode(Request $req)
    {
        $title = 'Laporan Service per Periode';
        $subtitle = ' ';
        $periode = $req->startDate1. ' - ' .$req->endDate1;
        $val = ' ';
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate1;
        $endDate = $req->endDate1;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.printReportService', compact('data', 'tr', 'sumKotor', 'sumBersih','title', 'subtitle', 'val', 'periode'));
    }

    public function printSeries (Request $req)
    {
        $type = Type::where('id', $req->type_id)->first();
        $brand = Brand::where('id', $type->brand_id)->first();
        $title = 'Laporan Service per Series';
        $subtitle = 'Series';
        $periode = $req->startDate2. ' - ' .$req->endDate2;
        $val = $brand->name .' '. $type->name;
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate2;
        $endDate = $req->endDate2;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('series', $req->type_id)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('series', $req->type_id)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.printReportService', compact('data', 'tr', 'sumKotor', 'sumBersih', 'title', 'subtitle', 'val', 'periode'));
    }

    public function printTechnician (Request $req)
    {
        $teknisi = Employee::where('id', $req->technician_id)->first();
        $title = 'Laporan Service per Teknisi';
        $subtitle = 'Teknisi';
        $periode = $req->startDate3. ' - ' .$req->endDate3;
        $val = $teknisi->name;
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate3;
        $endDate = $req->endDate3;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('technician_id', $req->technician_id)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->where('technician_id', $req->technician_id)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.printReportService', compact('data', 'tr', 'sumKotor', 'sumBersih', 'title', 'subtitle', 'val', 'periode'));
    }

    public function printBranch (Request $req)
    {
        $branch = Branch::where('id', $req->branch_id)->first();
        $title = 'Laporan Service per Cabang';
        $subtitle = 'Cabang';
        $periode = $req->startDate4. ' - ' .$req->endDate4;
        $val = $branch->name;
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate4;
        $endDate = $req->endDate4;
        $data = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $req->branch_id)
        ->orderBy('id', 'desc')->get();

        $bayar = Service::with(['Type', 'Brand'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $req->branch_id)
        ->where('payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total_price');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.printReportService', compact('data', 'tr', 'sumKotor', 'sumBersih', 'title', 'subtitle', 'val', 'periode'));
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
}
