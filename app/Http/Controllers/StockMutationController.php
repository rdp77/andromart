<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Category;
use App\Models\Stock;
use App\Models\StockMutation;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Service;
use App\Models\StockTransaction;
use App\Models\ServicePayment;
use App\Models\ServiceDetail;
use App\Models\ServiceStatusMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;

class StockMutationController extends Controller
{
    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = StockMutation::with('branch')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('sale.edit', $row->id) . '" >Edit</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Cetak</a>';
                    // $actionBtn .= '<a onclick="" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('invoice', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->code.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataBranch', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>'.$row->branch->area->name.'</td>';
                    $htmlAdd .=      '<th>'.$row->branch->name.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataItem', function ($row) {
                    $htmlAdd = '<table>';
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<td>'.$row->item->brand->name.'</td>';
                        $htmlAdd .=      '<th>'.$row->item->name.'</th>';
                        $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataQty', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Tipe</td>';
                    $htmlAdd .=      '<th>'.$row->type.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Qty</td>';
                    $htmlAdd .=      '<th>'.$row->qty.'</th>';
                    $htmlAdd .=      '<th>'.$row->unit->code.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })

                ->rawColumns(['invoice','dataBranch','dataItem','dataQty'])
                ->make(true);
        }
        return view('pages.backend.warehouse.stockMutation.indexStockMutation');
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
