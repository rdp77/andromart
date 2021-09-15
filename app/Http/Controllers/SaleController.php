<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class SaleController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Sale::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('sale.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('dataDateOperator', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.Carbon::parse($row->date)->locale('id')->isoFormat('LL').'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->created_by.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataCustomer', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_name.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_address.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_phone.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataItem', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Merk</td>';
                    $htmlAdd .=      '<th>'.$row->brand.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Seri</td>';
                    $htmlAdd .=      '<th>'.$row->series.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>tipe</td>';
                    $htmlAdd .=      '<th>'.$row->type.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>imei</td>';
                    $htmlAdd .=      '<th>'.$row->no_imei.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>rusak</td>';
                    $htmlAdd .=      '<th>'.$row->complaint.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('finance', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Service</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_service,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Toko</td>';
                    $htmlAdd .=      '<th>'.number_format(60/100*$row->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Part</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_part,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Teknisi</td>';
                    $htmlAdd .=      '<th>'.number_format(40/100*$row->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Lalai</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_loss,0,".",",").'</th>';
                    if($row->technician_replacement_id != null){
                        $htmlAdd .=      '<td>S.P Teknisi 2</td>';
                        $htmlAdd .=      '<th>'.number_format(40/100*$row->total_price,0,".",",").'</th>';
                    }
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Diskon</td>';
                    $htmlAdd .=      '<th>'.number_format($row->discount_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;

                })

                ->rawColumns(['action','dataItem','dataCustomer','finance','dataDateOperator'])
                ->make(true);
        }
        return view('pages.backend.transaction.sale.indexSale');
    }

    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('sales')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$year . $month . $index;
    }

    public function create()
    {
        $code = $this->code('PJT-');
        $employee = Employee::get();
        $warranty = Warranty::get();
        $customer = Customer::get();
        $item = Item::where('name','!=','Jasa Service')->get();
        return view('pages.backend.transaction.sale.createSale', compact('code', 'employee', 'item', 'warranty', 'customer'));
    }

    public function store(Request $req)
    {

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
