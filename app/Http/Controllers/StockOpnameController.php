<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class StockOpnameController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(39,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $branchUser = Auth::user()->employee->branch_id;
        $category = Category::with('brand', 'brand.item', 'brand.item.stocks')->get();

        $item = Stock::with('item', 'item.brand', 'item.brand.category')
        ->leftJoin('units', 'units.id', 'stocks.unit_id')
        ->leftJoin('items', 'items.id', 'stocks.item_id')
        ->leftJoin('brands', 'brands.id', 'items.brand_id')
        ->leftJoin('categories', 'categories.id', 'brands.category_id')
        ->where('branch_id', $branchUser)
        ->where('item_id', '!=', 1)
        ->select('brands.name as merk', 'items.name as itemName', 'categories.code as category', 'units.code as satuan', 'items.buy as hargabeli', 'stocks.stock as stock')
        ->get();

        return view('pages.backend.warehouse.stockOpname.indexStockOpname', compact('category','item'));
    }

    public function printStockOpname()
    {
        $branchUser = Auth::user()->employee->branch_id;
        $category = Category::with('brand', 'brand.item', 'brand.item.stocks')->get();

        $item = Stock::with('item', 'item.brand', 'item.brand.category')
        ->leftJoin('units', 'units.id', 'stocks.unit_id')
        ->leftJoin('items', 'items.id', 'stocks.item_id')
        ->leftJoin('brands', 'brands.id', 'items.brand_id')
        ->leftJoin('categories', 'categories.id', 'brands.category_id')
        ->where('branch_id', $branchUser)
        ->where('item_id', '!=', 1)
        ->select('brands.name as merk', 'items.name as itemName', 'categories.code as category', 'units.code as satuan', 'items.buy as hargabeli', 'stocks.stock as stock')
        ->get();
        $itung = count($item);
        return view('pages.backend.warehouse.stockOpname.printStockOpname', compact('item', 'category', 'itung'));
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
