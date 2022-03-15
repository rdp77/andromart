<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Employee;
use App\Models\AccountData;
use App\Models\Service;
use App\Models\Journal;
use App\Models\JournalDetail;
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

class ServicePaymentController extends Controller
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
        $checkRoles = $this->DashboardController->cekHakAkses(4, 'view');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }
        if ($req->ajax()) {
            $data = ServicePayment::with(['Service', 'ServiceDetail', 'user'])->orderBy('id', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    // $actionBtn .= '<a onclick="reset(' . $row->id . ')" class="btn btn-primary text-white" style="cursor:pointer;">Reset Password</a>';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .=
                        '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' .
                        route('service-payment.edit', $row->id) .
                        '"><i class="far fa-edit"></i> Edit</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('service.printServicePayment', $row->id) . '"><i class="fas fa-print"></i> Print</a>';
                    // $actionBtn .= '<a class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    $actionBtn .= '<a onclick="jurnal(' . "'" . $row->code . "'" . ')" class="dropdown-item" style="cursor:pointer;"><i class="fas fa-file-alt"></i> Jurnal</a>';

                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('dateData', function ($row) {
                    return Carbon::parse($row->date)
                        ->locale('id')
                        ->isoFormat('LL');
                })
                ->addColumn('totalValue', function ($row) {
                    return number_format($row->total, 0, '.', ',');
                })
                ->addColumn('currentStatus', function ($row) {
                    if ($row->type == 'Lunas') {
                        return '<div class="badge badge-success">Lunas</div>';
                    } elseif ($row->type == 'DownPayment') {
                        return '<div class="badge badge-warning">Bayar DP</div>';
                    } elseif ($row->type == null) {
                        return '<div class="badge badge-danger">Belum Bayar</div>';
                    }
                })

                ->addColumn('informationService', function ($row) {
                    if ($row->Service->work_status == 'Proses') {
                        $work_status = '<div class="badge badge-warning">Proses Pengerjaan</div>';
                    } elseif ($row->Service->work_status == 'Mutasi') {
                        $work_status = '<div class="badge badge-warning">Perpindahan Teknisi</div>';
                    } elseif ($row->Service->work_status == 'Selesai') {
                        $work_status = '<div class="badge badge-success">Selesai</div>';
                    } elseif ($row->Service->work_status == 'Cancel') {
                        $work_status = '<div class="badge badge-danger">Service Batal</div>';
                    } elseif ($row->Service->work_status == 'Manifest') {
                        $work_status = '<div class="badge badge-primary">Barang Diterima</div>';
                    } elseif ($row->Service->work_status == 'Diambil') {
                        $work_status = '<div class="badge badge-success">Sudah Diambil</div>';
                    } elseif ($row->work_status == 'Return') {
                        $work_status = '<div class="badge badge-success">Sudah Diambil</div>';
                    }

                    if ($row->Service->payment_status == 'Lunas') {
                        $paymentStatus = '<div class="badge badge-success">Lunas</div>';
                    } elseif ($row->Service->payment_status == 'DownPayment') {
                        $paymentStatus = '<div class="badge badge-warning">Bayar DP</div>';
                    } elseif ($row->Service->payment_status == null) {
                        $paymentStatus = '<div class="badge badge-danger">Belum Bayar</div>';
                    }

                    $htmlAdd = '<table>';
                    $htmlAdd .= '<tr>';
                    $htmlAdd .= '<td>Kode Service</td>';
                    $htmlAdd .= '<th>' . $row->Service->code . '</th>';
                    $htmlAdd .= '<td>Tgl Service</td>';
                    $htmlAdd .=
                        '<th>' .
                        Carbon::parse($row->Service->date)
                            ->locale('id')
                            ->isoFormat('LL') .
                        '</th>';
                    $htmlAdd .= '</tr>';
                    $htmlAdd .= '<tr>';
                    $htmlAdd .= '<td>status bayar</td>';
                    $htmlAdd .= '<th>' . $paymentStatus . '</th>';
                    $htmlAdd .= '<td>status kerja</td>';
                    $htmlAdd .= '<th>' . $work_status . '</th>';
                    $htmlAdd .= '</tr>';
                    $htmlAdd .= '<tr>';
                    $htmlAdd .= '<td>Total</td>';
                    $htmlAdd .= '<th>' . number_format($row->Service->total_price, 0, '.', ',') . '</th>';
                    $htmlAdd .= '<td>Customer</td>';
                    $htmlAdd .= '<th>' . $row->Service->customer_name . '</th>';
                    $htmlAdd .= '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })

                ->rawColumns(['action', 'informationService', 'currentStatus'])
                ->make(true);
        }
        return view('pages.backend.transaction.servicePayment.indexServicePayment');
    }

    public function code($type, $id)
    {
        $getEmployee = Employee::with('branch')
            ->where('user_id', Auth::user()->id)
            ->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = str_pad($id, 3, '0', STR_PAD_LEFT);
        return $code = $type . $getEmployee->Branch->code . $year . $month . $index;
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
    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(4, 'create');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }
        $id = DB::table('service_payment')->max('id') + 1;
        $code = $this->code('BYR', $id);
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        $items = Item::where('name', '!=', 'Jasa Service')->get();
        $account = AccountData::with('AccountMain', 'AccountMainDetail', 'Branch')->get();
        $data = Service::where(function ($query) {
            $query->where('payment_status', 'DownPayment');
            $query->orWhere('payment_status', null);
        })
            ->with('Brand', 'Type', 'ServiceDetail')
            ->get();
        return view('pages.backend.transaction.servicePayment.createServicePayment', compact('employee', 'code', 'items', 'data', 'account'));
    }

    public function store(Request $req)
    {
        // return Service::with('ServiceDetail')->where('id',$req->serviceId)->get();
        // return $req->all();
        // return [str_replace(",", '', $req->totalPayment),str_replace(",", '', $req->totalDiscountValue)];

        DB::beginTransaction();
        try {
            // return $req->all();
            $dateConvert = $this->DashboardController->changeMonthIdToEn($req->date);
            $id = DB::table('service_payment')->max('id') + 1;
            $getEmployee = Employee::where('user_id', Auth::user()->id)->first();
            $kode = $this->code('BYR', $id);
            ServicePayment::create([
                'id' => $id,
                'code' => $kode,
                'user_id' => Auth::user()->id,
                'service_id' => $req->serviceId,
                'date' => $dateConvert,
                'total' => str_replace(',', '', $req->totalPayment),
                'type' => $req->type,
                'payment_method' => $req->paymentMethod,
                'account' => $req->account,
                'description' => 'Pelunasan Service ' . $kode,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            if ($req->type == 'DownPayment') {
                Service::where('id', $req->serviceId)->update([
                    'payment_status' => $req->type,
                    'downpayment_date' => $dateConvert,
                    'total_downpayment' => str_replace(',', '', $req->totalPayment),
                ]);
            } else {
                Service::where('id', $req->serviceId)->update([
                    'payment_status' => $req->type,
                    'payment_date' => $dateConvert,
                    'total_payment' => str_replace(',', '', $req->totalPayment),
                ]);
            }
            // penjurnalan
            $idJournal = DB::table('journals')->max('id') + 1;
            Journal::create([
                'id' => $idJournal,
                'code' => $this->code('DD', $idJournal),
                'year' => date('Y'),
                'date' => $dateConvert,
                'type' => 'Pembayaran Service',
                'total' => str_replace(',', '', $req->totalPayment),
                'ref' => $kode,
                'description' => 'Pembayaran Service ' . $kode,
                'created_at' => date('Y-m-d h:i:s'),
                // 'updated_at'=>date('Y-m-d h:i:s'),
            ]);
            if ($req->type == 'DownPayment') {
                $accountData = AccountData::where('branch_id', $getEmployee->branch_id)
                    ->where('active', 'Y')
                    ->where('main_id', 4)
                    ->where('main_detail_id', 4)
                    ->first();
                if ($accountData == null) {
                    DB::rollback();
                    return Response::json(['status' => 'error', 'message' => 'Akun Pembayaran Dimuka Kosong']);
                }

                $accountPembayaran = AccountData::where('id', $req->account)->first();
                $accountCode = [$accountPembayaran->id, $accountData->id];
                $totalBayar = [str_replace(',', '', $req->totalPayment), str_replace(',', '', $req->totalPayment)];
                $description = ['Down Payment Service ' . $kode, 'Down Payment Service ' . $kode];
                $DK = ['D', 'K'];

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
                // DB::rollback();
                $checkService = ServicePayment::where('id', '!=', $id)
                    ->where('service_id', $req->serviceId)
                    ->where('type', 'DownPayment')
                    ->first();

                $accountDimuka = AccountData::where('branch_id', $getEmployee->branch_id)
                    ->where('active', 'Y')
                    ->where('main_id', 4)
                    ->where('main_detail_id', 4)
                    ->first();

                if ($accountDimuka == null) {
                    DB::rollback();
                    return Response::json(['status' => 'error', 'message' => 'Akun Pembayaran Dimuka Kosong']);
                }

                $accountService = AccountData::where('branch_id', $getEmployee->branch_id)
                    ->where('active', 'Y')
                    ->where('main_id', 5)
                    ->where('main_detail_id', 6)
                    ->first();

                $accountJasa = AccountData::where('branch_id', $getEmployee->branch_id)
                    ->where('active', 'Y')
                    ->where('main_id', 5)
                    ->where('main_detail_id', 5)
                    ->first();

                $accountDiskon = AccountData::where('branch_id', $getEmployee->branch_id)
                    ->where('active', 'Y')
                    ->where('main_id', 8)
                    ->where('main_detail_id', 31)
                    ->first();

                $accountPembayaran = AccountData::where('id', $req->account)->first();

                if (str_replace(',', '', $req->totalDiscountValue) == 0) {
                    $accountCode = [$accountPembayaran->id, $accountService->id, $accountJasa->id];
                    $totalBayar = [str_replace(',', '', $req->totalPayment), str_replace(',', '', $req->totalSparePart), str_replace(',', '', $req->totalService)];
                    $description = ['Kas Pelunasan Service ' . $kode, 'Pendapatan SparePart Pelunasan Service ' . $kode, 'Pendapatan Jasa Service Pelunasan Service ' . $kode];
                    $DK = ['D', 'K', 'K'];
                } else {
                    $accountCode = [$accountPembayaran->id, $accountDiskon->id, $accountService->id, $accountJasa->id];
                    $totalBayar = [str_replace(',', '', $req->totalPayment), str_replace(',', '', $req->totalDiscountValue), str_replace(',', '', $req->totalSparePart), str_replace(',', '', $req->totalService)];
                    $description = ['Kas Pelunasan Service ' . $req->totalPayment . ' ' . $kode, 'Diskon Pelunasan Service ' . $kode, 'Pendapatan SparePart Pelunasan Service ' . $kode, 'Pendapatan Jasa Service Pelunasan Service ' . $kode];
                    $DK = ['D', 'D', 'K', 'K'];
                }

                if ($checkService != null) {
                    array_unshift($accountCode, $accountDimuka->id);
                    array_unshift($totalBayar, str_replace(',', '', $checkService->total));
                    array_unshift($description, $req->description);
                    array_unshift($DK, 'D');
                }

                for ($i = 0; $i < count($accountCode); $i++) {
                    if ($totalBayar[$i] != 0) {
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

                // return [$dateConvert];

                //Jurnal HPP
                if (isset($req->totalHpp)) {
                    $idJournalHpp = DB::table('journals')->max('id') + 1;
                    Journal::create([
                        'id' => $idJournalHpp,
                        'code' => $this->code('KK', $idJournalHpp),
                        'year' => date('Y'),
                        'date' => $dateConvert,
                        'type' => 'Biaya',
                        'total' => str_replace(',', '', $req->totalHpp),
                        'ref' => $kode,
                        'description' => 'HPP ' . $kode,
                        'created_at' => date('Y-m-d h:i:s'),
                    ]);

                    $accountPersediaan = AccountData::where('branch_id', $getEmployee->branch_id)
                        ->where('active', 'Y')
                        ->where('main_id', 3)
                        ->where('main_detail_id', 11)
                        ->first();

                    $accountBiayaHpp = AccountData::where('branch_id', $getEmployee->branch_id)
                        ->where('active', 'Y')
                        ->where('main_id', 7)
                        ->where('main_detail_id', 29)
                        ->first();
                    // JURNAL HPP
                    $accountCodeHpp = [$accountBiayaHpp->id, $accountPersediaan->id];
                    // return $accountCodeHpp;
                    $totalHpp = [str_replace(',', '', $req->totalHpp), str_replace(',', '', $req->totalHpp)];
                    $descriptionHpp = ['Pengeluaran Harga Pokok Penjualan ' . $kode, 'Biaya Harga Pokok Penjualan' . $kode];
                    $DKHpp = ['D', 'K'];
                    for ($i = 0; $i < count($accountCodeHpp); $i++) {
                        if ($totalHpp[$i] != 0) {
                            $idDetailhpp = DB::table('journal_details')->max('id') + 1;
                            JournalDetail::create([
                                'id' => $idDetailhpp,
                                'journal_id' => $idJournalHpp,
                                'account_id' => $accountCodeHpp[$i],
                                'total' => $totalHpp[$i],
                                'description' => $descriptionHpp[$i],
                                'debet_kredit' => $DKHpp[$i],
                                'created_at' => date('Y-m-d h:i:s'),
                                'updated_at' => date('Y-m-d h:i:s'),
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return Response::json(['status' => 'success', 'message' => 'Data Tersimpan', 'id' => $id]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            return Response::json(['status' => 'error', 'message' => 'Error Hubungi Mas Rizal Taufiq']);
        }

        // if($req->verificationPrice == 'N'){
        // echo 'menjurnal';

        // }
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Membuat Dana Kredit Pagu per PDL'
        // );
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(4, 'edit');
        if ($checkRoles == 'akses ditolak') {
            return view('forbidden');
        }
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.servicePayment.editServicePayment', ['Service' => $Service, 'member' => $member]);
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

    //     return Redirect::route('servicePaymenServicePayment')
    //         ->with([
    //             'status' => 'Berhasil merubah Dana Kredit',
    //             'type' => 'success'
    //         ]);
    // }

    public function destroy(Request $req, $id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(4, 'delete');
        if ($checkRoles == 'akses ditolak') {
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }
        DB::beginTransaction();
        try {
            $this->DashboardController->createLog($req->header('user-agent'), $req->ip(), 'Menghapus Data Kredit');
            $checkServicePayment = DB::table('service_payment')
                ->where('id', $id)
                ->first();
            $checkService = Service::where('id', $checkServicePayment->service_id)->first();
            $checkJournals = DB::table('journals')
                ->where('ref', $checkServicePayment->code)
                ->get();
            if ($checkServicePayment->type == 'Lunas') {
                $checkServicePaymentDP = DB::table('service_payment')
                    ->where('service_id', $checkService->id)
                    ->where('type', 'DownPayment')
                    ->first();
                if ($checkServicePaymentDP != null) {
                    Service::where('id', $checkService->id)->update([
                        'payment_status' => 'DownPayment',
                        'payment_date' => null,
                        'total_payment' => 0,
                    ]);
                } else {
                    Service::where('id', $checkService->id)->update([
                        'payment_status' => null,
                        'payment_date' => null,
                        'total_payment' => 0,
                    ]);
                }
            } else {
                $checkServicePaymentLunas = DB::table('service_payment')
                    ->where('service_id', $checkService->id)
                    ->where('type', 'Lunas')
                    ->first();
                if ($checkServicePaymentLunas != null) {
                    return Response::json(['status' => 'error', 'message' => 'Data Lunas Harus Dihapus Baru menghapus Data DP']);
                }

                Service::where('id', $checkService->id)->update([
                    'payment_status' => null,
                    'downpayment_date' => null,
                    'total_downpayment' => 0,
                ]);
            }

            DB::table('service_payment')
                ->where('id', $id)
                ->delete();
            if (isset($checkJournals)) {
                if ($checkServicePayment->type == 'Lunas') {
                    DB::table('journals')
                        ->where('id', $checkJournals[0]->id)
                        ->delete();
                    
                    
                    DB::table('journal_details')
                        ->where('journal_id', $checkJournals[0]->id)
                        ->delete();
                        if (isset($checkJournals[1])) {
                        DB::table('journals')
                        ->where('id', $checkJournals[1]->id)
                        ->delete();
                        DB::table('journal_details')
                        ->where('journal_id', $checkJournals[1]->id)
                        ->delete();
                    }
                } else {
                    DB::table('journals')
                        ->where('id', $checkJournals[0]->id)
                        ->delete();
                    DB::table('journal_details')
                        ->where('journal_id', $checkJournals[0]->id)
                        ->delete();
                }
            }

            DB::commit();
            return Response::json(['status' => 'success', 'message' => 'Data Terhapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            // return$th;
            return Response::json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function serviceCheckJournals(Request $req)
    {
        $data = Journal::with('JournalDetail.AccountData')
            ->where('ref', $req->id)
            ->get();
        return Response::json(['status' => 'success', 'jurnal' => $data]);
    }
    public function printServicePayment($id)
    {
        $service = ServicePayment::with('Service', 'Service.ServiceDetail', 'Service.ServiceDetail.Items', 'Service.Employee1', 'Service.Employee2', 'Service.CreatedByUser', 'Service.Type', 'Service.Brand', 'Service.Brand.Category', 'Service.ServiceEquipment', 'Service.ServiceCondition', 'Service.Warrantys')->find($id);
        // return $Service;
        $member = User::get();
        return view('pages.backend.transaction.servicePayment.printServicePayment', ['service' => $service, 'member' => $member]);
    }
}
