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
use App\Models\ServiceReturn;
use App\Models\SettingPresentase;
use App\Models\ServiceReturnDetail;
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

class ServiceReturnController extends Controller
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
        if ($req->ajax()) {
        $data = ServiceReturn::with(['Service','ServiceDetail','user'])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    // $actionBtn .= '<a onclick="reset(' . $row->id . ')" class="btn btn-primary text-white" style="cursor:pointer;">Reset Password</a>';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('service-payment.edit', $row->id) . '"><i class="far fa-edit"></i> Edit</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('service.printServiceReturn', $row->id) . '"><i class="fas fa-print"></i> Print</a>';
                    // $actionBtn .= '<a class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    $actionBtn .= '<a onclick="jurnal(' ."'". $row->code ."'". ')" class="dropdown-item" style="cursor:pointer;"><i class="fas fa-file-alt"></i> Jurnal</a>';
                    
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('dateData', function ($row){
                    return Carbon::parse($row->date)->locale('id')->isoFormat('LL');
                })
                ->addColumn('totalValue', function ($row){
                    return number_format($row->total,0,".",",");
                })

                ->addColumn('informationService', function ($row) {
                    if($row->Service->work_status == 'Proses'){
                        $work_status = '<div class="badge badge-warning">Proses Pengerjaan</div>';
                    }elseif($row->Service->work_status == 'Mutasi'){
                        $work_status = '<div class="badge badge-warning">Perpindahan Teknisi</div>';
                    }elseif($row->Service->work_status == 'Selesai'){
                        $work_status = '<div class="badge badge-success">Selesai</div>';
                    }elseif($row->Service->work_status == 'Batal'){
                        $work_status = '<div class="badge badge-danger">Service Batal</div>';
                    }elseif($row->Service->work_status == 'Manifest'){
                        $work_status = '<div class="badge badge-primary">Barang Diterima</div>';
                    }elseif($row->Service->work_status == 'Diambil'){
                        $work_status = '<div class="badge badge-success">Sudah Diambil</div>';
                    }

                    if($row->Service->payment_status == 'Lunas'){
                        $paymentStatus = '<div class="badge badge-success">Lunas</div>';
                    }elseif($row->Service->payment_status == 'DownPayment'){
                        $paymentStatus = '<div class="badge badge-warning">Bayar DP</div>';
                    }elseif($row->Service->payment_status == null){
                        $paymentStatus = '<div class="badge badge-danger">Belum Bayar</div>';
                    }

                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Kode Service</td>';
                    $htmlAdd .=      '<th>'.$row->Service->code.'</th>';
                    $htmlAdd .=      '<td>Tgl Service</td>';
                    $htmlAdd .=      '<th>'.Carbon::parse($row->Service->date)->locale('id')->isoFormat('LL').'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>status bayar</td>';
                    $htmlAdd .=      '<th>'.$paymentStatus.'</th>';
                    $htmlAdd .=      '<td>status kerja</td>';
                    $htmlAdd .=      '<th>'.$work_status.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>'.number_format($row->Service->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;

                })

                ->rawColumns(['action','informationService','currentStatus'])
                ->make(true);
        }
        return view('pages.backend.transaction.service_return.indexServiceReturn');
    }

    public function code($type,$id)
    {
        $getEmployee =  Employee::with('branch')->where('user_id',Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = str_pad($id, 3, '0', STR_PAD_LEFT);
        return $code = $type.$getEmployee->Branch->code.$year . $month . $index;
    }
    public function codeJournals($type,$id)
    {
        $getEmployee =  Employee::with('branch')->where('user_id',Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = str_pad($id, 3, '0', STR_PAD_LEFT);
        return $code = $type.$getEmployee->Branch->code.$year . $month . $index;
    }
    public function create()
    {
        $id = DB::table('service_payment')->max('id')+1;
        $code   = $this->code('BYR',$id);
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $items  = Item::where('name','!=','Jasa Service')->get();
        $account  = AccountData::with('AccountMain','AccountMainDetail','Branch')->get();
        $data = Service::with('ServiceDetail','Brand','Type','Employee1')->get();
        return view('pages.backend.transaction.service_return.createServiceReturn',compact('employee','code','items','data','account'));
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            // return $req->all();
            $dateConvert = $this->DashboardController->changeMonthIdToEn($req->date);
            $id = DB::table('service_return')->max('id')+1;
            $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
            $kode = $this->code('RTNS',$id);
            $checkService = Service::where('id',$req->serviceId)->first();
            
            ServiceReturn::create([
                'id' =>$id,
                'code' =>$kode,
                'user_id'=>Auth::user()->id,
                'service_id'=>$req->serviceId,
                'date'=>$dateConvert,
                'total'=>str_replace(",", '',$req->totalPayment),
                'type'=>$req->type,
                'description'=>$req->description,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);

            Service::where('id',$req->serviceId)->update([
                'work_status'=>$req->type,
            ]);

            for ($i=0; $i <count($req->itemsDetail) ; $i++) {
                ServiceReturnDetail::create([
                    'service_id'=>$req->serviceId,
                    'item_id'=>$req->itemsDetail[$i],
                    'price'=>str_replace(",", '',$req->priceDetail[$i]),
                    'qty'=>$req->qtyDetail[$i],
                    'total_price'=>str_replace(",", '',$req->totalPriceDetail[$i]),
                    'description' =>str_replace(",", '',$req->descriptionDetail[$i]),
                    'type' =>$req->typeDetail[$i],
                    'treatment' =>$req->perlakuan[$i],
                    'created_by'=>Auth::user()->name,
                    'created_at'=>date('Y-m-d h:i:s'),
                ]);
            }
          
            
            $indexSSM = ServiceStatusMutation::where('service_id', $req->serviceId)->count()+1;
            ServiceStatusMutation::create([
                'service_id'=>$req->serviceId,
                'technician_id'=>$checkService->technician_id,
                'index'=>$indexSSM,
                'status'=>$req->type,
                'description'=>$req->type .' Service' ,
                'created_by'=>Auth::user()->name,
                'created_at'=>date('Y-m-d h:i:s'),
            ]);
            
            // DB::rollback();
            // return 'asd';
            // penjurnalan
            if($req->totalService != 0){
                $idJournal = DB::table('journals')->max('id')+1;
                Journal::create([
                    'id' =>$idJournal,
                    'code'=>$this->code('KK',$idJournal),
                    'year'=>date('Y'),
                    'date'=>date('Y-m-d'),
                    'type'=>$req->type.' Service',
                    'total'=>str_replace(",", '',$req->totalService),
                    'ref'=>$kode,
                    'description'=>$req->description,
                    'created_at'=>date('Y-m-d h:i:s'),
                ]);
                $accountReturn  = AccountData::where('branch_id',$getEmployee->branch_id)
                                    ->where('active','Y')
                                    ->where('main_id',6)
                                    ->where('main_detail_id',7)
                                    ->first();
                if($accountReturn == null){
                    DB::rollback();
                    return Response::json(['status' => 'error','message'=>'Akun Return Service Dimuka Kosong']);
                }
                $accountKas  = AccountData::where('branch_id',$getEmployee->branch_id)
                                    ->where('active','Y')
                                    ->where('main_id',1)
                                    ->where('main_detail_id',1)
                                    ->first();
                if($accountKas == null){
                    DB::rollback();
                    return Response::json(['status' => 'error','message'=>'Akun Kas Detail Kosong']);
                }
                $accountCodeReturnJasa = [
                    $accountReturn->id,
                    $accountKas->id,
                ];  
                $totalBayarReturnJasa = [
                    str_replace(",", '',$req->totalService),
                    str_replace(",", '',$req->totalService),
                ];
                $descriptionReturnJasa = [
                    $req->description,
                    $req->description,
                ];
                $DKReturnJasa = [
                    'D',
                    'K',
                ];
                // return [
                // $accountCodeReturnJasa,
                // $totalBayarReturnJasa,
                // $descriptionReturnJasa,
                // $DKReturnJasa];

                for ($i=0; $i <count($accountCodeReturnJasa) ; $i++) {
                    $idDetail = DB::table('journal_details')->max('id')+1;
                    JournalDetail::create([
                        'id'=>$idDetail,
                        'journal_id'=>$idJournal,
                        'account_id'=>$accountCodeReturnJasa[$i],
                        'total'=>$totalBayarReturnJasa[$i],
                        'description'=>$descriptionReturnJasa[$i],
                        'debet_kredit'=>$DKReturnJasa[$i],
                        'created_at'=>date('Y-m-d h:i:s'),
                        'updated_at'=>date('Y-m-d h:i:s'),
                    ]);
                }
            }

            // total uang masuk stock
            $totalUangMasukStock = 0;
            for ($i=0; $i <count($req->perlakuan) ; $i++) { 
                if($req->perlakuan[$i] != '-' && $req->perlakuan[$i] == 'Masuk Stock'){
                    $totalUangMasukStock += $req->priceDetail[$i];
                }
            }
            // return $totalUangMasukStock;

            if($totalUangMasukStock != 0){
                $idJournal = DB::table('journals')->max('id')+1;
                Journal::create([
                    'id' =>$idJournal,
                    'code'=>$this->code('DD',$idJournal),
                    'year'=>date('Y'),
                    'date'=>date('Y-m-d'),
                    'type'=>'Pengembalian Barang Ke Stock Dari '.$req->type.' Service',
                    'total'=>$totalUangMasukStock,
                    'ref'=>$kode,
                    'description'=>$req->description,
                    'created_at'=>date('Y-m-d h:i:s'),
                ]);

                $accountReturn  = AccountData::where('branch_id',$getEmployee->branch_id)
                                ->where('active','Y')
                                ->where('main_id',6)
                                ->where('main_detail_id',7)
                                ->first();

                if($accountReturn == null){
                    DB::rollback();
                    return Response::json(['status' => 'error','message'=>'Akun Return Service Kosong']);
                }


                $accountInventaris  = AccountData::where('branch_id',$getEmployee->branch_id)
                                    ->where('active','Y')
                                    ->where('main_id',3)
                                    ->where('main_detail_id',8)
                                    ->first();

                if($accountInventaris == null){
                    DB::rollback();
                    return Response::json(['status' => 'error','message'=>'Akun Kas Detail Kosong']);
                }

                $accountCodeMasukStock = [
                    $accountInventaris->id,
                    $accountReturn->id,
                ];  
                $totalBayarMasukStock = [
                    $totalUangMasukStock,
                    $totalUangMasukStock,
                ];
                $descriptionMasukStock = [
                    $req->description,
                    $req->description,
                ];
                $DKMasukStock = [
                    'D',
                    'K',
                ];
                for ($i=0; $i <count($accountCodeMasukStock) ; $i++) {
                    $idDetail = DB::table('journal_details')->max('id')+1;
                    JournalDetail::create([
                        'id'=>$idDetail,
                        'journal_id'=>$idJournal,
                        'account_id'=>$accountCodeMasukStock[$i],
                        'total'=>$totalBayarMasukStock[$i],
                        'description'=>$descriptionMasukStock[$i],
                        'debet_kredit'=>$DKMasukStock[$i],
                        'created_at'=>date('Y-m-d h:i:s'),
                        'updated_at'=>date('Y-m-d h:i:s'),
                    ]);
                }
            }

            $totalUangBarangLoss = 0;
            for ($i=0; $i <count($req->perlakuan) ; $i++) { 
                if($req->perlakuan[$i] != '-'  && $req->perlakuan[$i] == 'Loss'){
                    $totalUangBarangLoss += $req->priceDetail[$i];
                }
            }

            if($totalUangBarangLoss != 0){
                $idJournal = DB::table('journals')->max('id')+1;
                Journal::create([
                    'id' =>$idJournal,
                    'code'=>$this->code('DD',$idJournal),
                    'year'=>date('Y'),
                    'date'=>date('Y-m-d'),
                    'type'=>'Barang Loss Dari '.$req->type.' Service',
                    'total'=>$totalUangBarangLoss,
                    'ref'=>$kode,
                    'description'=>$req->description,
                    'created_at'=>date('Y-m-d h:i:s'),
                ]);

                $accountReturn  = AccountData::where('branch_id',$getEmployee->branch_id)
                                ->where('active','Y')
                                ->where('main_id',6)
                                ->where('main_detail_id',7)
                                ->first();

                if($accountReturn == null){
                    DB::rollback();
                    return Response::json(['status' => 'error','message'=>'Akun Return Service Kosong']);
                }


                $accountSharingLossToko  = AccountData::where('branch_id',$getEmployee->branch_id)
                                    ->where('active','Y')
                                    ->where('main_id',6)
                                    ->where('main_detail_id',9)
                                    ->first();
                
                $accountSharingLossTeknisi  = AccountData::where('branch_id',$getEmployee->branch_id)
                                    ->where('active','Y')
                                    ->where('main_id',6)
                                    ->where('main_detail_id',10)
                                    ->first();

                if($accountInventaris == null){
                    DB::rollback();
                    return Response::json(['status' => 'error','message'=>'Akun Kas Detail Kosong']);
                }
                
                $settingPresentase =  SettingPresentase::get();

                // return $req->all();
                for ($i=0; $i <count($settingPresentase) ; $i++) {
                    if($settingPresentase[$i]->name == 'Presentase Loss Toko'){
                        $lossStore = $settingPresentase[$i]->total;
                    }
                    if($settingPresentase[$i]->name == 'Presentase Loss Teknisi'){
                        $lossTechnician = $settingPresentase[$i]->total;
                    }
                    if($settingPresentase[$i]->name == 'Presentase Loss Teknisi 1'){
                        $lossTechnician1 = $settingPresentase[$i]->total;
                    }
                    if($settingPresentase[$i]->name == 'Presentase Loss Teknisi 2'){
                        $lossTechnician2 = $settingPresentase[$i]->total;
                    }
                }

                $accountCodeBarangLoss = [
                    $accountSharingLossToko->id,
                    $accountSharingLossTeknisi->id,
                    $accountReturn->id,
                ];  
                $totalBayarBarangLoss = [
                    $lossStore/100*$totalUangBarangLoss,
                    $lossTechnician/100*$totalUangBarangLoss,
                    $totalUangBarangLoss,
                ];
                $descriptionBarangLoss = [
                    $req->description,
                    $req->description,
                    $req->description,
                ];
                $DKBarangLoss = [
                    'D',
                    'D',
                    'K',
                ];
                for ($i=0; $i <count($accountCodeBarangLoss) ; $i++) {
                    $idDetail = DB::table('journal_details')->max('id')+1;
                    JournalDetail::create([
                        'id'=>$idDetail,
                        'journal_id'=>$idJournal,
                        'account_id'=>$accountCodeBarangLoss[$i],
                        'total'=>$totalBayarBarangLoss[$i],
                        'description'=>$descriptionBarangLoss[$i],
                        'debet_kredit'=>$DKBarangLoss[$i],
                        'created_at'=>date('Y-m-d h:i:s'),
                        'updated_at'=>date('Y-m-d h:i:s'),
                    ]);
                }
            }

                
            // }
            
            DB::commit();
            return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return$th;
            return Response::json(['status' => 'error','message'=>'Error Hubungi Mas Rizal Taufiq']);
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
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service_return.editServiceReturn', ['Service' => $Service,'member'=>$member]);
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

    //     return Redirect::route('servicePaymenServiceReturn')
    //         ->with([
    //             'status' => 'Berhasil merubah Dana Kredit',
    //             'type' => 'success'
    //         ]);
    // }

    public function destroy(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $this->DashboardController->createLog(
                $req->header('user-agent'),
                $req->ip(),
                'Menghapus Data Kredit'
            );
            $checkServicePayment = DB::table('service_payment')->where('id',$id)->first();
            $checkService = Service::where('id',$checkServicePayment->service_id)->first();
            $checkJournals = DB::table('journals')->where('ref',$checkServicePayment->code)->first();
            if($checkServicePayment->type == 'Lunas'){
                $checkServicePaymentDP = DB::table('service_payment')
                                    ->where('service_id',$checkService->id)
                                    ->where('type', 'DownPayment')
                                    ->first();
                if($checkServicePaymentDP != null){
                    Service::where('id',$checkService->id)->update([
                        'payment_status'=>'DownPayment',
                        'payment_date'=>null,
                        'total_payment'=>0,
                    ]);
                }else{
                    Service::where('id',$checkService->id)->update([
                        'payment_status'=>null,
                        'payment_date'=>null,
                        'total_payment'=>0,
                    ]);
                }

            }else{

                $checkServicePaymentLunas = DB::table('service_payment')
                                    ->where('service_id',$checkService->id)
                                    ->where('type', 'Lunas')
                                    ->first();
                if($checkServicePaymentLunas != null){
                    return Response::json(['status' => 'error','message'=>'Data Lunas Harus Dihapus Baru menghapus Data DP']);
                }

                Service::where('id',$checkService->id)->update([
                    'payment_status'=>null,
                    'downpayment_date'=>null,
                    'total_downpayment'=>0,
                ]);
            }
        

            
            DB::table('service_payment')->where('id',$id)->delete();
            DB::table('journals')->where('id',$checkJournals->id)->delete();
            DB::table('journal_details')->where('journal_id',$checkJournals->id)->delete();
        
            DB::commit();
            return Response::json(['status' => 'success','message'=>'Data Terhapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            // return$th;
            return Response::json(['status' => 'error','message'=>$th]);
        }
    }

    public function serviceCheckJournals(Request $req)
    {
        $data = Journal::with('JournalDetail.AccountData')->where('ref',$req->id)->first();
        return Response::json(['status' => 'success','jurnal'=>$data]);
    }
    public function printServicePayment($id)
    {
        $service = ServiceReturn::with('Service','Service.ServiceDetail','Service.ServiceDetail.Items','Service.Employee1','Service.Employee2','Service.CreatedByUser','Service.Type','Service.Brand','Service.Brand.Category','Service.ServiceEquipment','Service.ServiceCondition')->find($id);
        // return $Service;
        $member = User::get();
        return view('pages.backend.transaction.service_return.printServiceReturn', ['service' => $service,'member'=>$member]);
    }
}
