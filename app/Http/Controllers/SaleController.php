<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\StockMutation;
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
use GuzzleHttp\Promise\Create;

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
            $data = Sale::with('SaleDetail','SaleDetail.Item')->get();
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
                    foreach ($row->SaleDetail as $key => $value) {
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<th>'.$value->Item->name.'</th>';
                        $htmlAdd .=      '<th>'.$value->qty.'</th>';
                        $htmlAdd .=   '</tr>';
                    }
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('finance', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Barang</td>';
                    $htmlAdd .=      '<th>'.number_format($row->item_price,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Sales</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sharing_profit_sales,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Diskon</td>';
                    $htmlAdd .=      '<th>'.number_format($row->discount_price,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Buyer</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sharing_profit_buyer,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_price,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Toko</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sharing_profit_store,0,".",",").'</th>';
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
        $userBranch = Auth::user()->employee->branch_id;
        $item = Item::with('stock')->where('name','!=','Jasa Service')->get();
        return view('pages.backend.transaction.sale.createSale', compact('code', 'employee', 'item', 'warranty', 'customer'));
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            $id = DB::table('sales')->max('id')+1;
            $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();

            // $sharing_profit_store =  ((str_replace(",", '',$req->totalService)/100)*$sharingProfitStore)+str_replace(",", '',$req->totalSparePart);
            // $sharing_profit_sales = (str_replace(",", '',$req->totalService)/100)*$sharingProfitTechnician;

            Sale::create([
                'id' => $id,
                'code' => $this->code('PJT-'),
                'user_id' => Auth::user()->id,
                'sales_id' => $req->sales_id,
                'branch_id' => $getEmployee->branch_id,
                'customer_id' => $req->customer_id,
                'customer_name' => $req->customer_name,
                'customer_address' => $req->customer_address,
                'customer_phone' => $req->customer_phone,
                'date' => date('Y-m-d'),
                'warranty_id' => $req->warranty,
                'discount_type' => $req->typeDiscount,
                'discount_price' => str_replace(",", '',$req->totalDiscountValue),
                'discount_percent' => str_replace(",", '',$req->totalDiscountPercent),
                'item_price' => str_replace(",", '',$req->totalSparePart),
                'total_price' => str_replace(",", '',$req->totalPrice),
                // 'sharing_profit_store' => str_replace(",", '',$req->sharing_profit_store),
                // 'sharing_profit_sales' => str_replace(",", '',$req->sharing_profit_sales),
                'sharing_profit_store' => '0',
                'sharing_profit_sales' => '0',
                'sharing_profit_buyer' => '0',
                'description' => $req->description,
                'created_at' =>date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->name,
            ]);

            $checkStock = [];
            for ($i=0; $i <count($req->itemsDetail) ; $i++) {
                SaleDetail::create([
                    'sale_id'=> $id,
                    'item_id'=> $req->itemsDetail[$i],
                    'price'=> str_replace(",", '',$req->priceDetail[$i]),
                    'qty'=> $req->qtyDetail[$i],
                    'total'=> str_replace(",", '',$req->totalPriceDetail[$i]),
                    'description' => $req->descriptionDetail[$i],
                    'type' => $req->typeDetail[$i],
                    'created_by'=> Auth::user()->name,
                    'created_at'=> date('Y-m-d h:i:s'),
                ]);
                if($req->typeDetail[$i] != 'Jasa'){
                    $checkStock[$i] = Stock::where('item_id',$req->itemsDetail[$i])
                                ->where('branch_id',Auth::user()->id)
                                ->where('id','!=',1)
                                ->get();
                    if($checkStock[$i][0]->stock < $req->qtyDetail[$i]){
                        return Response::json(['status' => 'fail',
                                        'message'=>'Stock Item Ada yang 0. Harap Cek Kembali']);
                    }
                    if($req->typeDetail[$i] == 'SparePart'){
                    $desc[$i] = 'Pengeluaran Barang Pada Penjualan '.$this->code('PJT-');
                    }else{
                    $desc[$i] = 'Pengeluaran Barang Loss Pada Penjualan '.$this->code('PJT-');
                    }
                    Stock::where('item_id',$req->itemsDetail[$i])
                    ->where('branch_id',Auth::user()->id)->update([
                        'stock'      =>$checkStock[$i][0]->stock-$req->qtyDetail[$i],
                    ]);
                    StockMutation::create([
                        'item_id'    =>$req->itemsDetail[$i],
                        'unit_id'    =>$checkStock[$i][0]->unit_id,
                        'branch_id'  =>$checkStock[$i][0]->branch_id,
                        'qty'      =>$req->qtyDetail[$i],
                        'code'       =>$this->code('PJT-'),
                        'type'       =>'Out',
                        'description'=>$desc[$i],
                    ]);
                }
            }
            DB::commit();
            return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return Response::json(['status' => 'error','message'=>$th]);
        }
        // return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sale = Sale::with(['SaleDetail', 'Sales', 'Buyer'])->find($id);
        $sales = Employee::where('id', '!=', Sale::find($id)->sales_id)->get();
        // $buyer = Employee::where('id', '!=', Sale::find($id)->sales_id)->get();
        // return $sales;
        $warranty = Warranty::where('id', '!=', Sale::find($id)->warranty_id)->get();
        $customer = Customer::where('id', '!=', Sale::find($id)->customer_id)->get();
        $userBranch = Auth::user()->employee->branch_id;
        $item = Item::with('stock')->where('name','!=','Jasa Service')->get();
        return view('pages.backend.transaction.sale.updateSale', compact('sale', 'item', 'warranty', 'customer', 'sales'));

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
