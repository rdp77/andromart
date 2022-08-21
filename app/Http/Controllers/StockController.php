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

class StockController extends Controller
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
            $authCheck = Auth::user()->role_id;
            $branchUser = Auth::user()->employee->branch_id;
            $data = Stock::with('item', 'unit', 'branch')
            ->where(function ($query) use ($branchUser,$authCheck) {
                if ($authCheck != 1) {
                    $query ->where('branch_id', $branchUser);
                }
            })
            ->where('id', '!=', 1)->get();
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

                ->addColumn('dataItem', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>'.$row->item->brand->category->code.'</td>';
                    $htmlAdd .=      '<th>'.$row->item->name.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataQty', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Stock</td>';
                    $htmlAdd .=      '<th>'.$row->stock.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Min. Stock</td>';
                    $htmlAdd .=      '<th>'.$row->min_stock.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->rawColumns(['action', 'dataItem', 'dataQty'])
                ->make(true);
        }
        return view('pages.backend.warehouse.stock.indexStock');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(35,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $item = Item::where('id', '!=', '1')->orderBy('brand_id', 'asc')->get();
        $branch = Branch::get();
        $unit = Unit::orderBy('name', 'asc')->get();
        return view('pages.backend.warehouse.stock.createStock', compact('item', 'branch', 'unit'));
    }

    public function store(Request $req)
    {
        Stock::create([
            'item_id'   => $req->item_id,
            'unit_id'   => $req->unit_id,
            'branch_id' => $req->branch_id,
            'stock'     => 0,
            'min_stock' => $req->min_stock,
            'description' => $req->description,
            'created_by' => Auth::user()->name
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat stok baru'
        );

        return Redirect::route('stock.index')
            ->with([
                'status' => 'Berhasil membuat stock baru',
                'type' => 'success'
            ]);
    }

    public function show(Stock $stock)
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(35,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $branch = Branch::get();
        $unit = Unit::get();
        $stock = Stock::find($id);
        return view('pages.backend.warehouse.stock.updateStock', compact('stock', 'branch', 'unit'));
    }

    public function update(Request $req, $id)
    {
        Stock::where('id', $id)
        ->update([
            'min_stock' => $req->min_stock,
            'unit_id' => $req->unit_id,
            'description' => $req->description,
        ]);

        $stock = Stock::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah stock barang ' . Stock::find($id)->item->name
        );

        $stock->save();

        return Redirect::route('stock.index')
            ->with([
                'status' => 'Berhasil merubah stock barang ',
                'type' => 'success'
            ]);
    }

    public function destroy(Stock $stock)
    {
        //
    }
}
