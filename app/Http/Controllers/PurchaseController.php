<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\Service;
use App\Models\PurchasingDetail;
use App\Models\HistoryDetailPurchase;
use App\Models\Stock;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Warranty;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\AccountData;
use App\Models\Cash;

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
                        // <a onclick="approve(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Setujui</a>';
                    if($row->done == 'Belum Proses'){
                        $actionBtn .= '<div class="dropdown-menu">        
                            <a href="/transaction/purchasing/approve/'. $row->id. '" class="dropdown-item" style="cursor:pointer;">Setujui</a>';
                        $actionBtn .= '<a class="dropdown-item" href="' . route('purchase.show', Crypt::encryptString($row->id)) . '">Lihat</a>';
                        $actionBtn .= '<a class="dropdown-item" href="' . route('purchase.edit', Crypt::encryptString($row->id)) . '">Ubah</a>';
                        $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    } else {
                        $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('reception.edit', Crypt::encryptString($row->id)) . '">Terima</a>';
                        $actionBtn .= '<a onclick="jurnal(' ."'". $row->code ."'". ')" class="dropdown-item" style="cursor:pointer;"><i class="fas fa-file-alt"></i> Jurnal</a>';
                        $actionBtn .= '<a class="dropdown-item" href="' . route('purchase.show', Crypt::encryptString($row->id)) . '">Lihat</a>';
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
    public function codeJournals($type)
    {
        $getEmployee =  Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        // DB::table('service')->max('id')+1;
        $index = DB::table('journals')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function create()
    {
        $code     = $this->code('PCS');
        $employee = Employee::get();
        // $items    = Item::where('name','!=','Jasa Service')->get();

        $branch_id = Auth::user()->employee->branch_id;
        $item     = Item::with('stock')->where('items.name','!=','Jasa Service')
        ->join('stocks', 'items.id', 'stocks.item_id')
        ->where('stocks.branch_id', $branch_id)
        ->join('suppliers', 'items.supplier_id', 'suppliers.id')
        ->select('items.id as id', 'items.name as name', 'buy', 'suppliers.name as supplier')
        ->get();
        $unit     = Unit::get();
        $branch   = Branch::get();
        $account  = AccountData::with('AccountMain', 'AccountMainDetail', 'Branch')->get();
        $cash     = Cash::get();
        return view('pages.backend.transaction.purchase.createPurchase',compact('employee','code','item', 'unit', 'branch', 'account', 'cash'));
        // return view('pages.backend.transaction.purchase.createPurchase');
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
        ->join('branches', 'purchasing_details.branch_id', 'branches.id')
        ->select('purchasing_details.id as id', 'qty', 'price', 'items.id as item_id', 'items.name as item_name', 'branches.id as branch_id', 'branches.name as branch_name', 'purchasing_details.description as description')
        ->get();
        $jumlah = PurchasingDetail::where('purchasing_id', $id)->count();
        $account  = AccountData::with('AccountMain', 'AccountMainDetail', 'Branch')->get();
        $cash     = Cash::get();
        return view('pages.backend.transaction.purchase.editPurchase',compact('employee','item', 'unit', 'branch', 'account', 'cash', 'model', 'models', 'jumlah'));
        // return view('pages.backend.transaction.purchase.editPurchase',compact('employee','item', 'unit', 'branch', 'model', 'models', 'jumlah'));
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
        $account = AccountData::find($req->account);
        $branch_id = Auth::user()->employee->branch_id;
        $years = date("Y");
        $dates = date("Y-m-d");

        $typeDiscount = $req->typeDiscount;
        $discountType = 0; $discountValue = 0;
        if($typeDiscount == "percent") {
            $discountType = 0;
            $discountValue = $req->totalDiscountPercent;
        } else {
            $discountType = 1;
            $discountValue = $req->totalDiscountValue;
        }
        $image = $req->image;
        if($image != null) {
            $fileSave = 'assetstransaction/Purchasing_' . $this->code('PCS') . '.' .'png';
            $fileName = 'Purchasing_' . $this->code('PCS') . '.' .'png';
            $images = $this->base64_to_jpeg($image, $fileSave);
        } else {
            $fileName = null;
        }
        $descriptionPurchase = $req->descriptionPurchase;
        if($descriptionPurchase == null) {
            $descriptionPurchase = "Kosong";
        }

        $date = date('Y-m-d H:i:s');
        $purchasing = new Purchasing;
        $purchasing->code = $req->code;
        $purchasing->date = $date;
        $purchasing->employee_id = $req->buyer;
        $purchasing->branch_id = $branch_id;
        // $purchasing->status = $req->pay;

        $purchasing->discountType = $discountType;
        $purchasing->discountValue = str_replace(",", '',$discountValue);
        
        $purchasing->discount = str_replace(",", '',$req->discountTotal);
        $purchasing->price = str_replace(",", '',$req->grandTotal);
        $purchasing->created_by = Auth::user()->name;

        $purchasing->image = $fileName;
        $purchasing->description = $descriptionPurchase;
        $savePurchasing = $purchasing->save();

        if($savePurchasing) {
            $debetKredit = array("K", "D");
            $accountId = array([$account->main_id, $account->main_detail_id], [4, 12]);
            $descriptionJournal = array("Pembelian Kredit", "Pembelian Debit");

            $journal = new Journal;
            $journal->code = "KK".$account->code;
            $journal->year = $years; 
            $journal->date = $dates;
            $journal->total = str_replace(",", '',$req->grandTotal);
            $journal->type = $account->name;
            $journal->ref = $req->code;
            $journal->description = $descriptionPurchase;
            // $journal->description = $descriptionJournal[$key];
            $saveJournal = $journal->save();

            if ($saveJournal) {
                foreach ($debetKredit as $key => $value) {
                    $journalDetail = new JournalDetail;
                    $accountData = AccountData::where('main_id', $accountId[$key][0])->where('main_detail_id', $accountId[$key][1])->where('branch_id', $branch_id)->first();
                    $journalDetail->journal_id = $journal->id;
                    $journalDetail->account_id = $accountData->id;
                    $journalDetail->total = str_replace(",", '',$req->grandTotal);
                    $journalDetail->description = $descriptionPurchase . " " . $descriptionJournal[$key];
                    $journalDetail->debet_kredit = $debetKredit[$key];
                    $journalDetail->save();
                }
            }
        }

        foreach($req->idDetail as $row) {
            // dd($req->qtyDetail);
            $purchasingDetail = new PurchasingDetail;
            $purchasingDetail->purchasing_id = $purchasing->id;
            $purchasingDetail->item_id = $req->itemsDetail[$row];
            // $purchasingDetail->unit_id = $req->unitsDetail[$row];
            // $purchasingDetail->branch_id = $req->branchesDetail[$row];
            $purchasingDetail->branch_id = $branch_id;
            $purchasingDetail->price = str_replace(",", '',$req->priceDetail[$row]);
            $purchasingDetail->qty_start = str_replace(",", '',$req->qtyDetail[$row]);
            $purchasingDetail->qty = str_replace(",", '',$req->qtyDetail[$row]);
            $purchasingDetail->total = str_replace(",", '',$req->totalPriceDetail[$row]);
            $purchasingDetail->description = $req->desDetail[$row];
            $purchasingDetail->created_by = Auth::user()->name;
            $purchasingDetail->save();
            // journal_details (journal_id, account_id, total, description, debet_kredit)
        }
        return Redirect::route('purchase.index')
            ->with([
                'status' => 'Berhasil membuat menambah pembelian',
                'type' => 'success'
            ]);
    }

    public function update(Request $req, $id)
    {
        dd($req->idDetail);
        $account = AccountData::find($req->account);
        $years = date("Y");
        $dates = date("Y-m-d");

        $typeDiscount = $req->typeDiscount;
        $discountType = 0; $discountValue = 0;
        if($typeDiscount == "percent") {
            $discountType = 0;
            $discountValue = $req->totalDiscountPercent;
        } else {
            $discountType = 1;
            $discountValue = $req->totalDiscountValue;
        }

        $image = $req->image;
        if($image != null) {
            $fileSave = 'assetstransaction/Purchasing_' . $this->code('PCS') . '.' .'png';
            $fileName = 'Purchasing_' . $this->code('PCS') . '.' .'png';
            $images = $this->base64_to_jpeg($image, $fileSave);
        } else {
            $fileName = null;
        }

        $descriptionPurchase = $req->descriptionPurchase;
        if($descriptionPurchase == null) {
            $descriptionPurchase = "Kosong";
        }
        $date = date('Y-m-d H:i:s');
        $purchasing = Purchasing::where('id', $id)->first();
        $purchasing->code = $req->code;
        // $purchasing->date = $date;
        $purchasing->employee_id = $req->buyer;
        $purchasing->status = $req->pay;
        
        $purchasing->discount = str_replace(",", '',$req->discountTotal);
        $purchasing->price = str_replace(",", '',$req->grandTotal);
        $purchasing->created_by = Auth::user()->name;

        $purchasing->image = $fileName;
        $savePurchasing = $purchasing->save();

        if($savePurchasing) {
            $codeJournal = array("KK".$account->code, "DD".$account->code);
            $debetKredit = array("K", "D");
            $accountId = array($account->id, $account->id);
            $descriptionJournal = array("Pembelian Kredit", "Pembelian Debit");
            $journalId = [];
            foreach ($codeJournal as $key => $value) {
                $journal = new Journal;
                $journal->code = $value;
                $journal->year = $years; 
                $journal->date = $dates;
                $journal->total = str_replace(",", '',$req->grandTotal);
                $journal->type = $account->name;
                $journal->ref = $req->code;
                $journal->description = $descriptionPurchase;
                // $journal->description = $descriptionJournal[$key];
                $journal->save();
                $journalId[] = $journal->id;
            }
        }

        $deletes = purchasingDetail::where('purchasing_id', $id)->get();
        foreach($deletes as $row) {
            $history = HistoryDetailPurchase::where('purchasing_detail_id', $row->id)->truncate();
            // $delPurchasingDetail = PurchasingDetail::where('purchasing_id', $id)->get();
            $delPurchasingDetail = PurchasingDetail::where('id', $row->id)->delete();
        }

        foreach($req->idDetail as $row => $value) {
            // dd($req->qtyDetail);
            // $row = $rows - 1;
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

            foreach ($journalId as $key => $value) {
                $journalDetail = new JournalDetail;
                $journalDetail->journal_id = $value;
                $journalDetail->account_id = $accountId[$key];
                $journalDetail->total = str_replace(",", '',$req->totalPriceDetail[$row]);
                $journalDetail->description = $req->desDetail[$row];
                $journalDetail->debet_kredit = $debetKredit[$key];
                $journalDetail->save();
            }
        }
        return Redirect::route('purchase.index')
        ->with([
            'status' => 'Berhasil membuat mengubah pembelian',
            'type' => 'success'
        ]);
    }

    public function show($id)
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
        ->join('branches', 'purchasing_details.branch_id', 'branches.id')
        ->select('purchasing_details.id as id', 'qty', 'price', 'items.id as item_id', 'items.name as item_name', 'branches.id as branch_id', 'branches.name as branch_name', 'purchasing_details.description as description')
        ->get();
        $jumlah = PurchasingDetail::where('purchasing_id', $id)->count();
        // dd($model);
        return view('pages.backend.transaction.purchase.showPurchase',compact('employee','item', 'unit', 'branch', 'model', 'models', 'jumlah'));
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
        $purchase = Purchasing::where('id', $id)->first();
        $purchaseDetail = PurchasingDetail::where('purchasing_id', $purchase->id)->get();
        foreach ($purchaseDetail as $key => $value) {
            // $code = 
            $account = AccountData::where('code', )->where('active', 'Y')->first();

        }
        // dd($purchaseDetail);
        $purchase = Purchasing::where('id', $id)->first();
        $purchase->status = 'paid';
        $purchase->done = 3;
        $purchase->updated_by = Auth::user()->name;
        $purchase->save();
        return Redirect::route('purchase.index')
            ->with([
                'status' => 'Berhasil disetujui',
                'type' => 'success'
            ]);
    }


    public function itemCreate()
    {
        $branch = Branch::get();
        $brand = Brand::get();
        $category = Category::get();
        $supplier = Supplier::get();
        $type = Type::get();
        $unit = Unit::get();
        $warranty = Warranty::get();
        return view('pages.backend.transaction.purchase.createItem', compact(
            'branch',
            'category',
            'brand',
            'type',
            'supplier',
            'unit',
            'warranty'
        ));
    }

    public function itemStore(Request $req)
    {
        $id = DB::table('items')->max('id') + 1;
        $image = $req->image;
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = base64_decode($image);
        if ($image != null) {
            $fileSave = 'public/assetsmaster/image/item/IMG_' . $id . '.' . 'png';
            $fileName = 'IMG_' . $id . '.' . 'png';
            Storage::put($fileSave, $image);
        } else {
            $fileName = null;
        }

        Item::create([
            'id' => $id,
            'name' => $req->name,
            'brand_id' => $req->brand,
            'supplier_id' => $req->supplier_id,
            'warranty_id' => $req->warranty_id,
            'buy' => str_replace(",", '', $req->buy),
            'sell' => str_replace(",", '', $req->sell),
            'discount' => str_replace(",", '', $req->discount),
            'condition' => $req->condition,
            'image' => $fileName,
            'description' => $req->description,
            'created_by' => Auth::user()->name,
        ]);

        for ($i = 0; $i < count($req->branch_id); $i++) {
            Stock::create([
                'item_id' => $id,
                'unit_id' => $req->unit_id,
                'branch_id' => $req->branch_id[$i],
                'stock' => '0',
                'min_stock' => '0',
                'description' => $req->description,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        }

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat barang baru'
        );

        return Redirect::route('purchase.create')
        ->with([
            'status' => 'Berhasil membuat barang baru',
            'type' => 'success'
        ]);
    }
}
