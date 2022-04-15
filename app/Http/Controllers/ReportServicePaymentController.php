<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServicePayment;
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

class ReportServicePaymentController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function reportServicePayment()
    {
        $branchUser = Auth::user()->employee->id;
        $type = Type::get();
        if (Auth::user()->role_id == 1) {
            $branch = Branch::get();
        } elseif (Auth::user()->role_id == 2) {
            $branch = Branch::where('area_id', Auth::user()->employee->branch->area_id)->get();
        } else {
            $branch = Branch::where('id', Auth::user()->employee->branch_id)->get();
        }

        return view('pages.backend.report.reportServicePayment', compact('type', 'branch' ));
    }

    public function dataLoad(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate1;
        $endDate = $req->endDate1;
        $data = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.description as description', 'service_payment.date',
            'service_payment.code as paymentCode', 'service.code as serviceCode', 'service_payment.date as paymentDate',
            'service.date as serviceDate', 'service.customer_name', 'service.customer_phone', 'service.customer_address',
            'service.work_status', 'service_payment.total', 'service_payment.type')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->orderBy('service_payment.id', 'DESC')->get();

        $bayar = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.date', 'service_payment.date as paymentDate',
            'service.payment_status', 'service_payment.total', 'service.sharing_profit_store')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('service.payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServicePaymentLoad', compact('data', 'sumKotor', 'sumBersih', 'tr'));
    }

    public function branchLoad(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate2;
        $endDate = $req->endDate2;
        $branch = $req->branch_id;
        $data = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.description as description', 'service_payment.date',
            'service_payment.code as paymentCode', 'service.code as serviceCode', 'service_payment.date as paymentDate',
            'service.date as serviceDate', 'service.customer_name', 'service.customer_phone', 'service.customer_address',
            'service.work_status', 'service_payment.total', 'service_payment.type')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('service.branch_id', $branch)
        ->orderBy('service_payment.id', 'DESC')->get();

        $bayar = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.date', 'service_payment.date as paymentDate',
            'service.payment_status', 'service_payment.total', 'service.sharing_profit_store')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('service.branch_id', $branch)
        ->where('service.payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportServicePaymentLoad', compact('data', 'sumKotor', 'sumBersih', 'tr'));
    }

    public function printPeriode(Request $req)
    {
        $title = 'Laporan Pemabayaran Service per Periode';
        $subtitle = ' ';
        $periode = $req->startDate1. ' - ' .$req->endDate1;
        $val = ' ';
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate1;
        $endDate = $req->endDate1;
        $data = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.description as description', 'service_payment.date',
            'service_payment.code as paymentCode', 'service.code as serviceCode', 'service_payment.date as paymentDate',
            'service.date as serviceDate', 'service.customer_name', 'service.customer_phone', 'service.customer_address',
            'service.work_status', 'service_payment.total', 'service_payment.type')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->orderBy('service_payment.id', 'DESC')->get();

        $bayar = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.date', 'service_payment.date as paymentDate',
            'service.payment_status', 'service_payment.total', 'service.sharing_profit_store')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('service.payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.printReportServicePayment', compact('data', 'tr', 'sumKotor', 'sumBersih', 'title', 'subtitle', 'val', 'periode'));
    }

    public function printBranch(Request $req)
    {
        $title = 'Laporan Pemabayaran Service per Cabang';
        $subtitle = ' ';
        $periode = $req->startDate2. ' - ' .$req->endDate2;
        $val = ' ';
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate2;
        $endDate = $req->endDate2;
        $branch = $req->branch_id;
        $data = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.description as description', 'service_payment.date',
            'service_payment.code as paymentCode', 'service.code as serviceCode', 'service_payment.date as paymentDate',
            'service.date as serviceDate', 'service.customer_name', 'service.customer_phone', 'service.customer_address',
            'service.work_status', 'service_payment.total', 'service_payment.type')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('service.branch_id', $branch)
        ->orderBy('service_payment.id', 'DESC')->get();

        $bayar = ServicePayment::with('Service')
        ->Join('service', 'service.id', '=', 'service_payment.service_id')
        ->select(
            'service_payment.date', 'service_payment.date as paymentDate',
            'service.payment_status', 'service_payment.total', 'service.sharing_profit_store')
        ->where('service_payment.date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('service_payment.date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('service.branch_id', $branch)
        ->where('service.payment_status', 'Lunas')->get();

        $sumKotor = $bayar->sum('total');
        $sumBersih = $bayar->sum('sharing_profit_store');
        $tr = count($data);

        return view('pages.backend.report.printReportServicePayment', compact('data', 'tr', 'sumKotor', 'sumBersih', 'title', 'subtitle', 'val', 'periode'));
    }
}
