<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Type;
use App\Models\Category;
use App\Models\Stock;
use App\Models\StockMutation;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\AccountData;
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
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(36, 'view');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = StockTransaction::with('item', 'item.stock', 'item.stock.unit', 'item.stock.branch','BranchOrigin','BranchDestination')
                ->orderBy('id', 'DESC')
                ->get();

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
                    $actionBtn .= '<a class="dropdown-item" href="' . route('stockTransaction.show',$row->id) . '"><i class="fas fa-eye"></i> Lihat</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                    $actionBtn .= '<a onclick="jurnal(' . "'" . $row->code . "'" . ')" class="dropdown-item" style="cursor:pointer;"><i class="fas fa-file-alt"></i> Jurnal</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })

                ->addColumn('typeInOut', function ($row) {
                    if ($row->type == 'In') {
                        return '<div class="badge badge-success">In</div>';
                    } elseif ($row->type == 'Out') {
                        return '<div class="badge badge-danger">Out</div>';
                    }elseif ($row->type == 'Mutation') {
                        return '<div class="badge badge-warning">Mutation</div>';
                    }
                })
                ->addColumn('branchCheck', function ($row) {
                    if ($row->type == 'Mutation') {
                        return $row->BranchOrigin->name .' ke '.$row->BranchDestination->name;
                    }else{
                        return $row->BranchOrigin->name;
                    }
                })

                ->rawColumns(['action', 'typeInOut'])
                ->make(true);
        }
        return view('pages.backend.warehouse.stockTransaction.indexStockTransaction');
    }

    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('stocks_transaction')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $year . $month . $index;
    }
    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(36, 'create');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }

        // $code   = $this->code('-');
        // $items  = Item::where('name','!=','Jasa Service')->get();
        $item = Item::with('stock', 'supplier')
            ->where('name', '!=', 'Jasa Service')
            ->get();
        $brand = Brand::get();
        $branch = Branch::get();
        $type = Type::get();
        $category = Category::get();
        return view('pages.backend.warehouse.stockTransaction.createStockTransaction', compact('item', 'brand', 'type', 'category', 'branch'));
    }
    public function codeJournals($type, $id)
    {
        $getEmployee = Employee::with('branch')
            ->where('user_id', Auth::user()->id)
            ->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = str_pad($id, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            
            $dateConvert = $this->DashboardController->changeMonthIdToEn($req->date);
            $id = DB::table('stocks_transaction')->max('id') + 1;

            $getEmployee = Employee::where('user_id', Auth::user()->id)->first();
            $checkStock = Stock::with('Item')->where('item_id', $req->item)
                ->where('branch_id', $getEmployee->branch_id)
                ->first();

            $branchA = Branch::where('id', $getEmployee->branch_id)->first();
            $branchB = Branch::where('id', $req->destination)->first();
            
            if ($checkStock == null) {
                return Response::json(['status' => 'fail', 'message' => 'Stock Tidak Ditemukan.']);
            }

            if ($req->type == 'Mutation') {
                $reason = 'Mutasi';
            }else{
                $reason = $req->reason;
            }

            if ($req->type == 'In') {
                $code = $this->code('SIN-');
                $stockQty = $checkStock->stock + $req->qty;
                $desc = "Pemasukan Barang Atas '" . $reason . "' di transaksi " . $code;
            } else if($req->type == 'Out'){
                $code = $this->code('SOT-');
                $stockQty = $checkStock->stock - $req->qty;
                $desc = "Pengeluaran Barang Atas '" . $reason . "' di transaksi " . $code;
                if ($checkStock->stock < $req->qty) {
                    return Response::json(['status' => 'fail', 'message' => 'Stock Item Kurang Dari yang akan dikeluarkan.']);
                }
            }else if($req->type == 'Mutation'){
                // mengecek jika tujuan dan asal sama
                if ($getEmployee->branch_id == $req->destination || $req->destination == '') {
                    return Response::json(['status' => 'fail', 'message' => 'Data Asal Stock Dan Tujuan Sama / Kosong.']);
                }

                // data asal stock
                $code = $this->code('SMT-');
                $stockQty = $checkStock->stock - $req->qty;
                $desc = "Mutasi Barang dari " . $branchA->name . " ke " . $branchB->name.' di transaksi '. $code;
                if ($checkStock->stock < $req->qty) {
                    return Response::json(['status' => 'fail', 'message' => 'Stock Item Kurang Dari yang akan dikeluarkan.']);
                }
                
                // mengecek jika item tidak ditemukan pada stock
                $checkStockItem = Stock::where('item_id', $req->item)->where('branch_id', $req->destination)->count();
                if ($checkStockItem == 0) {
                    return Response::json(['status' => 'fail', 'message' => 'Data Item Pada Cabang Tujuan Tidak Ditemukan']);
                }

                // mengecek stock tujuan
                $checkStock1 = Stock::with('Item')->where('item_id', $req->item)
                    ->where('branch_id', $req->destination)
                    ->first();
                $stockQty1 = $checkStock1->stock + $req->qty;

                Stock::where('item_id', $req->item)
                    ->where('branch_id', $getEmployee->branch_id)
                    ->update([
                        'stock' => $stockQty,
                    ]);

                StockMutation::create([
                    'item_id' => $req->item,
                    'unit_id' => $checkStock->unit_id,
                    'branch_id' => $getEmployee->branch_id,
                    'qty' => $req->qty,
                    'code' => $code,
                    'type' => $req->type,
                    'description' => $desc,
                ]);
                
                Stock::where('item_id', $req->item)
                    ->where('branch_id', $req->destination)
                    ->update([
                        'stock' => $stockQty1,
                    ]);

                StockMutation::create([
                    'item_id' => $req->item,
                    'unit_id' => $checkStock->unit_id,
                    'branch_id' => $req->destination,
                    'qty' => $req->qty,
                    'code' => $code,
                    'type' => $req->type,
                    'description' => $desc,
                ]);
            }
          

            StockTransaction::create([
                'id' => $id,
                'code' => $code,
                'item_id' => $req->item,
                'unit_id' => $checkStock->unit_id,
                'branch_id' => $checkStock->branch_id,
                'branch_destination_id' => $req->destination,
                'qty' => $req->qty,
                'type' => $req->type,
                'reason' => $reason,
                'total' => str_replace(',', '', $req->total),
                'date' => $dateConvert,
                'description' => $req->description,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            
            if($req->type != 'Mutation'){
                Stock::where('item_id', $req->item)
                    ->where('branch_id', $getEmployee->branch_id)
                    ->update([
                        'stock' => $stockQty,
                    ]);

                StockMutation::create([
                    'item_id' => $req->item,
                    'unit_id' => $checkStock->unit_id,
                    'branch_id' => $checkStock->branch_id,
                    'qty' => $req->qty,
                    'code' => $code,
                    'type' => $req->type,
                    'description' => $desc,
                ]);
            }

            $idJournal = DB::table('journals')->max('id') + 1;
            Journal::create([
                'id' => $idJournal,
                'code' => $this->codeJournals('KK', $idJournal),
                'year' => date('Y'),
                'date' => date('Y-m-d'),
                'type' => 'Biaya',
                'total' => str_replace(',', '', $req->total),
                'ref' => $code,
                'description' => $desc,
                'created_at' => date('Y-m-d h:i:s'),
            ]);

            // $cariCabang = AccountData::where('id', $req->accountData)->first();
            $accountKas = AccountData::where('branch_id', $getEmployee->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 1)
                ->where('main_detail_id', 3)
                ->first();

            $accountPersediaan = AccountData::where('branch_id', $getEmployee->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 3)
                ->where('main_detail_id', 11)
                ->first();

            $accountBiayaHilang = AccountData::where('branch_id', $getEmployee->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 6)
                ->where('main_detail_id', 48)
                ->first();

            $accountBiayaRusak = AccountData::where('branch_id', $getEmployee->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 6)
                ->where('main_detail_id', 47)
                ->first();
            
            $accountBiayaBarangSekaliPakai = AccountData::where('branch_id', $getEmployee->branch_id)
                ->where('active', 'Y')
                ->where('main_id', 6)
                ->where('main_detail_id', 59)
                ->first();

            $accountDestination = AccountData::where('branch_id', $req->destination)
                ->where('active', 'Y')
                ->where('main_id', 3)
                ->where('main_detail_id', 11)
                ->first();

            
            
            if ($req->type == 'Mutation') {
                $text = "Mutasi Barang dari " . $branchA->name . " ke " . $branchB->name;
                $acc1 = $accountDestination->id;
                $acc2 = $accountPersediaan->id;
            }elseif ($req->type == 'In') {
                $text = 'Pengeluaran Barang Atas '. $reason . ' di transaksi ';
                $acc1 = $accountPersediaan->id;
                $acc2 = $accountKas->id;
            }elseif ($req->type == 'Out') {
                $text = 'Pengeluaran Barang Atas ' . $req->reason . ' di transaksi ';
                if ($req->reason == 'Salah Input') {
                    $acc1 = $accountKas->id;
                    $acc2 = $accountPersediaan->id;
                }elseif($req->reason == 'Hilang'){
                    $acc1 = $accountBiayaHilang->id;
                    $acc2 = $accountPersediaan->id;
                }elseif($req->reason == 'Rusak'){
                    $acc1 = $accountBiayaRusak->id;
                    $acc2 = $accountPersediaan->id;
                }elseif($req->reason == 'Barang Sekali Pakai'){
                    $acc1 = $accountBiayaBarangSekaliPakai->id;
                    $acc2 = $accountPersediaan->id;
                }
            }

            $accountCode = [$acc1,$acc2];
            $totalBayar = [str_replace(',', '', $req->total),str_replace(',', '', $req->total)];
            $description = [$text,$text];
            $DK = ['D','K'];

            for ($i = 0; $i < count($accountCode); $i++) {
                $idDetail = DB::table('journal_details')->max('id') + 1;
                JournalDetail::create([
                    'id' => $idDetail,
                    'journal_id' => $idJournal,
                    'account_id' => $accountCode[$i],
                    'total' => $totalBayar[$i],
                    'description' => $description[$i],
                    'debet_kredit' => $DK[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }

            DB::commit();
            return Response::json(['status' => 'success', 'message' => 'Data Terhapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            // return$th;
            return Response::json(['status' => 'error', 'message' => $th->getMessage()]);
        }
        // return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
    }
    public function show($id)
    {
        # code...
        $data = StockTransaction::where('id',$id)->first();
        $item = Item::with('stock', 'supplier','brand')
            ->where('name', '!=', 'Jasa Service')
            ->get();
        $brand = Brand::get();
        $branch = Branch::get();
        $type = Type::get();
        $category = Category::get();
        return view('pages.backend.warehouse.stockTransaction.showStockTransaction', compact('item', 'brand', 'type', 'category', 'branch','data'));
    }
    public function checkJournals(Request $req)
    {
        $data = Journal::with('JournalDetail.AccountData')
            ->where('ref', $req->id)
            ->get();
        return Response::json(['status' => 'success', 'jurnal' => $data]);
    }
    public function destroy(Request $req, $id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(36, 'delete');
        if ($checkRoles == 'akses ditolak') {
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }
        $this->DashboardController->createLog($req->header('user-agent'), $req->ip(), 'Menghapus Data Transaksi Stock');
        DB::beginTransaction();
        try {
            $data = StockTransaction::where('id',$id)->first();

            $checkStock = Stock::with('Item')->where('item_id', $data->item_id)
                ->where('branch_id', $data->branch_id)
                ->first();

            $branchA = Branch::where('id', $data->branch_id)->first();
            $branchB = Branch::where('id', $data->branch_destination_id)->first();
            
            if ($data->type == 'Mutation') {
                $reason = 'Mutasi';
            }else{
                $reason = $data->reason;
            }

            if ($data->type == 'In') {
                $stockQty = $checkStock->stock - $data->qty;
                $desc = "Pengembalian barang dari Pemasukan Barang Atas '" . $reason . "' di transaksi " . $data->code;
                if ($stockQty < 0) {
                    return Response::json(['status' => 'error', 'message' => 'Data Stock Jika Dihapus Maka Minus']);
                }
            } else if($data->type == 'Out'){
                $stockQty = $checkStock->stock + $data->qty;
                $desc = "Pengembalian barang dari Pengeluaran Barang Atas '" . $reason . "' di transaksi " . $data->code;
            }else if($data->type == 'Mutation'){
                $stockQty1 = $checkStock->stock + $data->qty;

                
                $desc = "Pengembalian barang dari Mutasi Barang dari " . $branchA->name . " ke " . $branchB->name.' di transaksi '. $data->code;

                $checkStock2 = Stock::with('Item')->where('item_id', $data->item_id)
                ->where('branch_id', $data->branch_destination_id)
                ->first();
                $stockQty2 = $checkStock2->stock - $data->qty;

                Stock::where('item_id', $data->item_id)
                    ->where('branch_id', $data->branch_id)
                    ->update([
                        'stock' => $stockQty1,
                    ]);

                Stock::where('item_id', $data->item_id)
                    ->where('branch_id', $data->branch_destination_id)
                    ->update([
                        'stock' => $stockQty2,
                    ]);

                StockMutation::create([
                    'item_id' => $data->item_id,
                    'unit_id' => $data->unit_id,
                    'branch_id' => $data->branch_id,
                    'qty' => $data->qty,
                    'code' => $data->code,
                    'type' => $data->type,
                    'description' => $desc,
                ]);

                StockMutation::create([
                    'item_id' => $data->item_id,
                    'unit_id' => $data->unit_id,
                    'branch_id' => $data->branch_destination_id,
                    'qty' => $data->qty,
                    'code' => $data->code,
                    'type' => $data->type,
                    'description' => $desc,
                ]);
            }

            if ($data->type != 'Mutation') {
                Stock::where('item_id', $data->item_id)
                    ->where('branch_id', $data->branch_id)
                    ->update([
                        'stock' => $stockQty,
                    ]);

                StockMutation::create([
                    'item_id' => $data->item_id,
                    'unit_id' => $data->unit_id,
                    'branch_id' => $data->branch_id,
                    'qty' => $data->qty,
                    'code' => $data->code,
                    'type' => $data->type,
                    'description' => $desc,
                ]);
            }

            $checkJournals = DB::table('journals')
                ->where('ref', $data->code)
                ->get();

            DB::table('journal_details')
                    ->where('journal_id', $checkJournals[0]->id)
                    ->delete();
            DB::table('journals')
                    ->where('id', $checkJournals[0]->id)
                    ->delete();
            // 
            DB::table('stocks_transaction')
                    ->where('id', $id)
                    ->delete();
         
            // StockTransaction::destroy($id);
            // StockTransaction::destroy($id);
            DB::commit();
            return Response::json(['status' => 'success', 'message' => 'Data Terhapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            // return$th;
            return Response::json(['status' => 'error', 'message' => $th->getMessage()]);
        }
        return Response::json(['status' => 'success']);
    }
    public function checkStock(Request $req)
    {
        $branchUser = Auth::user()->employee->branch_id;
        $data = Stock::with('item', 'unit', 'branch')
            ->where('branch_id', $branchUser)
            ->where('item_id', $req->id)
            ->first();
        return Response::json(['status' => 'success', 'data' => $data, 'message' => 'Data Terload']);
    }
}
