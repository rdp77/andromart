<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Warranty;
use App\Models\SettingPresentase;
use App\Models\ServiceDetail;
use App\Models\ServiceStatusMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;
// use DB;

class ServiceController extends Controller
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
        $data = Service::with(['Employee1','Employee2','CreatedByUser'])->get();
        
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    // $actionBtn .= '<a onclick="reset(' . $row->id . ')" class="btn btn-primary text-white" style="cursor:pointer;">Reset Password</a>';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button><div class="dropdown-menu">';
                    if($row->payment_status == null){
                        $actionBtn .= '<a class="dropdown-item" href="' . route('service.edit', $row->id) . '"><i class="far fa-edit"></i> Edit</a>';
                        $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                        $actionBtn .= '<a class="dropdown-item" href="' . route('service.printService', $row->id) . '"><i class="fas fa-print"></i> Cetak</a>';
                    }
                    
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('Informasi', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Kode</td>';
                    $htmlAdd .=      '<th>'.$row->code.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Tgl Dibuat</td>';
                    $htmlAdd .=      '<th>'.Carbon::parse($row->date)->locale('id')->isoFormat('LL').'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Di Input </td>';
                    $htmlAdd .=      '<th>'.$row->created_by.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Teknisi 1</td>';
                    $htmlAdd .=      '<th>'.$row->Employee1->name.'</th>';
                    $htmlAdd .=   '</tr>';
                    if($row->technician_replacement_id != null){
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<td>Teknisi 2</td>';
                        $htmlAdd .=      '<th>'.$row->Employee2->name.'</th>';
                        $htmlAdd .=   '</tr>';
                    }
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataCustomer', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_name.'</th>';
                    $htmlAdd .=   '</tr>';
                    // $htmlAdd .=   '<tr>';
                    // $htmlAdd .=      '<th>'.$row->customer_address.'</th>';
                    // $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_phone.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataItem', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Merk</td>';
                    $htmlAdd .=      '<th>'.$row->brand.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Seri</td>';
                    $htmlAdd .=      '<th>'.$row->series.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>tipe</td>';
                    $htmlAdd .=      '<th>'.$row->type.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>imei</td>';
                    $htmlAdd .=      '<th>'.$row->no_imei.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>rusak</td>';
                    $htmlAdd .=      '<th>'.$row->complaint.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('finance', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Service</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_service,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Toko</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sharing_profit_store,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Part</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_part,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Teknisi</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sharing_profit_technician_1,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Lalai</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_loss,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Teknisi 2</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sharing_profit_technician_2,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Diskon</td>';
                    $htmlAdd .=      '<th>'.number_format($row->discount_price,0,".",",").'</th>';
                    $htmlAdd .=      '<td>Loss Store</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_loss_store,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_price,0,".",",").'</th>';
                    $htmlAdd .=      '<td>Loss Teknisi</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_loss_technician_1,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=      '<td></td>';
                    $htmlAdd .=      '<th></th>';
                    $htmlAdd .=      '<td>Loss Teknisi 2</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_loss_technician_2,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;

                })
                ->addColumn('currentStatus', function ($row) {
                    if($row->work_status == 'Proses'){
                        $workStatus = '<div class="badge badge-warning">Proses Pengerjaan</div>';
                    }elseif($row->work_status == 'Mutasi'){
                        $workStatus = '<div class="badge badge-warning">Perpindahan Teknisi</div>';
                    }elseif($row->work_status == 'Selesai'){
                        $workStatus = '<div class="badge badge-success">Selesai</div>';
                    }elseif($row->work_status == 'Batal'){
                        $workStatus = '<div class="badge badge-danger">Service Batal</div>';
                    }elseif($row->work_status == 'Manifest'){
                        $workStatus = '<div class="badge badge-primary">Barang Diterima</div>';
                    }elseif($row->work_status == 'Diambil'){
                        $workStatus = '<div class="badge badge-success">Sudah Diambil</div>';
                    }

                    if($row->payment_status == 'Lunas'){
                        $paymentStatus = '<div class="badge badge-success">Lunas</div>';
                    }elseif($row->payment_status == 'DownPayment'){
                        $paymentStatus = '<div class="badge badge-warning">Bayar DP</div>';
                    }elseif($row->payment_status == null){
                        $paymentStatus = '<div class="badge badge-danger">Belum Bayar</div>';
                    }
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Status Pekerjaan</td>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$workStatus.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Status Pembayaran</td>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$paymentStatus.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                    
                })

                ->rawColumns(['action','dataItem','dataCustomer','finance','Informasi','currentStatus'])
                ->make(true);
        }
        return view('pages.backend.transaction.service.indexService');
    }

    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('service')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$year . $month . $index;
    }
    public function create()
    {
        $code     = $this->code('SRV-');
        $employee = Employee::get();
        $items    = Item::where('name','!=','Jasa Service')->get();
        $brand    = Brand::get();
        $type     = Type::get();
        $warranty = Warranty::get();
        return view('pages.backend.transaction.service.createService',compact('employee','code','items','brand','type','warranty'));
    }

    public function store(Request $req)
    {
        $tech1 = Service::where('technician_id',$req->technicianId)->where('work_status','!=','Selesai')->count();
        $tech2 = Service::where('technician_replacement_id',$req->technicianId)->where('work_status','!=','Selesai')->count();
        if($tech1+$tech2 >= 10){
            return Response::json(['status' => 'fail','message'=>'Teknisi Memiliki 10 Pekerjaan Belum Selesai']);
        }

        $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
        $settingPresentase =  SettingPresentase::get();
        
        // return $req->all();
        for ($i=0; $i <count($settingPresentase) ; $i++) { 
            if($settingPresentase[$i]->name == 'Presentase Sharing Profit Toko'){
                $sharingProfitStore = $settingPresentase[$i]->total;
            }
            if($settingPresentase[$i]->name == 'Presentase Sharing Profit Teknisi'){
                $sharingProfitTechnician = $settingPresentase[$i]->total;
            }
            if($settingPresentase[$i]->name == 'Presentase Loss Toko'){
                $lossStore = $settingPresentase[$i]->total;
            }
            if($settingPresentase[$i]->name == 'Presentase Loss Teknisi'){
                $lossTechnician = $settingPresentase[$i]->total;
            }
        }
        

        // return [$sharingProfitStore,
        // $sharingProfitTechnician,
        // $lossStore,$lossTechnician];
        $id = DB::table('service')->max('id')+1;
        $sharing_profit_store =  ((str_replace(",", '',$req->totalService)/100)*$sharingProfitStore)+str_replace(",", '',$req->totalSparePart);
        $sharing_profit_technician_1 = (str_replace(",", '',$req->totalService)/100)*$sharingProfitTechnician;

        $total_loss_technician_1 = (str_replace(",", '',$req->totalLoss)/100)*$lossTechnician;
        $total_loss_store = (str_replace(",", '',$req->totalLoss)/100)*$lossStore;
        
        $estimateDate = $this->DashboardController->changeMonthIdToEn($req->estimateDate);

        Service::create([
            'id' =>$id,
            'code' =>$this->code('SRV-'),
            'user_id'=>Auth::user()->id,
            'branch_id'=>$getEmployee->branch_id,
            'customer_id'=>$req->customerId,
            'customer_name'=>$req->customerName,
            'customer_address'=>$req->customerAdress,
            'customer_phone'=>$req->customerPhone,
            'date'=>date('Y-m-d'),
            'estimate_date'=>$estimateDate,
            'brand'=>$req->brand,
            'series'=>$req->series,
            'type'=>$req->type,
            'no_imei'=>$req->noImei,
            'complaint'=>$req->complaint,
            'clock'=>date('h:i'),
            'total_service'=>str_replace(",", '',$req->totalService),
            'total_part'=>str_replace(",", '',$req->totalSparePart),
            'total_payment'=>0,
            'total_downpayment'=>0,
            'total_loss'=>str_replace(",", '',$req->totalLoss),
            'total_loss_technician_1'=>$total_loss_technician_1,
            'total_loss_technician_2'=>0,
            'total_loss_store'=>$total_loss_store,
            'sharing_profit_status'=>'Belum',
            'discount_price'=>str_replace(",", '',$req->totalDiscountValue),
            'discount_percent'=>str_replace(",", '',$req->totalDiscountPercent),
            'total_price'=>str_replace(",", '',$req->totalPrice),
            'work_status'=>'Manifest',
            'equipment'=>$req->equipment,
            'description'=>$req->description,
            'warranty_id'=>$req->warranty,
            'verification_price'=>$req->verificationPrice,
            'technician_id'=>$req->technicianId,
            'sharing_profit_store'=>str_replace(",", '',$sharing_profit_store),
            'sharing_profit_technician_1'=>str_replace(",", '',$sharing_profit_technician_1),
            'sharing_profit_technician_2'=>str_replace(",", '',0),
            'created_at' =>date('Y-m-d h:i:s'),
            'created_by' => Auth::user()->name,
            'created_at' => date('Y-m-d h:i:s'),
        ]);

        for ($i=0; $i <count($req->itemsDetail) ; $i++) {
            ServiceDetail::create([
                'service_id'=>$id,
                'item_id'=>$req->itemsDetail[$i],
                'price'=>str_replace(",", '',$req->priceDetail[$i]),
                'qty'=>$req->qtyDetail[$i],
                'total_price'=>str_replace(",", '',$req->totalPriceDetail[$i]),
                'description' =>str_replace(",", '',$req->descriptionDetail[$i]),
                'type' =>$req->typeDetail[$i],
                'created_by'=>Auth::user()->name,
                'created_at'=>date('Y-m-d h:i:s'),
            ]);
        }

        ServiceStatusMutation::create([
            'service_id'=>$id,
            'technician_id'=>$req->technicianId,
            'index'=>1,
            'status'=>'Manifest',
            'description'=>'Barang Sedang Dicek & Diterima oleh '.Auth::user()->name,
            'created_by'=>Auth::user()->name,
            'created_at'=>date('Y-m-d h:i:s'),
        ]);

        // if($req->verificationPrice == 'N'){
        //     echo 'menjurnal';

        // }
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Membuat Dana Kredit Pagu per PDL'
        // );
        return Response::json(['status' => 'success','message'=>'Data Tersimpan']);

    }

    public function edit($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.editService', ['Service' => $Service,'member'=>$member]);
    }
    public function printService($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.printService', ['Service' => $Service,'member'=>$member]);
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

    //     return Redirect::route('service.index')
    //         ->with([
    //             'status' => 'Berhasil merubah Dana Kredit',
    //             'type' => 'success'
    //         ]);
    // }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Kredit'
        );
        ServiceDetail::where('service_id',$id)->destroy($id);
        return Response::json(['status' => 'success']);
    }
    public function serviceFormUpdateStatus()
    {
        $data = Service::where('technician_id',Auth::user()->id)->get();
        $employee = Employee::get();
        return view('pages.backend.transaction.service.indexFormUpdateService',compact('data','employee'));
    }
    public function serviceFormUpdateStatusLoadData(Request $req)
    {
        $data = Service::with(['ServiceDetail','ServiceDetail.Items','ServiceStatusMutation','ServiceStatusMutation.Technician'])->where('id',$req->id)->first();

        if($data == null){
            $message = 'empty';
        }else{  
            $message = 'exist';
        }

        return Response::json(['status' => 'success','result'=>$data,'message'=>$message]);
    }

    public function serviceFormUpdateStatusSaveData(Request $req)
    {
        try {
            // return $req->all();
            $checkData = Service::where('id',$req->id)->first();
            // return $checkData;
            $index = ServiceStatusMutation::where('service_id', $req->id)->count()+1;
            $settingPresentase =  SettingPresentase::get();
        
            // return $req->all();
            for ($i=0; $i <count($settingPresentase) ; $i++) { 
                if($settingPresentase[$i]->name == 'Presentase Sharing Profit Toko'){
                    $sharingProfitStore = $settingPresentase[$i]->total;
                }
                if($settingPresentase[$i]->name == 'Presentase Sharing Profit Teknisi'){
                    $sharingProfitTechnician = $settingPresentase[$i]->total;
                }
                if($settingPresentase[$i]->name == 'Presentase Sharing Profit Teknisi 1'){
                    $sharingProfitTechnician1 = $settingPresentase[$i]->total;
                }
                if($settingPresentase[$i]->name == 'Presentase Sharing Profit Teknisi 2'){
                    $sharingProfitTechnician2 = $settingPresentase[$i]->total;
                }
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
            if($req->status == 'Mutasi'){
                $technician_replacement_id = $req->technicianId;
                if($checkData->total_loss_store == 0){
                    $total_loss_technician_1 = 0;
                    $total_loss_technician_2 = 0;
                }else{
                    $total_loss_technician_1 = $lossTechnician1/100*$checkData->total_loss;
                    $total_loss_technician_2 = $lossTechnician2/100*$checkData->total_loss;
                }
                $sharing_profit_technician_1 = $sharingProfitTechnician1/100*$checkData->total_price;
                $sharing_profit_technician_2 = $sharingProfitTechnician2/100*$checkData->total_price;
            }else{
                if($checkData->technician_replacement_id != null){
                    $technician_replacement_id = $checkData->technician_replacement_id;
                    $total_loss_technician_1 = $checkData->total_loss_technician_1;
                    $total_loss_technician_2 = $checkData->total_loss_technician_2;
                    $sharing_profit_technician_1 =  $checkData->sharing_profit_technician_1;
                    $sharing_profit_technician_2 = $checkData->sharing_profit_technician_2; 
                }else{
                    $technician_replacement_id = null;
                    $total_loss_technician_1 = $checkData->total_loss_technician_1;
                    $total_loss_technician_2 = 0;
                    $sharing_profit_technician_1 =  $checkData->sharing_profit_technician_1;
                    $sharing_profit_technician_2 = 0; 
                }
                
            }
            
            
            Service::where('id', $req->id)->update([
                'work_status'=>$req->status,
                'technician_replacement_id'=>$technician_replacement_id,
                'total_loss_technician_1'=>$total_loss_technician_1,
                'total_loss_technician_2'=>$total_loss_technician_2,
                'sharing_profit_technician_1'=>$sharing_profit_technician_1,
                'sharing_profit_technician_2'=>$sharing_profit_technician_2,
            ]);
            ServiceStatusMutation::create([
                'service_id'=>$req->id,
                'technician_id'=>Auth::user()->id,
                'index'=>$index,
                'status'=>$req->status,
                'description'=>$req->description,
                'created_by'=>Auth::user()->name,
                'created_at'=>date('Y-m-d h:i:s'),
            ]);
            return Response::json(['status' => 'success','message'=>'Sukses Menyimpan Data']);
        } catch (\Throwable $th) {
            return Response::json(['status' => 'error','message'=>$th]);
        }
    }
}
