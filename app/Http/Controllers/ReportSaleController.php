<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountData;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class ReportSaleController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function reportSale()
    {
        $branchUser = Auth::user()->employee->branch_id;
        $stock = Stock::where('branch_id', $branchUser)->where('id', '!=', 1)->get();
        $sales = Employee::where('branch_id', $branchUser)->where('id', '!=', 1)->get();
        $kas = AccountData::where('branch_id', $branchUser)->where('active', 'Y')->where('name', 'LIKE', '%'.'Kas'.'%')->get();
        $customer = Customer::where('branch_id', $branchUser)->get();
        $branch = Branch::get();

        return view('pages.backend.report.reportSale', compact(['stock', 'sales', 'kas', 'customer', 'branch']));
    }

    public function dataLoad(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $req->startDate1;
        $endDate = $req->endDate1;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $branchUser)
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function itemLoad(Request $req)
    {
        $startDate = $req->startDate2;
        $endDate = $req->endDate2;
        $item = $req->item;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->leftJoin('sale_details','sale_details.sale_id','=','sales.id')
        ->select('sales.id', 'sales.date', 'sales.code', 'sales.account', 'sales.total_price', 'sales.total_profit_store')
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('sale_details.item_id', '=', $item)
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function salesLoad(Request $req)
    {
        $startDate = $req->startDate3;
        $endDate = $req->endDate3;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('sales_id', $req->sales)
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function kasLoad(Request $req)
    {
        $startDate = $req->startDate4;
        $endDate = $req->endDate4;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('account', $req->kas)
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function customerLoad(Request $req)
    {
        $startDate = $req->startDate5;
        $endDate = $req->endDate5;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('customer_id', $req->customer)
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
    }

    public function branchLoad(Request $req)
    {
        $startDate = $req->startDate6;
        $endDate = $req->endDate6;
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($startDate))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($endDate))
        ->where('branch_id', $req->branch)
        ->orderBy('id', 'desc')->get();

        $sumKotor = $data->sum('total_price');
        $sumBersih = $data->sum('total_profit_store');
        $tr = count($data);

        return view('pages.backend.report.reportSaleLoad', compact('data', 'tr', 'sumKotor', 'sumBersih'));
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
