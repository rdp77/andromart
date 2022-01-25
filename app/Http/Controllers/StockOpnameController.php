<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Stock;
use App\Models\Item;
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
        $item = Stock::with('item')
        ->where('branch_id', $branchUser)
        ->where('item_id', '!=', 1)
        ->get();
        $sumItem = Stock::with('item')->where('branch_id', $branchUser)->sum('stock');

        $sumActiva = Stock::with('item')
        ->leftJoin('items', 'items.id', '=', 'stocks.item_id')
        ->where('branch_id', $branchUser)
        ->select('stocks.stock as stock', 'items.buy as buy', 'items.id as itemq')
        // ->get('itemq', 'stock', 'buy');
        ->sum('buy');
        // return $sumActiva;

        return view('pages.backend.warehouse.stockOpname.indexStockOpname', compact('item', 'sumItem', 'sumActiva'));
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
