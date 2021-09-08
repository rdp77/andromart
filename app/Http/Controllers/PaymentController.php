<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Cost;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class PaymentController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Payment::with('cost', 'branch', 'cash')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row){
                    $htmlAdd =   '<tr>';
                    $htmlAdd .=      '<td>'.Carbon::parse($row->date)->locale('id')->isoFormat('LL').'</td>';
                    $htmlAdd .=   '</tr>';

                    return $htmlAdd;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('payment.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'date'])
                ->make(true);
        }
        return view('pages.backend.transaction.payment.indexPayment');
    }

    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('payments')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$year . $month . $index;
    }

    public function create()
    {
        $code = $this->code('PGN-');
        $branch = Branch::get();
        $cash = Cash::get();
        $cost = Cost::get();

        return view('pages.backend.transaction.payment.createPayment', compact('cash', 'code', 'branch', 'cost'));
    }

    public function store(Request $req)
    {
        Payment::create([
            'code' => $req->code,
            'date' => date('Y-m-d'),
            'cost_id' => $req->cost_id,
            'branch_id' => $req->branch_id,
            'cash_id' => $req->cash_id,
            'price' => $req->price,
            'description' => $req->description,
            'created_by' => Auth::user()->name,
        ]);

        $biaya = Cash::findOrFail($req->cash_id);
        $biaya->balance -= $req->price;
        $biaya->save();

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat transaksi pembayaran baru'
        );

        return Redirect::route('payment.index')
            ->with([
                'status' => 'Berhasil membuat transaksi pembayaran baru',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $branch = Branch::where('id', '!=', Payment::find($id)->branch_id)->get();
        $cost = Cost::where('id', '!=', Payment::find($id)->cost_id)->get();
        $cash = Cash::where('id', '!=', Payment::find($id)->cash_id)->get();
        $payment = Payment::find($id);

        return view('pages.backend.transaction.payment.updatePayment',
        ['payment' => $payment, 'branch' => $branch, 'cash' => $cash, 'cost' => $cost]);
    }

    public function update(Request $req, $id)
    {
        Type::where('id', $id)
        ->update([
            'cost_id' => $req->cost_id,
            'branch_id' => $req->branch_id,
            'description' => $req->description,
            'updated_by' => Auth::user()->name,
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
