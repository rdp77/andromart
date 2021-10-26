<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Branch;
use App\Modcels\Cash;
use App\Models\AccountData;
use App\Models\Cost;
use App\Models\Type;
use App\Models\Journal;
use App\Models\Employee;
use App\Models\JournalDetail;
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
                ->addColumn('price', function ($row){
                    $htmlAdd =   '<tr>';
                    $htmlAdd .=      '<td>'.number_format($row->price,0,".",",").'</td>';
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
                ->rawColumns(['action', 'date', 'price'])
                ->make(true);
        }
        return view('pages.backend.transaction.payment.indexPayment');
    }

    // public function code($type)
    // {
    //     $month = Carbon::now()->format('m');
    //     $year = Carbon::now()->format('y');
    //     $index = DB::table('payments')->max('id')+1;

    //     $index = str_pad($index, 3, '0', STR_PAD_LEFT);
    //     return $code = $type.$year . $month . $index;
    // }
    public function code($type)
    {
        $getEmployee =  Employee::with('branch')->where('user_id',Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('payments')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$getEmployee->Branch->code.$year . $month . $index;
    }
    public function codeJournals($type)
    {
        $getEmployee =  Employee::with('branch')->where('user_id',Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('journals')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$getEmployee->Branch->code.$year . $month . $index;
    }
    public function create()
    {
        $code = $this->code('SPND');
        $branch = Branch::get();
        $cash = AccountData::get();
        $cost = Cost::get();

        return view('pages.backend.transaction.payment.createPayment', compact('cash', 'code', 'branch', 'cost'));
    }

    public function store(Request $req)
    {
        // return $req->all();
        DB::beginTransaction();
        try {
            //code...
        
        $date = $this->DashboardController->changeMonthIdToEn($req->date);

        Payment::create([
            'code' => $req->code,
            'date' => $date,
            'cost_id' => $req->cost_id,
            'branch_id' => $req->branch_id,
            'cash_id' => $req->cash_id,
            'price' => str_replace(",", '',$req->price),
            'description' => $req->description,
            'created_by' => Auth::user()->name,
        ]);
        

        $idJournal = DB::table('journals')->max('id')+1;
        Journal::create([
            'id' =>$idJournal,
            'code'=>$this->codeJournals('KK',$idJournal),
            'year'=>date('Y'),
            'date'=>date('Y-m-d'),
            'type'=>'Biaya',
            'total'=>str_replace(",", '',$req->price),
            'ref'=>$req->code,
            'description'=>$req->description,
            'created_at'=>date('Y-m-d h:i:s'),
            // 'updated_at'=>date('Y-m-d h:i:s'),
        ]);

        $accountPembayaran  = AccountData::where('id',$req->account)
                            ->first();
        $accountCode = [
            $req->cost_id,
            $req->cash_id,
        ];  
        $totalBayar = [
            str_replace(",", '',$req->price),
            str_replace(",", '',$req->price),
        ];
        $description = [
            $req->description,
            $req->description,
        ];
        $DK = [
            'D',
            'K',
        ];
    

        for ($i=0; $i <count($accountCode) ; $i++) { 
            $idDetail = DB::table('journal_details')->max('id')+1;
            JournalDetail::create([
                'id'=>$idDetail,
                'journal_id'=>$idJournal,
                'account_id'=>$accountCode[$i],
                'total'=>$totalBayar[$i],
                'description'=>$description[$i],
                'debet_kredit'=>$DK[$i],
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s'),
            ]);
        }

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat transaksi pembayaran baru'
        );

            DB::commit();
            return Redirect::route('payment.index')
            ->with([
                'status' => 'Berhasil membuat transaksi pembayaran baru',
                'type' => 'success'
            ]);
       

        } catch (\Throwable $th) {
            DB::rollback();
            return$th;
            //throw $th;
        }
        
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

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Pengeluaran'
        );
        Payment::destroy($id);
        return Response::json(['status' => 'success']);
    }
}
