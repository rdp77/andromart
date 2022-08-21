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
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(38,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = StockMutation::with('branch')->orderBy('id','ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('invoice', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->code . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->created_at . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataBranch', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>' . $row->branch->area->name . '</td>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->branch->name . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataItem', function ($row) {
                    if (isset($row->item->brand->name)) {
                        $htmlAdd = '<table>';
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<td>' . $row->item->brand->name . '</td>';
                        $htmlAdd .=   '</tr>';
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<th>' . $row->item->name . '</th>';
                        $htmlAdd .=   '</tr>';
                        $htmlAdd .= '<table>';
                    }else{
                        $htmlAdd = 'Data Error / Data Item Telah Dihapus';
                    }

                    return $htmlAdd;
                })
                ->addColumn('dataQty', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Tipe</td>';
                    $htmlAdd .=      '<th>' . $row->type . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Qty</td>';
                    $htmlAdd .=      '<th>' . $row->qty .' '. $row->unit->code . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })

                ->rawColumns(['invoice', 'dataBranch', 'dataItem', 'dataQty'])
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
