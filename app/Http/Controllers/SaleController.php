<?php

namespace App\Http\Controllers;

use App\Models\AccountData;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Journal;
use App\Models\JournalDetail;
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
            $data = Sale::with('SaleDetail', 'SaleDetail.Item')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('sale.edit', $row->id) . '" ><i class="fas fa-pencil-alt"></i> Edit</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Nota Besar</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSmallSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Nota Kecil</a>';
                    // $actionBtn .= '<a onclick="" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('dataDateOperator', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . Carbon::parse($row->date)->locale('id')->isoFormat('LL') . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->created_by . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataCustomer', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->customer_name . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->customer_address . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->customer_phone . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataItem', function ($row) {
                    $htmlAdd = '<table>';
                    foreach ($row->SaleDetail as $key => $value) {
                        // $item = $value->Item()->withTrashed()->get('name');
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<th>x' . $value->qty . '</th>';
                        $htmlAdd .=      '<th>' . $value->item->name . '</th>';
                        $htmlAdd .=      '<th>(' . $value->item->warranty->periode . $value->item->warranty->name . ')</th>';
                        $htmlAdd .=   '</tr>';
                    }
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('finance', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Barang</td>';
                    $htmlAdd .=      '<th>' . number_format($row->item_price, 0, ".", ",") . '</th>';
                    $htmlAdd .=      '<td>S.P Sales</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_profit_sales, 0, ".", ",") . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Diskon</td>';
                    $htmlAdd .=      '<th>' . number_format($row->discount_price, 0, ".", ",") . '</th>';
                    $htmlAdd .=      '<td>S.P Buyer</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_profit_buyer, 0, ".", ",") . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_price, 0, ".", ",") . '</th>';
                    $htmlAdd .=      '<td>S.P Toko</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_profit_store, 0, ".", ",") . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })

                ->rawColumns(['action', 'dataItem', 'dataCustomer', 'finance', 'dataDateOperator'])
                ->make(true);
        }
        return view('pages.backend.transaction.sale.indexSale');
    }

    public function code($type)
    {
        $getEmployee =  Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('sales')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
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
        $code = $this->code('PJT');
        $account  = AccountData::with('AccountMain', 'AccountMainDetail', 'Branch')->get();
        $userBranch = Auth::user()->employee->branch_id;
        $sales = Employee::where('id', '!=', '1')->where('branch_id', '=', $userBranch)->orderBy('name', 'asc')->get();
        $buyer = Employee::where('id', '!=', '1')->where('branch_id', '=', $userBranch)->orderBy('name', 'asc')->get();
        $cash = Cash::get();
        $customer = Customer::where('branch_id', '=', $userBranch)->orderBy('name', 'asc')->get();
        $stock = Stock::where('branch_id', '=', $userBranch)->where('item_id', '!=', 1)->get();

        return view('pages.backend.transaction.sale.createSale', compact('code', 'cash', 'buyer', 'sales', 'stock', 'customer', 'account'));
    }

    public function store(Request $req)
    {
        // return [$req->profitSharingBuyer,$req->profitSharingSales,$req->totalPriceDetail];
        DB::beginTransaction();
        try {
        $id = DB::table('sales')->max('id') + 1;
        $getEmployee =  Employee::where('user_id', Auth::user()->id)->first();
        $code = $this->code('PJT');
        // return($req);
        if ($req->customer_name != null) {
            $customerName = $req->customer_name;
            $customerPhone = $req->customer_phone;
            $customerAddress = $req->customer_address;
        } else {
            $customerName = 'Umum';
            $customerPhone = null;
            $customerAddress = null;
        }

        for ($i = 0; $i < count($req->itemsDetail); $i++) {
            $sharing_profit_store[$i] = (100 - ($req->profitSharingBuyer[$i] + $req->profitSharingSales[$i])) * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
            $sharing_profit_sales[$i] = $req->profitSharingSales[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
            $sharing_profit_buyer[$i] = $req->profitSharingBuyer[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
            $total_profit_store = collect($sharing_profit_store)->sum();
            $total_profit_sales = collect($sharing_profit_sales)->sum();
            $total_profit_buyer = collect($sharing_profit_buyer)->sum();
        }

        Sale::create([
            'id' => $id,
            'code' => $code,
            'user_id' => Auth::user()->id,
            'sales_id' => $req->sales_id,
            'account' => $req->account,
            'branch_id' => $getEmployee->branch_id,
            'customer_id' => $req->customer_id,
            'customer_name' => $customerName,
            'customer_address' => $customerAddress,
            'customer_phone' => $customerPhone,
            'payment_method' => $req->payment_method,
            'date' => date('Y-m-d'),
            'warranty_id' => $req->warranty,
            'discount_type' => $req->typeDiscount,
            'discount_price' => str_replace(",", '', $req->totalDiscountValue),
            'discount_percent' => str_replace(",", '', $req->totalDiscountPercent),
            'item_price' => str_replace(",", '', $req->totalSparePart),
            'total_price' => str_replace(",", '', $req->totalPrice),
            'total_profit_store' => $total_profit_store,
            'total_profit_sales' => $total_profit_sales,
            'total_profit_buyer' => $total_profit_buyer,
            'description' => $req->description,
            'created_at' => date('Y-m-d h:i:s'),
            'created_by' => Auth::user()->name,
        ]);

        $checkStock = [];
        for ($i = 0; $i < count($req->itemsDetail); $i++) {
            $sharing_profit_store[$i] = (100 - ($req->profitSharingBuyer[$i] + $req->profitSharingSales[$i])) * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
            $sharing_profit_sales[$i] = $req->profitSharingSales[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
            $sharing_profit_buyer[$i] = $req->profitSharingBuyer[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;

            SaleDetail::create([
                'sale_id' => $id,
                'item_id' => $req->itemsDetail[$i],
                'sales_id' => $req->sales_id,
                'buyer_id' => $req->buyerDetail[$i],
                'sharing_profit_store' => $sharing_profit_store[$i],
                'sharing_profit_sales' => $sharing_profit_sales[$i],
                'sharing_profit_buyer' => $sharing_profit_buyer[$i],
                'price' => str_replace(",", '', $req->priceDetail[$i]),
                'qty' => $req->qtyDetail[$i],
                'total' => str_replace(",", '', $req->totalPriceDetail[$i]),
                'description' => $req->descriptionDetail[$i],
                'type' => $req->typeDetail[$i],
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            if ($req->typeDetail[$i] != 'Jasa') {
                $checkStock[$i] = Stock::where('item_id', $req->itemsDetail[$i])
                    ->where('branch_id', $getEmployee->branch_id)
                    ->where('id', '!=', 1)
                    ->get();
                if (count($checkStock[$i]) != null) {
                    if ($checkStock[$i][0]->stock < $req->qtyDetail[$i]) {
                        return Response::json([
                            'status' => 'fail',
                            'message' => 'Stock Item Ada yang 0. Harap Cek Kembali'
                        ]);
                    }
                    if ($req->typeDetail[$i] == 'SparePart') {
                        $desc[$i] = 'Pengeluaran Barang Pada Penjualan ' . $code;
                    } else {
                        $desc[$i] = 'Pengeluaran Barang Loss Pada Penjualan ' . $code;
                    }
                    Stock::where('item_id', $req->itemsDetail[$i])
                        ->where('branch_id', $getEmployee->branch_id)->update([
                            'stock'      => $checkStock[$i][0]->stock - $req->qtyDetail[$i],
                        ]);
                    StockMutation::create([
                        'item_id'    => $req->itemsDetail[$i],
                        'unit_id'    => $checkStock[$i][0]->unit_id,
                        'branch_id'  => $checkStock[$i][0]->branch_id,
                        'qty'        => $req->qtyDetail[$i],
                        'code'       => $code,
                        'type'       => 'Out',
                        'created_by' => Auth::user()->name,
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_by' => Auth::user()->name,
                        'updated_at' => date('Y-m-d h:i:s'),
                        'description' => $desc[$i],
                    ]);
                } else {
                    return Response::json([
                        'status' => 'fail',
                        'message' => 'Item Tidak Ditemukan Di STOCK dengan cabang .....'
                    ]);
                }
            }
        }

        // penjurnalan
        $idJournal = DB::table('journals')->max('id') + 1;
        Journal::create([
            'id' => $idJournal,
            'code' => $this->code('DD'),
            'year' => date('Y'),
            'date' => date('Y-m-d'),
            'type' => 'Penjualan',
            'total' => str_replace(",", '', $req->totalPrice),
            'ref' => $code,
            'description' => $req->description,
            'created_at' => date('Y-m-d h:i:s'),
            // 'updated_at'=>date('Y-m-d h:i:s'),
        ]);
        if ($req->type == 'DownPayment') {
        } else {
            $accountService  = AccountData::where('branch_id', $getEmployee->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 5)
                ->where('main_detail_id', 27)
                ->first();
            $accountPembayaran  = AccountData::where('id', $req->account)
                ->first();
            $accountCode = [
                $accountPembayaran->id,
                $accountService->id,
            ];
            $description = [
                $req->description,
                $req->description,
            ];
            $DK = [
                'D',
                'K',
            ];

            for ($i = 0; $i < count($accountCode); $i++) {
                $idDetail = DB::table('journal_details')->max('id') + 1;
                JournalDetail::create([
                    'id' => $idDetail,
                    'journal_id' => $idJournal,
                    'account_id' => $accountCode[$i],
                    'total' => str_replace(",", '', $req->totalPrice),
                    'description' => $description[$i],
                    'debet_kredit' => $DK[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }
        }
        DB::commit();
        return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
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
        $code = $this->code('PJT');
        $userBranch = Auth::user()->employee->branch_id;
        $sales = Employee::where('id', '!=', '1')->where('branch_id', '=', $userBranch)->orderBy('name', 'asc')->get();
        $buyer = Employee::where('id', '!=', '1')->where('branch_id', '=', $userBranch)->orderBy('name', 'asc')->get();
        $cash = Cash::get();
        $customer = Customer::where('branch_id', '=', $userBranch)->orderBy('name', 'asc')->get();
        $stock = Stock::where('branch_id', '=', $userBranch)->where('item_id', '!=', 1)->get();

        $sale = Sale::with(['SaleDetail', 'Customer'])->find($id);
        $item = Item::with('stock')->where('name', '!=', 'Jasa Service')->get();

        return view('pages.backend.transaction.sale.updateSale', compact('sale', 'cash', 'stock', 'buyer', 'customer', 'sales'));
    }

    public function update(Request $req, $id)
    {
        // return $req->all();
        // return $req->itemsDetail;
        // DB::beginTransaction();
        // try{
        // $checkData = Sale::where('id',$id)->first();
        $date = $this->DashboardController->changeMonthIdToEn($req->date);
        $getEmployee =  Employee::where('user_id', Auth::user()->id)->first();

        if ($req->customer_name != null) {
            $customerName = $req->customer_name;
            $customerPhone = $req->customer_phone;
            $customerAddress = $req->customer_address;
        } else {
            $customerName = 'Umum';
            $customerPhone = null;
            $customerAddress = null;
        }
        $sharing_profit_store = [];
        $sharing_profit_sales = [];
        $sharing_profit_buyer = [];
        $sharing_profit_storeOld = [];
        $sharing_profit_salesOld = [];
        $sharing_profit_buyerOld = [];

        if ($req->itemsDetail != null) {
            for ($i = 0; $i < count($req->itemsDetail); $i++) {
                $sharing_profit_store[$i] = (100 - ($req->profitSharingBuyer[$i] + $req->profitSharingSales[$i])) * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
                $sharing_profit_sales[$i] = $req->profitSharingSales[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
                $sharing_profit_buyer[$i] = $req->profitSharingBuyer[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * (str_replace(",", '', $req->profitDetail[$i])))) / 100;
            }
        }
        if ($req->itemsDetailOld != null) {
            for ($i = 0; $i < count($req->itemsDetailOld); $i++) {
                $sharing_profit_storeOld[$i] = (100 - ($req->profitSharingBuyerOld[$i] + $req->profitSharingSalesOld[$i])) * ((str_replace(",", '', $req->totalPriceDetailOld[$i])) - ($req->qtyDetailOld[$i] * (str_replace(",", '', $req->profitDetailOld[$i])))) / 100;

                $sharing_profit_salesOld[$i] = $req->profitSharingSalesOld[$i] * ((str_replace(",", '', $req->totalPriceDetailOld[$i])) - ($req->qtyDetailOld[$i] * (str_replace(",", '', $req->profitDetailOld[$i])))) / 100;
                $sharing_profit_buyerOld[$i] = $req->profitSharingBuyerOld[$i] * ((str_replace(",", '', $req->totalPriceDetailOld[$i])) - ($req->qtyDetailOld[$i] * (str_replace(",", '', $req->profitDetailOld[$i])))) / 100;
            }
        }

        $total_profit_store = collect($sharing_profit_store)->sum() + collect($sharing_profit_storeOld)->sum();
        $total_profit_sales = collect($sharing_profit_sales)->sum() + collect($sharing_profit_salesOld)->sum();
        $total_profit_buyer = collect($sharing_profit_buyer)->sum() + collect($sharing_profit_buyerOld)->sum();
        // return [$total_profit_store,collect($sharing_profit_store)->sum(),collect($sharing_profit_storeOld)->sum()];
        Sale::where('id', $id)->update([
            'user_id' => Auth::user()->id,
            'sales_id' => $req->sales_id,
            'branch_id' => $getEmployee->branch_id,
            'customer_id' => $req->customer_id,
            'customer_name' => $customerName,
            'customer_address' => $customerAddress,
            'customer_phone' => $customerPhone,
            'date' => $date,
            'discount_type' => $req->typeDiscount,
            'discount_price' => str_replace(",", '', $req->totalDiscountValue),
            'discount_percent' => str_replace(",", '', $req->totalDiscountPercent),
            'item_price' => str_replace(",", '', $req->totalSparePart),
            'total_price' => str_replace(",", '', $req->totalPrice),
            'total_profit_store' => $total_profit_store,
            'total_profit_sales' => $total_profit_sales,
            'total_profit_buyer' => $total_profit_buyer,
            'description' => $req->description,
            'updated_at' => date('Y-m-d h:i:s'),
            'updated_by' => Auth::user()->name,
        ]);

        // check data yang dihapus dan mengembalikan stock terlebih dahulu
        if ($req->deletedExistingData != null) {
            $checkDataDeleted = SaleDetail::whereIn('id', $req->deletedExistingData)->get();
            $checkStockDeleted = [];
            for ($i = 0; $i < count($checkDataDeleted); $i++) {
                $checkStockDeleted[$i] = Stock::where('item_id', $checkDataDeleted[$i]->item_id)
                    ->where('branch_id', $getEmployee->branch_id)
                    ->where('id', '!=', 1)
                    ->get();

                if ($checkDataDeleted[$i]->type == 'SparePart') {
                    $desc[$i] = '(Update Penjualan) Pengembalian Barang Pada Penjualan ' . $req->code;
                } else {
                    $desc[$i] = '(Update Penjualan) Pengembalian Barang Pada Penjualan ' . $req->code;
                    // $desc[$i] = '(Update Penjualan) Pengembalian Barang Loss Pada Penjualan '.$req->code;
                }
                // return $desc;
                Stock::where('item_id', $checkDataDeleted[$i]->item_id)
                    ->where('branch_id', $getEmployee->branch_id)->update([
                        'stock'      => $checkStockDeleted[$i][0]->stock + $checkDataDeleted[$i]->qty,
                    ]);
                StockMutation::create([
                    'item_id'    => $checkDataDeleted[$i]->item_id,
                    'unit_id'    => $checkStockDeleted[$i][0]->unit_id,
                    'branch_id'  => $checkStockDeleted[$i][0]->branch_id,
                    'qty'        => $checkDataDeleted[$i]->qty,
                    'code'       => $req->code,
                    'type'       => 'In',
                    'description' => $desc[$i],
                    'created_by' => Auth::user()->name,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_by' => Auth::user()->name,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }
            // return $req->deletedExistingData;
            $destroyExistingData = DB::table('sale_details')->whereIn('id', $req->deletedExistingData)->delete();
        }

        // menyimpan data baru dan memperbarui stock
        if ($req->itemsDetail != null) {
            $checkStock = [];
            for ($i = 0; $i < count($req->itemsDetail); $i++) {
                $sharing_profit_store[$i] = (100 - ($req->profitSharingBuyer[$i] + $req->profitSharingSales[$i])) * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * $req->profitDetail[$i])) / 100;
                $sharing_profit_sales[$i] = $req->profitSharingSales[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * $req->profitDetail[$i])) / 100;
                $sharing_profit_buyer[$i] = $req->profitSharingBuyer[$i] * ((str_replace(",", '', $req->totalPriceDetail[$i])) - ($req->qtyDetail[$i] * $req->profitDetail[$i])) / 100;

                SaleDetail::create([
                    'sale_id' => $id,
                    'item_id' => $req->itemsDetail[$i],
                    'sales_id' => $req->sales_id,
                    'buyer_id' => $req->buyerDetail[$i],
                    'sharing_profit_store' => $sharing_profit_store[$i],
                    'sharing_profit_sales' => $sharing_profit_sales[$i],
                    'sharing_profit_buyer' => $sharing_profit_buyer[$i],
                    'price' => str_replace(",", '', $req->priceDetail[$i]),
                    'qty' => $req->qtyDetail[$i],
                    'total' => str_replace(",", '', $req->totalPriceDetail[$i]),
                    'description' => str_replace(",", '', $req->descriptionDetail[$i]),
                    // 'type' =>$req->typeDetail[$i],
                    'created_by' => Auth::user()->name,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_by' => Auth::user()->name,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
                if ($req->typeDetail[$i] != 'Jasa') {
                    $checkStock[$i] = Stock::where('item_id', $req->itemsDetail[$i])
                        ->where('branch_id', $getEmployee->branch_id)
                        ->where('id', '!=', 1)
                        ->get();
                    if ($checkStock[$i][0]->stock < $req->qtyDetail[$i]) {
                        return Response::json([
                            'status' => 'fail',
                            'message' => 'Stock Item Ada yang 0. Harap Cek Kembali'
                        ]);
                    }
                    if ($req->typeDetail[$i] == 'SparePart') {
                        $desc[$i] = '(Update Penjualan) Pengeluaran Barang Pada Penjualan ' . $req->code;
                    } else {
                        $desc[$i] = '(Update Penjualan) Pengeluaran Barang Loss Pada Penjualan ' . $req->code;
                    }
                    Stock::where('item_id', $req->itemsDetail[$i])
                        ->where('branch_id', $getEmployee->branch_id)->update([
                            'stock'      => $checkStock[$i][0]->stock - $req->qtyDetail[$i],
                        ]);
                    StockMutation::create([
                        'item_id'    => $req->itemsDetail[$i],
                        'unit_id'    => $checkStock[$i][0]->unit_id,
                        'branch_id'  => $checkStock[$i][0]->branch_id,
                        'qty'        => $req->qtyDetail[$i],
                        'code'       => $this->code('PJT'),
                        'type'       => 'Out',
                        'description' => $desc[$i],
                        'created_by' => Auth::user()->name,
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_by' => Auth::user()->name,
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
                }
            }
        }

        if ($req->itemsDetailOld != null) {
            // return 'asd';
            // return $req->all();
            // mengecek data existing
            $checkDataOld = SaleDetail::whereIn('id', $req->idDetailOld)->get();
            $checkStockExisting = [];

            for ($i = 0; $i < count($checkDataOld); $i++) {
                // memfilter type kecuali jasa
                if ($checkDataOld[$i]->item_id != 1) {
                    // return$checkDataOld[$i];
                    if ($req->typeDetailOld[$i] != 'Jasa') {
                        $checkStockExisting[$i] = Stock::where('item_id', $req->itemsDetailOld[$i])
                            ->where('branch_id', $getEmployee->branch_id)
                            ->where('id', '!=', 1)
                            ->get();

                        $checkStockExistingOlder[$i] = Stock::where('item_id', $checkDataOld[$i]->item_id)
                            ->where('branch_id', $getEmployee->branch_id)
                            ->where('id', '!=', 1)
                            ->get();
                        // if($checkStockExisting[$i][0]->stock < ($req->qtyDetailOld[$i])){
                        //     return Response::json(['status' => 'fail',
                        //                     'message'=>'Stock Item Ada yang 0. Harap Cek Kembali']);
                        // }
                        // return 'masuk 1';
                        // mengecek kembali jika data item sama dengan data yang ada di service_detail
                        if ($checkDataOld[$i]->item_id == $req->itemsDetailOld[$i]) {
                            // return 'masuk 2.1';
                            // mengecek kembali jika data QTY sama dengan data yang ada di service_detail
                            if ($checkDataOld[$i]->qty == $req->qtyDetailOld[$i]) {
                                // return 'masuk 3.1';
                                // jika qty di service_detail sama dengan QTY yang akan di update
                                if ($checkDataOld[$i]->type == $req->typeDetailOld[$i]) {
                                    // return 'masuk 4.1';
                                    // Jika Type sama maka tidak perlu melakukan update stock mutasi
                                } else {
                                    // Jika Type berbeda maka perlu melakukan update stock mutasi dengan type yaitu MUTATION
                                    // return 'masuk 4.2';
                                    $desc[$i] = '(Update Penjualan) Perubahan Barang Pada Penjualan ' . $req->code;

                                    StockMutation::create([
                                        'item_id'    => $req->itemsDetailOld[$i],
                                        'unit_id'    => $checkStockExisting[$i][0]->unit_id,
                                        'branch_id'  => $checkStockExisting[$i][0]->branch_id,
                                        'qty'        => $req->qtyDetailOld[$i],
                                        'code'       => $req->code,
                                        'type'       => 'Mutation',
                                        'description' => $desc[$i],
                                        'created_by' => Auth::user()->name,
                                        'created_at' => date('Y-m-d h:i:s'),
                                        'updated_by' => Auth::user()->name,
                                        'updated_at' => date('Y-m-d h:i:s'),
                                    ]);
                                }
                                // mengupdate service detail jika item sama + qty sama + perubahan tipe sparepart / loss
                                SaleDetail::where('id', $req->idDetailOld[$i])->update([
                                    // 'service_id'=>$id,
                                    // 'item_id'=>$req->itemsDetailOld[$i],
                                    'price' => str_replace(",", '', $req->priceDetailOld[$i]),
                                    // 'qty'=>$req->qtyDetailOld[$i],
                                    'total' => str_replace(",", '', $req->totalPriceDetailOld[$i]),
                                    'description' => str_replace(",", '', $req->descriptionDetailOld[$i]),
                                    // 'type' =>$req->typeDetailOld[$i],
                                    'updated_by' => Auth::user()->name,
                                    'updated_at' => date('Y-m-d h:i:s'),
                                ]);
                            } else {
                                // return 'masuk 3.2';
                                // jika qty di service_detail berbeda dengan QTY yang akan di update
                                // return $checkDataOld;
                                if ($req->typeDetailOld[$i] == 'SparePart') {
                                    $descPengembalian[$i] = '(Update Penjualan) Pengembalian Barang Pada Penjualan ' . $req->code;
                                } else {
                                    $descPengembalian[$i] = '(Update Penjualan) Pengembalian Barang Loss Pada Penjualan ' . $req->code;
                                }
                                StockMutation::create([
                                    'item_id'    => $req->itemsDetailOld[$i],
                                    'unit_id'    => $checkStockExisting[$i][0]->unit_id,
                                    'branch_id'  => $checkStockExisting[$i][0]->branch_id,
                                    'qty'        => $checkDataOld[$i]->qty,
                                    'code'       => $req->code,
                                    'type'       => 'In',
                                    'description' => $descPengembalian[$i],
                                    'created_by' => Auth::user()->name,
                                    'created_at' => date('Y-m-d h:i:s'),
                                    'updated_by' => Auth::user()->name,
                                    'updated_at' => date('Y-m-d h:i:s'),
                                ]);

                                // Pegeluaran atas data item yang dirubah
                                if ($req->typeDetailOld[$i] == 'SparePart') {
                                    $descPengeluaran[$i] = '(Update Penjualan) Pengeluaran Barang Pada Penjualan ' . $req->code;
                                } else {
                                    $descPengeluaran[$i] = '(Update Penjualan) Pengeluaran Barang Loss Pada Penjualan ' . $req->code;
                                }
                                StockMutation::create([
                                    'item_id'    => $req->itemsDetailOld[$i],
                                    'unit_id'    => $checkStockExisting[$i][0]->unit_id,
                                    'branch_id'  => $checkStockExisting[$i][0]->branch_id,
                                    'qty'        => $req->qtyDetailOld[$i],
                                    'code'       => $req->code,
                                    'type'       => 'Out',
                                    'description' => $descPengeluaran[$i],
                                    'created_by' => Auth::user()->name,
                                    'created_at' => date('Y-m-d h:i:s'),
                                    'updated_by' => Auth::user()->name,
                                    'updated_at' => date('Y-m-d h:i:s'),
                                ]);

                                Stock::where('item_id', $checkDataOld[$i]->item_id)
                                    ->where('branch_id', $getEmployee->branch_id)->update([
                                        'stock'      => $checkStockExisting[$i][0]->stock + $checkDataOld[$i]->qty - $req->qtyDetailOld[$i],
                                    ]);

                                SaleDetail::where('id', $req->idDetailOld[$i])->update([
                                    // 'service_id'=>$id,
                                    // 'item_id'=>$req->itemsDetailOld[$i],
                                    'price' => str_replace(",", '', $req->priceDetailOld[$i]),
                                    'qty' => $req->qtyDetailOld[$i],
                                    'total' => str_replace(",", '', $req->totalPriceDetailOld[$i]),
                                    'description' => str_replace(",", '', $req->descriptionDetailOld[$i]),
                                    // 'type' =>$req->typeDetailOld[$i],
                                    'updated_by' => Auth::user()->name,
                                    'updated_at' => date('Y-m-d h:i:s'),
                                ]);
                            }
                        } else {
                            // return 'masuk 2.2';
                            // pengembalian stock atas item service_detail yang dirubah

                            if ($checkStockExistingOlder[$i][0]->item_id == $checkDataOld[$i]->item_id) {
                                Stock::where('item_id', $checkDataOld[$i]->item_id)
                                    ->where('branch_id', $getEmployee->branch_id)->update([
                                        'stock'      => $checkStockExistingOlder[$i][0]->stock + $checkDataOld[$i]->qty,
                                    ]);
                            }

                            if ($checkDataOld[$i]->type == 'SparePart') {
                                $descPengembalian[$i] = '(Update Penjualan) Pengembalian Barang Pada Penjualan ' . $req->code;
                            } else {
                                $descPengembalian[$i] = '(Update Penjualan) Pengembalian Barang Loss Pada Penjualan ' . $req->code;
                            }
                            StockMutation::create([
                                'item_id'    => $checkDataOld[$i]->item_id,
                                'unit_id'    => $checkStockExisting[$i][0]->unit_id,
                                'branch_id'  => $checkStockExisting[$i][0]->branch_id,
                                'qty'        => $checkDataOld[$i]->qty,
                                'code'       => $req->code,
                                'type'       => 'In',
                                'description' => $descPengembalian[$i],
                                'created_by' => Auth::user()->name,
                                'created_at' => date('Y-m-d h:i:s'),
                                'updated_by' => Auth::user()->name,
                                'updated_at' => date('Y-m-d h:i:s'),
                            ]);

                            // Pegeluaran atas data item yang dirubah
                            if ($req->typeDetailOld[$i] == 'SparePart') {
                                $descPengeluaran[$i] = '(Update Penjualan) Pengeluaran Barang Pada Penjualan ' . $req->code;
                            } else {
                                $descPengeluaran[$i] = '(Update Penjualan) Pengeluaran Barang Loss Pada Penjualan ' . $req->code;
                            }
                            Stock::where('item_id', $req->itemsDetailOld[$i])
                                ->where('branch_id', $getEmployee->branch_id)->update([
                                    'stock'      => $checkStockExisting[$i][0]->stock - $req->qtyDetailOld[$i],
                                ]);
                            StockMutation::create([
                                'item_id'    => $req->itemsDetailOld[$i],
                                'unit_id'    => $checkStockExisting[$i][0]->unit_id,
                                'branch_id'  => $checkStockExisting[$i][0]->branch_id,
                                'qty'        => $req->qtyDetailOld[$i],
                                'code'       => $req->code,
                                'type'       => 'Out',
                                'description' => $descPengeluaran[$i],
                                'created_by' => Auth::user()->name,
                                'created_at' => date('Y-m-d h:i:s'),
                                'updated_by' => Auth::user()->name,
                                'updated_at' => date('Y-m-d h:i:s'),
                            ]);

                            SaleDetail::where('id', $req->idDetailOld[$i])->update([
                                // 'service_id'=>$id,
                                'item_id' => $req->itemsDetailOld[$i],
                                'sales_id' => $req->sales_id,
                                'buyer_id' => $req->buyerDetailOld[$i],
                                'sharing_profit_store' => $sharing_profit_storeOld[$i],
                                'sharing_profit_sales' => $sharing_profit_salesOld[$i],
                                'sharing_profit_buyer' => $sharing_profit_buyerOld[$i],
                                'price' => str_replace(",", '', $req->priceDetailOld[$i]),
                                'qty' => $req->qtyDetailOld[$i],
                                'total' => str_replace(",", '', $req->totalPriceDetailOld[$i]),
                                'description' => str_replace(",", '', $req->descriptionDetailOld[$i]),
                                // 'type' =>$req->typeDetailOld[$i],
                                'updated_by' => Auth::user()->name,
                                'updated_at' => date('Y-m-d h:i:s'),
                            ]);
                        }
                    }
                }
            }
        }

        // DB::commit();
        return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
        // } catch (\Throwable $th) {
        //throw $th;
        // DB::rollback();
        // return $th;
        // return Response::json(['status' => 'error','message'=> 'keliru']);
        // }
    }

    public function destroy(Request $req, $id)
    {
        // $tran = SaleDetail::where('item_id', $id);
        // if(count($tran) != null)
        // {
        //     return Response::json(['status' => 'error','message'=>'Data tidak dapat dihapus']);
        // }
        // else {
        //     $this->DashboardController->createLog(
        //         $req->header('user-agent'),
        //         $req->ip(),
        //         'Menghapus Data Kredit'
        //     );
        //     Sale::where('id',$id)->destroy($id);
        //     return Response::json(['status' => 'success']);
        // }

    }

    public function printSale($id)
    {
        $sale = Sale::with('SaleDetail', 'Sales', 'SaleDetail.Item', 'SaleDetail.Item.Warranty', 'SaleDetail.Item.Brand', 'SaleDetail.Item.Brand.Category', 'CreatedByUser')->find($id);
        // return $Service;
        $member = User::get();
        return view('pages.backend.transaction.sale.printSales', ['sale' => $sale, 'member' => $member]);
    }

    public function printSmallSale($id)
    {
        $sale = Sale::with('SaleDetail', 'Sales', 'SaleDetail.Item', 'SaleDetail.Item.Brand', 'SaleDetail.Item.Brand.Category', 'CreatedByUser')->find($id);
        // return $Service;
        $member = User::get();
        return view('pages.backend.transaction.sale.printSmallSale', ['sale' => $sale, 'member' => $member]);
    }
}
