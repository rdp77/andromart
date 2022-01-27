<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Branch;
use App\Models\Cash;
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
                ->addColumn('date', function ($row) {
                    $htmlAdd =   '<tr>';
                    $htmlAdd .=      '<td>' . Carbon::parse($row->date)->locale('id')->isoFormat('LL') . '</td>';
                    $htmlAdd .=   '</tr>';

                    return $htmlAdd;
                })
                ->addColumn('price', function ($row) {
                    $htmlAdd =   '<tr>';
                    $htmlAdd .=      '<td>' . number_format($row->price, 0, ".", ",") . '</td>';
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
                    $actionBtn .= '<a onclick="jurnal(' . "'" . $row->code . "'" . ')" class="dropdown-item" style="cursor:pointer;">Jurnal</a>';
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
        $getEmployee =  Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('payments')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function codeJournals($type)
    {
        $getEmployee =  Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('journals')->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function create()
    {
        $checkBranch = Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $code = $this->code('SPND');
        if ($checkBranch->branch_id == 1) {
            $branch = Branch::get();
            $cash = AccountData::get();
            $cash_transfer = AccountData::get();
        } else {
            $branch = Branch::where('id', $checkBranch->branch_id)->get();
            $cash = AccountData::where('branch_id', $checkBranch->branch_id)->get();
            $cash_transfer = AccountData::where('branch_id', 1)->get();
        }

        return view('pages.backend.transaction.payment.createPayment', compact('cash', 'code', 'branch', 'cash_transfer'));
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
                'type' => $req->type_id,
                'transfer_to' => $req->cash_tranfer_id,
                'cash_id' => $req->cash_id,
                'price' => str_replace(",", '', $req->price),
                'description' => $req->description,
                'created_by' => Auth::user()->name,
            ]);

            if ($req->type_id == 'Transfer') {
                $idJournal = DB::table('journals')->max('id') + 1;
                Journal::create([
                    'id' => $idJournal,
                    'code' => $this->codeJournals('KK', $idJournal),
                    'year' => date('Y',strtotime($date)),
                    'date' => $date,
                    'type' => 'Biaya',
                    'total' => str_replace(",", '', $req->price),
                        'ref' => $req->code,
                    'description' => $req->description,
                    'created_at' => date('Y-m-d h:i:s'),
                    // 'updated_at'=>date('Y-m-d h:i:s'),
                ]);

                $accountPembayaran  = AccountData::where('id', $req->account)
                    ->first();
                $accountCode = [
                    $req->cost_id,
                    $req->cash_id,
                ];
                $totalBayar = [
                    str_replace(",", '', $req->price),
                    str_replace(",", '', $req->price),
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
                        'total' => $totalBayar[$i],
                        'description' => $description[$i],
                        'debet_kredit' => $DK[$i],
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
                }


                $idJournalMasuk = DB::table('journals')->max('id') + 1;
                Journal::create([
                    'id' => $idJournalMasuk,
                    'code' => $this->codeJournals('DD', $idJournalMasuk),
                    'year' => date('Y',strtotime($date)),
                    'date' => $date,
                    'type' => 'Transfer Masuk',
                    'total' => str_replace(",", '', $req->price),
                    'ref' => $req->code,
                    'description' => $req->description,
                    'created_at' => date('Y-m-d h:i:s'),
                    // 'updated_at'=>date('Y-m-d h:i:s'),
                ]);

                $accountPembayaran  = AccountData::where('id', $req->cash_tranfer_id)
                    ->first();

                $accountCode = [
                    $accountPembayaran->id,
                    $req->cost_id,
                ];
                $totalBayar = [
                    str_replace(",", '', $req->price),
                    str_replace(",", '', $req->price),
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
                        'total' => $totalBayar[$i],
                        'description' => $description[$i],
                        'debet_kredit' => $DK[$i],
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
                }
            } else {
                $idJournal = DB::table('journals')->max('id') + 1;
                Journal::create([
                    'id' => $idJournal,
                    'code' => $this->codeJournals('KK', $idJournal),
                    'year' => date('Y',strtotime($date)),
                    'date' => $date,
                    'type' => 'Biaya',
                    'total' => str_replace(",", '', $req->price),
                    'ref' => $req->code,
                    'description' => $req->description,
                    'created_at' => date('Y-m-d h:i:s'),
                    // 'updated_at'=>date('Y-m-d h:i:s'),
                ]);

                $accountPembayaran  = AccountData::where('id', $req->account)
                    ->first();
                $accountCode = [
                    $req->cost_id,
                    $req->cash_id,
                ];
                $totalBayar = [
                    str_replace(",", '', $req->price),
                    str_replace(",", '', $req->price),
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
                        'total' => $totalBayar[$i],
                        'description' => $description[$i],
                        'debet_kredit' => $DK[$i],
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
                }
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
            return $th;
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

        return view(
            'pages.backend.transaction.payment.updatePayment',
            ['payment' => $payment, 'branch' => $branch, 'cash' => $cash, 'cost' => $cost]
        );
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
        $payment = Payment::find($id);
        $checkJurnal = DB::table('journals')->where('ref', $payment->code)->first();
        DB::table('journal_details')->where('journal_id', $checkJurnal->id)->delete();
        DB::table('journals')->where('id', $checkJurnal->id)->delete();
        DB::table('payments')->where('id', $id)->delete();
        return Response::json(['status' => 'success']);
    }

    function paymentCheckJournals(Request $req)
    {
        $data = Journal::with('JournalDetail.AccountData')->where('ref', $req->id)->first();
        return Response::json(['status' => 'success', 'jurnal' => $data]);
    }
    public function checkSaldoKas()
    {
        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '<=', date('Y-m-d'))
            ->get();

        // return $data;
        $totalKasBankMukmin['K'] = [];
        $totalKasBankMukmin['D'] = [];
        $totalKasKecilMukmin['K'] = [];
        $totalKasKecilMukmin['D'] = [];
        $totalKasBankJenggolo['K'] = [];
        $totalKasBankJenggolo['D'] = [];
        $totalKasKecilJenggolo['K'] = [];
        $totalKasKecilJenggolo['D'] = [];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]->JournalDetail); $j++) {

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D'  && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasKecilMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 1 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasKecilJenggolo['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 2) {
                    $totalKasBankMukmin['D'][$i] = $data[$i]->total;
                }

                if ($data[$i]->JournalDetail[$j]->debet_kredit == 'K' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['K'][$i] = $data[$i]->total;
                } else if ($data[$i]->JournalDetail[$j]->debet_kredit == 'D' && $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == 3 && $data[$i]->JournalDetail[$j]->AccountData->branch_id == 1) {
                    $totalKasBankJenggolo['D'][$i] = $data[$i]->total;
                }
            }
        }
        $dataSaldoKas = $this->checkSaldoKas(date('Y-m-d'));
        // CEK TOTAL KAS J KECIL D K
        $totalKasKecilJenggoloValuesD = array_values($totalKasKecilJenggolo['D']);
        $totalKasKecilJenggoloValuesK = array_values($totalKasKecilJenggolo['K']);
        $totalKasKecilJenggoloValD = 0;
        $totalKasKecilJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesD); $i++) {
            $totalKasKecilJenggoloValD += $totalKasKecilJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilJenggoloValuesK); $i++) {
            $totalKasKecilJenggoloValK += $totalKasKecilJenggoloValuesK[$i];
        }
        $totalKasKecilJenggoloFix = $dataSaldoKas[1]['total'] + $totalKasKecilJenggoloValD - $totalKasKecilJenggoloValK;
        // return [$dataSaldoKas[1]['total'],$totalKasKecilJenggoloValD];
        // return $totalKasKecilJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasKecilMukminValuesD = array_values($totalKasKecilMukmin['D']);
        $totalKasKecilMukminValuesK = array_values($totalKasKecilMukmin['K']);
        $totalKasKecilMukminValD = 0;
        $totalKasKecilMukminValK = 0;
        for ($i = 0; $i < count($totalKasKecilMukminValuesD); $i++) {
            $totalKasKecilMukminValD += $totalKasKecilMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasKecilMukminValuesK); $i++) {
            $totalKasKecilMukminValK += $totalKasKecilMukminValuesK[$i];
        }
        $totalKasKecilMukminFix = $dataSaldoKas[0]['total'] + $totalKasKecilMukminValD - $totalKasKecilMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // CEK TOTAL KAS J KECIL D K
        $totalKasBankJenggoloValuesD = array_values($totalKasBankJenggolo['D']);
        $totalKasBankJenggoloValuesK = array_values($totalKasBankJenggolo['K']);
        $totalKasBankJenggoloValD = 0;
        $totalKasBankJenggoloValK = 0;
        for ($i = 0; $i < count($totalKasBankJenggoloValuesD); $i++) {
            $totalKasBankJenggoloValD += $totalKasBankJenggoloValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankJenggoloValuesK); $i++) {
            $totalKasBankJenggoloValK += $totalKasBankJenggoloValuesK[$i];
        }
        $totalKasBankJenggoloFix =  $dataSaldoKas[3]['total'] + $totalKasBankJenggoloValD - $totalKasBankJenggoloValK;

        // return $totalKasBankJenggoloFix;
        // CEK TOTAL KAS M KECIL D K
        $totalKasBankMukminValuesD = array_values($totalKasBankMukmin['D']);
        $totalKasBankMukminValuesK = array_values($totalKasBankMukmin['K']);
        $totalKasBankMukminValD = 0;
        $totalKasBankMukminValK = 0;
        for ($i = 0; $i < count($totalKasBankMukminValuesD); $i++) {
            $totalKasBankMukminValD += $totalKasBankMukminValuesD[$i];
        }
        for ($i = 0; $i < count($totalKasBankMukminValuesK); $i++) {
            $totalKasBankMukminValK += $totalKasBankMukminValuesK[$i];
        }
        $totalKasBankMukminFix =  $dataSaldoKas[2]['total'] + $totalKasBankMukminValD - $totalKasBankMukminValK;
        // return[$totalKasKecilJenggoloValD,$totalKasKecilJenggoloValK];
        // return $totalKasKecilMukminFix;
        // return [$totalKasKecilMukminFix, $totalKasKecilJenggoloFix, $totalKasBankMukminFix, $totalKasBankJenggoloFix];

        $accountOpening = AccountData::with('accountMainDetail')->where('main_id', '1')->get();
        // return $accountOpening;
        $totalKCCJ = 0;
        $totalKCCM = 0;
        $totalKBCM = 0;
        $totalKBCJ = 0;
        // if ($accountOpening[0]->name == 'Kas Kecil Cabang Pusat') {
        //     if ($accountOpening[0]->opening_date < date('Y-m-d')) {
        //         $totalKCCJ =  $accountOpening[0]->opening_balance;
        //     }
        // } else if ($accountOpening[1]->name == 'Kas Kecil Cabang Mukmin') {
        //     if ($accountOpening[1]->opening_date < date('Y-m-d')) {
        //         $totalKCCM =  $accountOpening[1]->opening_balance;
        //     }
        // } else if ($accountOpening[2]->name == 'Kas Bank Cabang Pusat') {
        //     if ($accountOpening[2]->opening_date < date('Y-m-d')) {
        //         $totalKBCM =  $accountOpening[2]->opening_balance;
        //     }
        // } else if ($accountOpening[3]->name == 'Kas Bank Cabang Pusat') {
        //     if ($accountOpening[3]->opening_date < date('Y-m-d')) {
        //         $totalKBCJ =  $accountOpening[3]->opening_balance;
        //     }
        // }
     
        if ($accountOpening[0]->name == 'Kas Kecil Cabang Pusat') {
            if ($accountOpening[0]->opening_date >= date('Y-m-01') && $accountOpening[0]->opening_date <= date('Y-m-d')) {
                $totalKCCJ =  $accountOpening[0]->opening_balance;
            }
        } 
         if ($accountOpening[1]->name == 'Kas Kecil Cabang Mukmin') {
            if ($accountOpening[1]->opening_date >= date('Y-m-01') && $accountOpening[1]->opening_date <= date('Y-m-d')) {
                $totalKCCM =  $accountOpening[1]->opening_balance;
            }
        } 
         if ($accountOpening[2]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[2]->opening_date >= date('Y-m-01') && $accountOpening[2]->opening_date <= date('Y-m-d')) {
                $totalKBCM =  $accountOpening[2]->opening_balance;
            }
        } 
         if ($accountOpening[3]->name == 'Kas Bank Cabang Pusat') {
            if ($accountOpening[3]->opening_date >= date('Y-m-01') && $accountOpening[3]->opening_date <= date('Y-m-d')) {
                $totalKBCJ =  $accountOpening[3]->opening_balance;
            }
        }
        // return$totalKCCM;

        $dtFix = [
            ['total' => $totalKasKecilMukminFix + $totalKCCM, 'nama' => 'Kas Kecil Cabang Mukmin'],
            ['total' => $totalKasKecilJenggoloFix + $totalKCCJ, 'nama' => 'Kas Kecil Cabang Jenggolo'],
            ['total' => $totalKasBankMukminFix + $totalKBCM, 'nama' => 'Kas Bank Cabang Mukmin'],
            ['total' => $totalKasBankJenggoloFix + $totalKBCJ, 'nama' => 'Kas Bank Cabang Jenggolo']
        ];
    }
}
