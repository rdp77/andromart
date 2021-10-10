<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\PurchasingDetail;
use App\Models\Stock;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class PurchaseController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Purchasing::with('employee')->get();
            foreach($data as $row) {
                $tanggal = date("d F Y", strtotime($row->date));
                $row->date = $tanggal;
                if($row->done == 2) {
                    $row->done = "Telah Selesai";
                } else if ($row->done == 1) {
                    $row->done = "Masih Proses";
                } else if ($row->done == 3) {
                    $row->done = "Telah DiSetujui";
                } else {
                    $row->done = "Belum Proses";
                }
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    if($row->done == 'Belum Proses'){
                        $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('purchaseApprove', Crypt::encryptString($row->id)) . '">Setujui</a>';
                        // $actionBtn .= '<a class="dropdown-item" href="' . route('purchase.edit', Crypt::encryptString($row->id)) . '">Ubah</a>';
                        $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    } else {
                        $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('reception.edit', Crypt::encryptString($row->id)) . '">Terima</a>';
                    }
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.transaction.purchase.indexPurchase');
    }

    public function code($type)
    {
        $date = date('Y-m-d');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        $getEmployee =  Employee::with('branch')->where('user_id',Auth::user()->id)->first();
        $now = Purchasing::whereBetween("created_at", [$date.' 00:00:00', $date.' 23:59:59'])->count();
        $index = $now + 1;
        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$getEmployee->Branch->code.$year . $month . $index;
    }
    public function create()
    {
        $code     = $this->code('PCS');
        $employee = Employee::get();
        // $items    = Item::where('name','!=','Jasa Service')->get();
        $item     = Item::with('stock')->where('items.name','!=','Jasa Service')
        ->join('suppliers', 'items.supplier_id', 'suppliers.id')
        ->select('items.id as id', 'items.name as name', 'buy', 'suppliers.name as supplier')
        ->get();
        $unit     = Unit::get();
        $branch   = Branch::get();
        return view('pages.backend.transaction.purchase.createPurchase',compact('employee','code','item', 'unit', 'branch'));
        // return view('pages.backend.transaction.purchase.createPurchase');
    }
    function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[1] ) );

        // clean up the file resource
        fclose( $ifp ); 

        return $output_file; 
    }

    public function store(Request $req)
    {
        $image = $req->image;
        // $file = 'assetstransaction/Reception_' . date('YmdHis') . '.png';
        $fileSave = 'assetstransaction/Purchasing_' . $this->code('PCS') . '.' .'png';
        $fileName = 'Purchasing_' . $this->code('PCS') . '.' .'png';
        $images = $this->base64_to_jpeg($image, $fileSave);

        $date = date('Y-m-d H:i:s');
        $purchasing = new Purchasing;
        $purchasing->code = $req->code;
        $purchasing->date = $date;
        $purchasing->employee_id = $req->buyer;
        $purchasing->status = $req->pay;
        
        $purchasing->discount = str_replace(",", '',$req->discountTotal);
        $purchasing->price = str_replace(",", '',$req->grandTotal);
        $purchasing->created_by = Auth::user()->name;

        $purchasing->image = $fileName;
        $purchasing->save();

        foreach($req->idDetail as $row) {
            // dd($req->qtyDetail);
            $purchasingDetail = new PurchasingDetail;
            $purchasingDetail->purchasing_id = $purchasing->id;
            $purchasingDetail->item_id = $req->itemsDetail[$row];
            // $purchasingDetail->unit_id = $req->unitsDetail[$row];
            $purchasingDetail->branch_id = $req->branchesDetail[$row];
            $purchasingDetail->price = str_replace(",", '',$req->priceDetail[$row]);
            $purchasingDetail->qty_start = str_replace(",", '',$req->qtyDetail[$row]);
            $purchasingDetail->qty = str_replace(",", '',$req->qtyDetail[$row]);
            $purchasingDetail->total = str_replace(",", '',$req->totalPriceDetail[$row]);
            $purchasingDetail->description = $req->desDetail[$row];
            $purchasingDetail->created_by = Auth::user()->name;
            $purchasingDetail->save();
        }
        return Redirect::route('purchase.index')
            ->with([
                'status' => 'Berhasil membuat menambah pembelian',
                'type' => 'success'
            ]);
    }

    public function show(Notes $notes, $id)
    {
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $employee = Employee::get();
        // $items    = Item::where('name','!=','Jasa Service')->get();
        $item     = Item::with('stock')->where('items.name','!=','Jasa Service')
        ->join('suppliers', 'items.supplier_id', 'suppliers.id')
        ->select('items.id as id', 'items.name as name', 'buy', 'suppliers.name as supplier')
        ->get();
        $unit     = Unit::get();
        $branch   = Branch::get();
        $model = Purchasing::where('id', $id)->first();
        $models = PurchasingDetail::where('purchasing_id', $id)
        ->join('items', 'purchasing_details.item_id', 'items.id')
        ->join('units', 'purchasing_details.unit_id', 'units.id')
        ->join('branches', 'purchasing_details.branch_id', 'branches.id')
        ->select('purchasing_details.id as id', 'qty', 'items.id as item_id', 'items.name as item_name', 'units.id as unit_id', 'units.name as unit_name', 'branches.id as branch_id', 'branches.name as branch_name', 'purchasing_details.description as description')
        ->get();
        // dd($models);
        $jumlah = PurchasingDetail::where('purchasing_id', $id)->count();
        return view('pages.backend.transaction.purchase.editPurchase',compact('employee','item', 'unit', 'branch', 'model', 'models', 'jumlah'));
    }

    public function update(Request $req, $id)
    {
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Pembelian ' . Purchasing::find($id)->name
        );
        PurchasingDetail::where('purchasing_id', $id)->delete();
        Purchasing::destroy($id);

        return Response::json(['status' => 'success']);
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Purchasing $purchasing)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Purchasing $purchasing)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Purchasing $purchasing)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Purchasing $purchasing)
    // {
    //     //
    // }

    public function approve($id)
    {
        $id = Crypt::decryptString($id);
        $purchase = Purchasing::where('id', $id)->first();
        $purchase->done = 3;
        $purchase->updated_by = Auth::user()->name;
        $purchase->save();
        return Redirect::route('purchase.index')
            ->with([
                'status' => 'Berhasil disetujui',
                'type' => 'success'
            ]);
    }
}
