<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\PurchasingDetail;
use App\Models\HistoryPurchase;
use App\Models\HistoryDetailPurchase;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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
            $data = Purchasing::with('employee')->get();
            foreach($data as $row) {
                $tanggal = date("d F", strtotime($row->date));
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
        // ->join('employees', 'purchasings.employee_id', 'employees.id')
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
        $history = HistoryPurchase::where('purchasing_id', $id)->get();
        // dd($history);
        // $historyDetail = HistoryDetailPurchase::where('')

        return view('pages.backend.transaction.reception.editReception', compact('model', 'models', 'id', 'history'));
    }

    public function update(Request $req, $id)
    {
        $purchase = Purchasing::where('id', $id)->first();
        $purchase->done = 1;
        $purchase->save();
        // dd($req->idDetail);
        foreach($req->idDetail as $row) {
            $purchasing = PurchasingDetail::where('id', $req->idPurchasing[$row])
            ->first();
            $purchasing->qty -= $req->qtyNew[$row];
            $purchasing->save();

            $stocks = Stock::where('item_id', $req->idItem[$row])
            ->where('unit_id', $req->idUnit[$row])
            ->where('branch_id', $req->idBranch[$row])
            ->first();
            $stocks->stock += $req->qtyNew[$row];
            $stocks->save();
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

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master area ' . Area::find($id)->name
        );

        Area::destroy($id);

        return Response::json(['status' => 'success']);
    }
    public function history(Request $request)
    {
        $models = $request->id;
        return view('pages.backend.transaction.reception.historyReception', compact("models"));
    }
}
