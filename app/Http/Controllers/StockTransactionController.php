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

class StockTransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'view');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        if ($req->ajax()) {
        $data = StockTransaction::with('item','item.stock','item.stock.unit','item.stock.branch'
        )->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    // $actionBtn .= '<a onclick="reset(' . $row->id . ')" class="btn btn-primary text-white" style="cursor:pointer;">Reset Password</a>';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button><div class="dropdown-menu">';
                    // $actionBtn .= '
                            // <a class="dropdown-item" href="' . route('service-payment.edit', $row->id) . '"><i class="far fa-edit"></i> Edit</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })

                ->addColumn('typeInOut', function ($row){
                    if($row->type == 'In'){
                        return '<div class="badge badge-success">In</div>';
                    }elseif($row->type == 'Out'){
                        return '<div class="badge badge-danger">Out</div>';
                    }
                })


                ->rawColumns(['action','typeInOut'])
                ->make(true);
        }
        return view('pages.backend.warehouse.stockTransaction.indexStockTransaction');
    }

    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('stocks_transaction')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$year . $month . $index;
    }
    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'create');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        // $code   = $this->code('-');
        // $items  = Item::where('name','!=','Jasa Service')->get();
        $item     = Item::with('stock','supplier')->where('name','!=','Jasa Service')->get();
        $brand    = Brand::get();
        $type     = Type::get();
        $category = Category::get();
        return view('pages.backend.warehouse.stockTransaction.createStockTransaction',compact('item','brand','type','category'));
    }

    public function store(Request $req)
    {

        $dateConvert = $this->DashboardController->changeMonthIdToEn($req->date);
        $id = DB::table('stocks_transaction')->max('id')+1;

        $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
        $checkStock = Stock::where('item_id',$req->item)
                                ->where('branch_id',$getEmployee->branch_id)
                                ->first();
        if($req->type == 'In'){
            $code = $this->code('SIN-');
            $stockQty = $checkStock->stock+$req->qty;
            $desc = "Pemasukan Barang Atas '".$req->reason."' di transaksi ".$code;
        }else{
            $code = $this->code('SOT-');
            $stockQty = $checkStock->stock-$req->qty;
            $desc = "Pengeluaran Barang Atas '".$req->reason."' di transaksi ".$code;
            if($checkStock->stock < $req->qty){
                return Response::json(['status' => 'fail',
                'message'=>'Stock Item Kurang Dari yang akan dikeluarkan.']);
            }
        }

        StockTransaction::create([
            'id'=>$id,
            'code'=>$code,
            'item_id'=>$req->item,
            'unit_id'=>$checkStock->unit_id,
            'branch_id'=>$checkStock->branch_id,
            'qty'=>$req->qty,
            'type'=>$req->type,
            'reason'=>$req->reason,
            'date'=>$dateConvert,
            'description'=>$req->description,
            'created_by' => Auth::user()->name,
            'created_at' => date('Y-m-d h:i:s'),
        ]);


        Stock::where('item_id',$req->item)
                    ->where('branch_id',$getEmployee->branch_id)
                    ->update([
                        'stock' =>$stockQty,
                    ]);

        StockMutation::create([
            'item_id'    =>$req->item,
            'unit_id'    =>$checkStock->unit_id,
            'branch_id'  =>$checkStock->branch_id,
            'qty'        =>$req->qty,
            'code'       =>$code,
            'type'       =>$req->type,
            'description'=>$desc,
        ]);


        return Response::json(['status' => 'success','message'=>'Data Tersimpan']);

    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'edit');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.warehouse.stockTransaction.editStockIn', ['Service' => $Service,'member'=>$member]);
    }

    // public function update($id, Request $req)
    // {

    //     Service::where('id', $id)
    //         ->update([
    //         'sales_id'   => $req->salesId,
    //         'liquid_date'=> date('Y-m-d',strtotime($req->liquidDate)),
    //         'total'      => str_replace(",", '',$req->total),
    //         'updated_by' => Auth::user()->name,
    //         'updated_at' => date('Y-m-d h:i:s'),
    //     ]);

    //     $Service = Service::find($id);
    //     $this->DashboardController->createLog(
    //         $req->header('user-agent'),
    //         $req->ip(),
    //         'Mengubah Service ' . Service::find($id)->name
    //     );

    //     $Service->save();

    //     return Redirect::route('servicePaymenStockTransaction')
    //         ->with([
    //             'status' => 'Berhasil merubah Dana Kredit',
    //             'type' => 'success'
    //         ]);
    // }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Kredit'
        );
        Service::destroy($id);
        ServiceDetail::where('service_id',$id)->destroy($id);
        return Response::json(['status' => 'success']);
    }
}
