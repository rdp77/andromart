<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Employee;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\Purchasing;
use App\Models\PurchasingDetail;
use App\Models\Sale;
use App\Models\HistoryDetailPurchase;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ReportPurchaseController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function reportPurchase()
    {
        $stock = Stock::where('branch_id', Auth::user()->employee->branch_id)->where('id', '!=', 1)->get();
        $supplier = Supplier::get();
        if (Auth::user()->role_id == 1) {
            $branch = Branch::get();
        } elseif (Auth::user()->role_id == 2) {
            $branch = Branch::where('area_id', Auth::user()->employee->branch->area_id)->get();
        } else {
            $branch = Branch::where('id', Auth::user()->employee->branch_id)->get();
        }

        return view('pages.backend.report.reportPurchase', compact('stock', 'supplier', 'branch'));
    }

    public function changeDate($date) {
        $array = explode(' ', $date);
        $month = ['bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthNumber = array_search($array[1], $month);
        $output = $array[2]."-".$monthNumber."-".$array[0];
        return $output;
    }

    public function dataLoad(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $this->changeDate($req->startDate1)." 00:00:00";
        $endDate = $this->changeDate($req->endDate1)." 23:59:59";
        $data = Purchasing::with('purchasingDetail')
        ->where('branch_id', $branchUser)
        ->whereBetween('date', [$startDate, $endDate])
        ->orderBy('id', 'desc')->get();
        $tr = count($data);
        $sumBayar = $data->sum('price');

        return view('pages.backend.report.reportPurchaseLoad', compact('data', 'tr', 'sumBayar'));
    }

    public function itemLoad(Request $req)
    {
        $item = $req->item;
        $startDate = $this->changeDate($req->startDate2)." 00:00:00";
        $endDate = $this->changeDate($req->endDate2)." 23:59:59";
        $data = Purchasing::with('purchasingDetail')
        ->leftJoin('purchasing_details', 'purchasing_details.purchasing_id', '=', 'purchasings.id')
        ->select('purchasings.id', 'purchasings.date', 'purchasings.code', 'purchasings.price', 'purchasings.status', 'purchasings.employee_id')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('purchasing_details.item_id', '=', $item)
        ->orderBy('id', 'desc')->get();

        $tr = count($data);
        $sumBayar = $data->sum('price');

        return view('pages.backend.report.reportPurchaseLoad', compact('data', 'tr', 'sumBayar'));
    }

    public function supplierLoad(Request $req)
    {
        $supplier = $req->supplier;
        $branchUser = Auth::user()->employee->branch_id;
        $startDate = $this->changeDate($req->startDate3)." 00:00:00";
        $endDate = $this->changeDate($req->endDate3)." 23:59:59";
        $data = Purchasing::with(['purchasingDetail', 'purchasingDetail.item', 'purchasingDetail.item.supplier'])
        ->join('purchasing_details', 'purchasing_details.purchasing_id', '=', 'purchasings.id')
        ->join('items', 'items.id', '=', 'purchasing_details.item_id')
        ->select('items.supplier_id','purchasings.id', 'purchasings.date', 'purchasings.code', 'purchasings.price', 'purchasings.status', 'purchasings.employee_id')
        ->where('items.supplier_id', '=', $supplier)
        ->orderBy('id', 'desc')->get();

        $tr = count($data);
        $sumBayar = $data->sum('price');

        return view('pages.backend.report.reportPurchaseLoad', compact('data', 'tr', 'sumBayar'));
    }

    public function branchLoad(Request $req)
    {
        $startDate = $this->changeDate($req->startDate4)." 00:00:00";
        $endDate = $this->changeDate($req->endDate4)." 23:59:59";
        $data = Purchasing::with('purchasingDetail')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('branch_id', $req->branch_id)
        ->orderBy('id', 'desc')->get();
        $tr = count($data);
        $sumBayar = $data->sum('price');

        return view('pages.backend.report.reportPurchaseLoad', compact('data', 'tr', 'sumBayar'));
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
