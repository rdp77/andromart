<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\PurchasingDetail;
use App\Models\HistoryPurchase;
use App\Models\HistoryDetailPurchase;
use App\Models\Employee;
use App\Models\Stock;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\AccountData;
use App\Models\Cash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ReceptionController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            // ORDER BY FIND_IN_SET(column, 'Yellow,Blue,Red')
            $data = Purchasing::with('employee')->whereIn("done", [1,3,0,2])->get();
            foreach($data as $row) {
                $tanggal = date("d F Y", strtotime($row->date));
                $row->date = $tanggal;
                if($row->done == 2) {
                    $row->done = "Telah Selesai";
                } else if ($row->done == 1) {
                    $row->done = "Masih Proses";
                }  else if ($row->done == 3) {
                    $row->done = "Belum Diproses";
                } else {
                    $row->done = "Belum Diverifikasi";
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
                    if($row->done == "Belum Diverifikasi") {
                        $actionBtn .= '<div class="dropdown-menu">';
                    } else {
                        $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('reception.edit', Crypt::encryptString($row->id)) . '">Ubah</a>';
                        $actionBtn .= '<a onclick="jurnal(' ."'". $row->code ."'". ')" class="dropdown-item" style="cursor:pointer;"><i class="fas fa-file-alt"></i> Jurnal</a>';
                    }
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.transaction.reception.indexReception');
    }

    public function create()
    {
        return view('pages.backend.office.notes.createNotes');
    }

    public function store(Request $req)
    {
    }

    public function show(Notes $notes, $id)
    {
        $id = Crypt::decryptString($id);
        $models = Notes::where('id', $id)->first();
        // $models = Notes::where('notes.id', $id)
        // ->join('users', 'notes.users_id', '=', 'users.id')
        // ->select('notes.id as notes_id', 'notes.date as date', 'users.name as name', 'users.id as users_id', 'notes.title as title', 'notes.description as description')
        // ->first();
        $modelsFile = NotesPhoto::where('notes_id', $id)->get();
        // dd($modelsFile);
        return view('pages.backend.office.notes.showNotes', compact('models', 'modelsFile'));
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $model = Purchasing::where('purchasings.id', $id)
        ->leftjoin('employees', 'purchasings.employee_id', 'employees.id')
        ->first();
        $models = Purchasing::where('purchasings.id', $id)
        ->join('purchasing_details', 'purchasings.id', 'purchasing_details.purchasing_id')
        ->join('items', 'purchasing_details.item_id', 'items.id')
        ->join('stocks', 'items.id', 'stocks.item_id')
        ->join('units', 'stocks.unit_id', 'units.id')
        ->join('branches', 'stocks.branch_id', 'branches.id')
        ->where('purchasing_details.qty', '>', 0)
        ->select('purchasing_details.id as id', 'qty', 'items.name as itemName', 'branches.name as branchName', 'units.name as unitName', 'items.id as item_id', 'units.id as unit_id', 'branches.id as branch_id')
        ->get();
        $history = HistoryPurchase::where('purchasing_id', $id)->orderBy('id', 'DESC')->get();
        foreach($history as $row) {
            $historyDetail = HistoryDetailPurchase::where('history_purchase_id', $row->id)
            ->join('purchasing_details', 'purchasing_detail_id', 'purchasing_details.id')
            ->join('items', 'purchasing_details.item_id', 'items.id')
            ->select('history_detail_purchases.qty as qty', 'history_detail_purchases.id as id', 'name', 'purchasing_detail_id')
            ->get();
            $row->history_detail = $historyDetail;
        }
        // $historyDetail = HistoryDetailPurchase::where('')

        return view('pages.backend.transaction.reception.editReception', compact('model', 'models', 'id', 'history'));
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
    public function update(Request $req, $id)
    {
        $total = 0;
        foreach($req->idDetail as $row) {
            $qtyNew = (int)str_replace(",", "", $req->qtyNew[$row]);
            $purchasing = PurchasingDetail::where('id', $req->idPurchasing[$row])->first();
            $total += $qtyNew * $purchasing->price;
        }
        // define('UPLOAD_DIR', 'images/');
        $image = $req->image;
        if($image != null) {
            $getEmployee =  Employee::with('branch')->where('user_id',Auth::user()->id)->first();
            $fileSave = 'assetstransaction/Reception_'. $getEmployee->Branch->code . date('YmdHis') . '.png';
            $fileName = 'Reception_'. $getEmployee->Branch->code . date('YmdHis') . '.png';
            $images = $this->base64_to_jpeg($image, $fileSave);
        } else {
            $fileName = null;
        }

        $date = date('Y-m-d H:i:s');
        $purchase = Purchasing::where('id', $id)->first();
        $purchase->done = 1;
        $purchase->save();

        $historyPurchase = new HistoryPurchase;
        $historyPurchase->purchasing_id = $id;
        $historyPurchase->image = $fileName;
        $historyPurchase->date = $date;
        $saveHistoryPurchase = $historyPurchase->save();

        $account = AccountData::find(14);
        $years = date("Y");
        $dates = date("Y-m-d");

        $jumlahqty = 0;
        $purchasingDetailQty = PurchasingDetail::where('purchasing_id', $purchase->id)->get();
        foreach ($purchasingDetailQty as $key => $value) {
            $jumlahqty += $value->qty_start;
        }
        $finalTotal = 0;
        foreach($req->idDetail as $row) {
            $qtyNew = (int)str_replace(",", "", $req->qtyNew[$row]);
            $purchasing = PurchasingDetail::where('id', $req->idPurchasing[$row])->first();
            $totalPriceDetail = $qtyNew * $purchasing->price;

            $discountType = $purchasing->discountType;
            $discountValue = $purchasing->discountValue;

            if($discountType == 0) {
                $penguranganDiscount = $totalPriceDetail / 100 * $discountValue;
            } else {
                $penguranganDiscount = ($discountValue / $jumlahqty) * $qtyNew;
            }
            $totalHargaJurnal = $totalPriceDetail - $penguranganDiscount;
            $finalTotal += $totalHargaJurnal;

            $historyDetailPurchase = new HistoryDetailPurchase;
            $historyDetailPurchase->history_purchase_id = $historyPurchase->id;
            $historyDetailPurchase->purchasing_detail_id = $purchasing->id;
            $historyDetailPurchase->qty = $qtyNew;
            $historyDetailPurchase->save();
            $output[] = array($qtyNew);
            
            $purchasing->qty -= $qtyNew;
            $purchasing->edit = 1;
            $purchasing->save();

            $stocks = Stock::where('item_id', $req->idItem[$row])
            ->where('unit_id', $req->idUnit[$row])
            ->where('branch_id', $req->idBranch[$row])
            ->first();
            $stocks->stock += $qtyNew;
            $stocks->save();
        }
        $branch_id = Auth::user()->employee->branch_id;
        $years = date("Y");
        $dates = date("Y-m-d");

        $debetKredit = array("K", "D");
        $accountId = array([4, 12], [3,11]);
        $descriptionJournal = array("Pendapatan Dimuka Pembelian", "Persediaan Barang Dagang");

        $journal = new Journal;
        $journal->code = "DD13010101".$branch_id;
        $journal->year = $years; 
        $journal->date = $dates;
        $journal->total = str_replace(",", '',$finalTotal);
        $journal->type = "Persediaan Barang Dagang";
        $journal->ref = $purchase->code;
        $journal->description = $purchase->description;
        // $journal->description = $descriptionJournal[$key];
        $saveJournal = $journal->save();

        if ($saveJournal) {
            foreach ($debetKredit as $key => $value) {
                $journalDetail = new JournalDetail;
                $accountData = AccountData::where('main_id', $accountId[$key][0])->where('main_detail_id', $accountId[$key][1])->where('branch_id', $branch_id)->first();
                $journalDetail->journal_id = $journal->id;
                $journalDetail->account_id = $accountData->id;
                $journalDetail->total = str_replace(",", '',$finalTotal);
                $journalDetail->description = $purchase->description . " " . $descriptionJournal[$key];
                $journalDetail->debet_kredit = $debetKredit[$key];
                $journalDetail->save();
            }
        }

        $done = 1;
        $purchaseDetail = PurchasingDetail::where('purchasing_id', $id)->get();
        foreach($purchaseDetail as $row) {
            if($row->qty > 0) {
                $done = 0;
            }
        }
        if($done == 1){
            $purchase->done = 2;
            $purchase->created_by = Auth::user()->name;
            $purchase->save();
        }
        return Redirect::route('reception.index')
            ->with([
                'status' => 'Berhasil mencatat penerimaan ',
                'type' => 'success'
            ]);
    }
    public function updateHistory($id, $history, $qtyEdit = null)
    {
        // $id = 2;
        // $history = 3;
        // $qtyEdit = 20;
        $queryHistory = HistoryDetailPurchase::where('id', $history)
        ->where('purchasing_detail_id', $id)->first();
        $purchasingDetail = PurchasingDetail::where('id', $id)->first();
        $stocks = Stock::where('item_id', $purchasingDetail->item_id)
            ->where('unit_id', $purchasingDetail->unit_id)
            ->where('branch_id', $purchasingDetail->branch_id)
            ->first();
        $qtyTrue = 0;
        $qtyBefore = $queryHistory->qty;
        if($qtyBefore > $qtyEdit){
            $qtyTrue = $qtyBefore - $qtyEdit;
            $queryHistory->qty = $qtyEdit;
            $queryHistory->save();

            $purchasingDetail->qty += $qtyTrue;
            $purchasingDetail->save();

            $stocks->stock -= $qtyTrue;
            $stocks->save();
        } else if($qtyBefore < $qtyEdit) {
            $qtyTrue = $qtyEdit - $qtyBefore;
            $queryHistory->qty = $qtyEdit;
            $queryHistory->save();

            $purchasingDetail->qty -= $qtyTrue;
            $purchasingDetail->save();

            $stocks->stock += $qtyTrue;
            $stocks->save();
        } else {

        }
        return Redirect::route('reception.index')
            ->with([
                'status' => 'Berhasil mengubah jumlah barang ',
                'type' => 'success'
            ]);

    }
    public function updated(Request $req)
    {

        // return Response::json(['status' => 'success']);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus data barang ' . PurchasingDetail::find($id)->name
        );

        PurchasingDetail::destroy($id);

        return Response::json(['status' => 'success']);
    }
    public function history(Request $request)
    {
        $models = $request->id;
        return view('pages.backend.transaction.reception.historyReception', compact("models"));
    }
}
