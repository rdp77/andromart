<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Stock;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $checkRoles = $this->DashboardController->cekHakAkses(35,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $branchUser = Auth::user()->employee->branch_id;
            $data = Stock::with('item', 'unit', 'branch')->where('branch_id', $branchUser)->where('id', '!=', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('stock.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })

                ->addColumn('dataBuy', function ($row) {
                    $htmlAdd =   '<tr>';
                    $htmlAdd .=      '<td class="text-right">'.'Rp. '. number_format($row->item->buy, 0, ".", ",") .'</td>';
                    $htmlAdd .=   '</tr>';

                    return $htmlAdd;
                })

                ->addColumn('dataPrice', function ($row) {
                    $price = $row->item->buy*$row->stock;
                    $htmlAdd =   '<tr>';
                    $htmlAdd .=      '<td class="text-right">'.'Rp. '. number_format($price, 0, ".", ",") .'</td>';
                    $htmlAdd .=   '</tr>';

                    return $htmlAdd;
                })

                ->rawColumns(['action','dataBuy', 'dataPrice'])
                ->make(true);
        }
        return view('pages.backend.warehouse.stockOpname.indexStockOpname');
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
