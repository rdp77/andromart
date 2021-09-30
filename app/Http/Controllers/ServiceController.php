<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Brand;
use App\Models\StockMutation;
use App\Models\Employee;
use App\Models\Service;
use App\Models\ServiceEquipment;
use App\Models\ServiceCondition;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

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
        $data = Service::with(['Employee1','Employee2','CreatedByUser','Type','Brand'])->get();

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
                    }
                    $actionBtn .= '<a class="dropdown-item" href="' . route('service.printService', $row->id) . '"><i class="fas fa-print"></i> Cetak</a>';

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
                    $htmlAdd .=      '<th>'.$row->Brand->name.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Seri</td>';
                    $htmlAdd .=      '<th>'.$row->Type->name.'</th>';
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
        // $items    = Item::where('name','!=','Jasa Service')->get();
        $item     = Item::with('stock')->where('name','!=','Jasa Service')->get();
        $brand    = Brand::orderBy('name', 'ASC')->get();
        $type     = Type::orderBy('name', 'ASC')->get();
        $category = Category::get();
        $warranty = Warranty::get();
        return view('pages.backend.transaction.service.createService',compact('employee','code','item','brand','type','warranty','category'));
    }

    public function store(Request $req)
    {
        // return 
        // return [$req->bateraiEquipment,$req->ramEquipment];
        // return $req->all();
        DB::beginTransaction();
        try {
            // return $req->technicianId;
            $tech1 = Service::where('technician_id',$req->technicianId)->where('work_status','!=','Selesai')->where('work_status','!=','Diambil')->count();
            $tech2 = Service::where('technician_replacement_id',$req->technicianId)->where('work_status','!=','Selesai')->where('work_status','!=','Diambil')->count();


            $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
            $settingPresentase =  SettingPresentase::get();

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
                if($settingPresentase[$i]->name == 'Batasan Maximum Handle Customer Pada Teknisi'){
                    $MaxHandle = $settingPresentase[$i]->total;
                }
            }
            if($req->technicianId != 1 || $req->technicianId != '1'){
                if($tech1+$tech2 >= $MaxHandle){
                    return Response::json(['status' => 'fail',
                                           'message'=>'Teknisi Memiliki '+$MaxHandle+' Pekerjaan Belum Selesai']);
                }
            }
            
            // return [$sharingProfitStore,
            // $sharingProfitTechnician,
            // $lossStore,$lossTechnician];
            // return [$req->totalService,$req->totalSparePart];
            $id = DB::table('service')->max('id')+1;
            $sharing_profit_store =  (((str_replace(",", '',$req->totalService)- str_replace(",", '',$req->totalDiscountValue))/100)*$sharingProfitStore)+str_replace(",", '',$req->totalSparePart);
            $sharing_profit_technician_1 = ((str_replace(",", '',$req->totalService) - str_replace(",", '',$req->totalDiscountValue))/100)*$sharingProfitTechnician;

            $total_loss_technician_1 = (str_replace(",", '',$req->totalLoss)/100)*$lossTechnician;
            $total_loss_store = (str_replace(",", '',$req->totalLoss)/100)*$lossStore;

            $estimateDate = $this->DashboardController->changeMonthIdToEn($req->estimateDate);

            $image = $req->image;
            $image = str_replace('data:image/jpeg;base64,','', $image);
            $image = base64_decode($image);
            if ($image != null) {
                $fileSave = 'public/Service_' . $this->code('SRV-') . '.' .'png';
                $fileName = 'Service_' . $this->code('SRV-') . '.' .'png';
                Storage::put($fileSave, $image);
            }else{
                $fileName = null;
            }
            // return 'asd';
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
                'estimate_day'=>$estimateDay,
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
                'image'=>$fileName,
                'discount_type'=>$req->typeDiscount,
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
            ]);
            $checkStock = [];
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
                if($req->typeDetail[$i] != 'Jasa'){
                    $checkStock[$i] = Stock::where('item_id',$req->itemsDetail[$i])
                                ->where('branch_id',$getEmployee->branch_id)
                                ->where('id','!=',1)
                                ->get();
                    if($checkStock[$i][0]->stock < $req->qtyDetail[$i]){
                        return Response::json(['status' => 'fail',
                                        'message'=>'Stock Item Ada yang 0. Harap Cek Kembali']);
                    }
                    if($req->typeDetail[$i] == 'SparePart'){
                        $desc[$i] = 'Pengeluaran Barang Pada Service '.$this->code('SRV-');
                    }else{
                        $desc[$i] = 'Pengeluaran Barang Loss Pada Service '.$this->code('SRV-');
                    }
                    Stock::where('item_id',$req->itemsDetail[$i])
                    ->where('branch_id',Auth::user()->id)->update([
                        'stock'      =>$checkStock[$i][0]->stock-$req->qtyDetail[$i],
                    ]);
                    StockMutation::create([
                        'item_id'    =>$req->itemsDetail[$i],
                        'unit_id'    =>$checkStock[$i][0]->unit_id,
                        'branch_id'  =>$checkStock[$i][0]->branch_id,
                        'qty'        =>$req->qtyDetail[$i],
                        'code'       =>$this->code('SRV-'),
                        'type'       =>'Out',
                        'description'=>$desc[$i],
                    ]);
                }
            }
            // return $checkStock;

            ServiceStatusMutation::create([
                'service_id'=>$id,
                'technician_id'=>$req->technicianId,
                'index'=>1,
                'status'=>'Manifest',
                'description'=>'Barang Sedang Dicek & Diterima oleh '.Auth::user()->name,
                'created_by'=>Auth::user()->name,
                'created_at'=>date('Y-m-d h:i:s'),
            ]);

            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'LCD',
                'status'=>$req->LcdCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Camera Depan',
                'status'=>$req->cameraDepanCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Camera Belakang',
                'status'=>$req->cameraBelakangCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Buzzer',
                'status'=>$req->buzzerCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Charger',
                'status'=>$req->chargerCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Mic',
                'status'=>$req->micCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Speaker',
                'status'=>$req->speakerCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Touch Screen',
                'status'=>$req->touchScreenCondition,
            ]);
            ServiceCondition::create([
                'service_id'=>$id,
                'name'=>'Vibrator',
                'status'=>$req->vibratorCondition,
            ]);
            $dataEquipment = [];

            if($req->laptopPcEquipment == 'on'){
                $dataEquipment[0] = 'Y';
                $dataEquipmentName[0] = 'Laptop / PC';
                $dataEquipmentDesc[0] = $req->laptopPcEquipmentDesc;
            }else{
                $dataEquipment[0] = 'N';
                $dataEquipmentName[0] = 'Laptop / PC';
                $dataEquipmentDesc[0] = $req->laptopPcEquipmentDesc;
            }
            if($req->chargerEquipment == 'on'){
                $dataEquipment[1] = 'Y';
                $dataEquipmentName[1] = 'Charger';
                $dataEquipmentDesc[1] = $req->chargerEquipmentDesc;
            }else{
                $dataEquipment[1] = 'N';
                $dataEquipmentName[1] = 'Charger';
                $dataEquipmentDesc[1] = $req->chargerEquipmentDesc;
            }
            if($req->bateraiEquipment == 'on'){
                $dataEquipment[2] = 'Y';
                $dataEquipmentName[2] = 'Baterai';
                $dataEquipmentDesc[2] = $req->bateraiEquipmentDesc;
            }else{
                $dataEquipment[2] = 'N';
                $dataEquipmentName[2] = 'Baterai';
                $dataEquipmentDesc[2] = $req->bateraiEquipmentDesc;
            }
            if($req->hardiskSsdEquipment == 'on'){
                $dataEquipment[3] = 'Y';
                $dataEquipmentName[3] = 'Hardisk / SSD';
                $dataEquipmentDesc[3] = $req->hardiskSsdEquipmentDesc;
            }else{
                $dataEquipment[3] = 'N';
                $dataEquipmentName[3] = 'Hardisk / SSD';
                $dataEquipmentDesc[3] = $req->hardiskSsdEquipmentDesc;
            }
            if($req->RamEquipment == 'on'){
                $dataEquipment[4] = 'Y';
                $dataEquipmentName[4] = 'Ram';
                $dataEquipmentDesc[4] = $req->RamEquipmentDesc;
            }else{
                $dataEquipment[4] = 'N';
                $dataEquipmentName[4] = 'Ram';
                $dataEquipmentDesc[4] = $req->RamEquipmentDesc;
            }
            if($req->HandphoneEquipment == 'on'){
                $dataEquipment[5] = 'Y';
                $dataEquipmentName[5] = 'Handphone';
                $dataEquipmentDesc[5] = $req->HandphoneEquipmentDesc;
            }else{
                $dataEquipment[5] = 'N';
                $dataEquipmentName[5] = 'Handphone';
                $dataEquipmentDesc[5] = $req->HandphoneEquipmentDesc;
            }
            if($req->printerEquipment == 'on'){
                $dataEquipment[6] = 'Y';
                $dataEquipmentName[6] = 'Printer';
                $dataEquipmentDesc[6] = $req->printerEquipmentDesc;
            }else{
                $dataEquipment[6] = 'N';
                $dataEquipmentName[6] = 'Printer';
                $dataEquipmentDesc[6] = $req->printerEquipmentDesc;
            }
            if($req->tasLaptopEquipment == 'on'){
                $dataEquipment[7] = 'Y';
                $dataEquipmentName[7] = 'Tas Laptop';
                $dataEquipmentDesc[7] = $req->tasLaptopEquipmentDesc;
            }else{
                $dataEquipment[7] = 'N';
                $dataEquipmentName[7] = 'Tas Laptop';
                $dataEquipmentDesc[7] = $req->tasLaptopEquipmentDesc;
            }
            // return [$dataEquipment,$dataEquipmentName];
            for ($i=0; $i <count($dataEquipment) ; $i++) { 
                ServiceEquipment::create([
                    'service_id'=>$id,
                    'name'=>$dataEquipmentName[$i],
                    'status'=>$dataEquipment[$i],
                    'description'=>$dataEquipmentDesc[$i],
                ]);
            }
            
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Charger',
            //     'status'=>$req->laptopPcEquipment,
            // ]);
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Baterai',
            //     'status'=>$req->bateraiEquipment,
            // ]);
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Hardisk / SSD',
            //     'status'=>$req->hardiskSsdEquipment,
            // ]);
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Ram',
            //     'status'=>$req->RamEquipment,
            // ]);
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Handphone',
            //     'status'=>$req->HandphoneEquipment,
            // ]);
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Printer',
            //     'status'=>$req->printerEquipment,
            // ]);
            // ServiceEquipment::create([
            //     'service_id'=>$id,
            //     'name'=>'Tas Laptop',
            //     'status'=>$req->tasLaptopEquipment,
            // ]);
            // if($req->verificationPrice == 'N'){
            //     echo 'menjurnal';

            // }
            // $this->DashboardController->createLog(
            //     $req->header('user-agent'),
            //     $req->ip(),
            //     'Membuat Dana Kredit Pagu per PDL'
            // );
            DB::commit();
            return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return$th;
            return Response::json(['status' => 'error','message'=>$th]);
        }


    }

    public function edit($id)
    {
        $service  = Service::with('ServiceDetail')->find($id);
        $member   = User::get();
        $employee = Employee::get();
        $category = Category::get();
        $brand    = Brand::get();
        $type     = Type::get();
        $warranty = Warranty::get();
        $item     = Item::with('stock')->where('name','!=','Jasa Service')->get();
        return view('pages.backend.transaction.service.editService',compact('employee','item','brand','type','warranty','service','category'));
    }
    public function printService($id)
    {
        $Service = Service::with('ServiceDetail','ServiceDetail.Items','Employee1','Employee2','CreatedByUser','Type','Brand','Brand.Category')->find($id);
        // return $Service;
        $member = User::get();
        return view('pages.backend.transaction.service.printService', ['service' => $Service,'member'=>$member]);
    }

    public function update($id, Request $req)
    {
        // return $req->all();
        DB::beginTransaction();
        try {
            $tech1 = Service::where('technician_id',$req->technicianId)->where('work_status','!=','Selesai')->count();
            $tech2 = Service::where('technician_replacement_id',$req->technicianId)->where('work_status','!=','Selesai')->count();


            $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
            $settingPresentase =  SettingPresentase::get();
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
                if($settingPresentase[$i]->name == 'Batasan Maximum Handle Customer Pada Teknisi'){
                    $MaxHandle = $settingPresentase[$i]->total;
                }
            }

            if($tech1+$tech2 >= $MaxHandle){
                return Response::json(['status' => 'fail',
                                       'message'=>'Teknisi Memiliki '+$MaxHandle+' Pekerjaan Belum Selesai']);
            }
            // return [$sharingProfitStore,
            // $sharingProfitTechnician,
            // $lossStore,$lossTechnician];
            // return [$req->totalService,$req->totalSparePart];
            // return $req->all();
            $checkData = Service::where('id',$id)->first();

            // $id = DB::table('service')->max('id')+1;
            // $sharing_profit_store =  ((str_replace(",", '',$req->totalService)/100)*$sharingProfitStore)+str_replace(",", '',$req->totalSparePart);
            // $sharing_profit_technician_1 = (str_replace(",", '',$req->totalService)/100)*$sharingProfitTechnician;

            if(str_replace(",", '',$req->totalLoss) == 0){
                $total_loss_store =0;
                $total_loss_technician_1 = 0;
                $total_loss_technician_2 = 0;
            }else{
                $total_loss_store = (str_replace(",", '',$req->totalLoss)/100)*$lossStore;
                if($checkData->technician_replacement_id != null){
                    $total_loss_technician_1 = $lossTechnician1/100*(str_replace(",", '',$req->totalLoss));
                    $total_loss_technician_2 = $lossTechnician2/100*(str_replace(",", '',$req->totalLoss));

                }else{
                    $total_loss_technician_1 = $lossTechnician/100*(str_replace(",", '',$req->totalLoss));
                    $total_loss_technician_2 = 0;
                }
            }

            $sharing_profit_store =  (((str_replace(",", '',$req->totalService)-str_replace(",", '',$req->totalDiscountValue))/100)*$sharingProfitStore)+str_replace(",", '',$req->totalSparePart);

            if($checkData->technician_replacement_id != null){
                $sharing_profit_technician_1 = $sharingProfitTechnician1/100*(str_replace(",", '',$req->totalService) - str_replace(",", '',$req->totalDiscountValue));
                $sharing_profit_technician_2 = $sharingProfitTechnician2/100*(str_replace(",", '',$req->totalService) - str_replace(",", '',$req->totalDiscountValue));
            }else{
                $sharing_profit_technician_1 = $sharingProfitTechnician/100*(str_replace(",", '',$req->totalService) - str_replace(",", '',$req->totalDiscountValue));
                $sharing_profit_technician_2 = 0;
            }

            $estimateDate = $this->DashboardController->changeMonthIdToEn($req->estimateDate);

            $image = $req->image;
            $image = str_replace('data:image/jpeg;base64,','', $image);
            $image = base64_decode($image);
            if ($image != null) {
                $fileSave = 'public/Service_' . $checkData->code . '.' .'png';
                $fileName = 'Service_' . $checkData->code . '.' .'png';
                Storage::put($fileSave, $image);
            }else{
                $fileName = $checkData->image;
            }
            // return 'asd';
            Service::where('id',$id)->update([
                // 'id' =>$id,
                // 'code' =>$this->code('SRV-'),
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
                // 'total_payment'=>0,
                // 'total_downpayment'=>0,
                'total_loss'=>str_replace(",", '',$req->totalLoss),
                'total_loss_technician_1'=>$total_loss_technician_1,
                'total_loss_technician_2'=>$total_loss_technician_2,
                'total_loss_store'=>$total_loss_store,
                'image'=>$fileName,
                'discount_type'=>$req->typeDiscount,
                'discount_price'=>str_replace(",", '',$req->totalDiscountValue),
                'discount_percent'=>str_replace(",", '',$req->totalDiscountPercent),
                'total_price'=>str_replace(",", '',$req->totalPrice),
                // 'work_status'=>'Manifest',
                'equipment'=>$req->equipment,
                'description'=>$req->description,
                'warranty_id'=>$req->warranty,
                'verification_price'=>$req->verificationPrice,
                'technician_id'=>$req->technicianId,
                'sharing_profit_store'=>str_replace(",", '',$sharing_profit_store),
                'sharing_profit_technician_1'=>$sharing_profit_technician_1,
                'sharing_profit_technician_2'=>$sharing_profit_technician_2,
                'updated_at' =>date('Y-m-d h:i:s'),
                'updated_by' => Auth::user()->name,
            ]);

            // check data yang dihapus dan mengembalikan stock terlebih dahulu
            if($req->deletedExistingData != null){
                $checkDataDeleted = ServiceDetail::whereIn('id',$req->deletedExistingData)->get();
                $checkStockDeleted = [];
                for ($i=0; $i <count($checkDataDeleted) ; $i++) {
                    $checkStockDeleted[$i] = Stock::where('item_id',$checkDataDeleted[$i]->item_id)
                                                ->where('branch_id',$getEmployee->branch_id)
                                                ->where('id','!=',1)
                                                ->get();

                    if($checkDataDeleted[$i]->type == 'SparePart'){
                        $desc[$i] = '(Update Service) Pengembalian Barang Pada Service '.$req->code;
                    }else{
                        $desc[$i] = '(Update Service) Pengembalian Barang Loss Pada Service '.$req->code;
                    }
                    // return $desc;
                    Stock::where('item_id',$checkDataDeleted[$i]->item_id)
                    ->where('branch_id',$getEmployee->branch_id)->update([
                        'stock'      =>$checkStockDeleted[$i][0]->stock+$checkDataDeleted[$i]->qty,
                    ]);
                    StockMutation::create([
                        'item_id'    =>$checkDataDeleted[$i]->item_id,
                        'unit_id'    =>$checkStockDeleted[$i][0]->unit_id,
                        'branch_id'  =>$checkStockDeleted[$i][0]->branch_id,
                        'qty'        =>$checkDataDeleted[$i]->qty,
                        'code'       =>$req->code,
                        'type'       =>'In',
                        'description'=>$desc[$i],
                    ]);
                }
                $destroyExistingData = DB::table('service_detail')->whereIn('id',$req->deletedExistingData)->delete();
            }

            // menyimpan data baru dan memperbaru stock
            if($req->itemsDetail != null){
                $checkStock = [];
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
                    if($req->typeDetail[$i] != 'Jasa'){
                        $checkStock[$i] = Stock::where('item_id',$req->itemsDetail[$i])
                                    ->where('branch_id',$getEmployee->branch_id)
                                    ->where('id','!=',1)
                                    ->get();
                        if($checkStock[$i][0]->stock < $req->qtyDetail[$i]){
                            return Response::json(['status' => 'fail',
                                            'message'=>'Stock Item Ada yang 0. Harap Cek Kembali']);
                        }
                        if($req->typeDetail[$i] == 'SparePart'){
                            $desc[$i] = '(Update Service) Pengeluaran Barang Pada Service '.$req->code;
                        }else{
                            $desc[$i] = '(Update Service) Pengeluaran Barang Loss Pada Service '.$req->code;
                        }
                        Stock::where('item_id',$req->itemsDetail[$i])
                        ->where('branch_id',$getEmployee->branch_id)->update([
                            'stock'      =>$checkStock[$i][0]->stock-$req->qtyDetail[$i],
                        ]);
                        StockMutation::create([
                            'item_id'    =>$req->itemsDetail[$i],
                            'unit_id'    =>$checkStock[$i][0]->unit_id,
                            'branch_id'  =>$checkStock[$i][0]->branch_id,
                            'qty'        =>$req->qtyDetail[$i],
                            'code'       =>$req->code,
                            'type'       =>'Out',
                            'description'=>$desc[$i],
                        ]);
                    }
                }
            }

            // mengecek data existing 
            if($req->itemsDetailOld != null){
            // return $req->all();
                // mengecek data existing 
                $checkDataOld = ServiceDetail::whereIn('id',$req->idDetailOld)->get();
                $checkStockExisting = [];
                    
                for ($i=0; $i <count($checkDataOld) ; $i++) {
                    // memfilter type kecuali jasa
                    if($checkDataOld[$i]->item_id != 1){
                        // return$checkDataOld[$i];
                        if($req->typeDetailOld[$i] != 'Jasa'){
                            $checkStockExisting[$i] = Stock::where('item_id',$req->itemsDetailOld[$i])
                                        ->where('branch_id',$getEmployee->branch_id)
                                        ->where('id','!=',1)
                                        ->get();
                            
                            $checkStockExistingOlder[$i] = Stock::where('item_id',$checkDataOld[$i]->item_id)
                                        ->where('branch_id',$getEmployee->branch_id)
                                        ->where('id','!=',1)
                                        ->get();
                            // if($checkStockExisting[$i][0]->stock < ($req->qtyDetailOld[$i])){
                            //     return Response::json(['status' => 'fail',
                            //                     'message'=>'Stock Item Ada yang 0. Harap Cek Kembali']);
                            // }
                            // return 'masuk 1';
                            // mengecek kembali jika data item sama dengan data yang ada di service_detail
                            if($checkDataOld[$i]->item_id == $req->itemsDetailOld[$i]){
                            // return 'masuk 2.1';
                            // mengecek kembali jika data QTY sama dengan data yang ada di service_detail
                                if($checkDataOld[$i]->qty == $req->qtyDetailOld[$i]){
                                    // return 'masuk 3.1';
                                    // jika qty di service_detail sama dengan QTY yang akan di update
                                    if($checkDataOld[$i]->type == $req->typeDetailOld[$i]){
                                        // return 'masuk 4.1';
                                        // Jika Type sama maka tidak perlu melakukan update stock mutasi
                                    }else{
                                        // Jika Type berbeda maka perlu melakukan update stock mutasi dengan type yaitu MUTATION
                                        // return 'masuk 4.2';
                                        $desc[$i] = '(Update Service) Perubahan Barang dari '.$checkDataOld[$i]->type.' Menjadi '.$req->typeDetailOld[$i].' Pada Service '.$req->code;

                                        StockMutation::create([
                                            'item_id'    =>$req->itemsDetailOld[$i],
                                            'unit_id'    =>$checkStockExisting[$i][0]->unit_id,
                                            'branch_id'  =>$checkStockExisting[$i][0]->branch_id,
                                            'qty'        =>$req->qtyDetailOld[$i],
                                            'code'       =>$req->code,
                                            'type'       =>'Mutation',
                                            'description'=>$desc[$i],
                                        ]);
                                    }
                                    // mengupdate service detail jika item sama + qty sama + perubahan tipe sparepart / loss
                                    ServiceDetail::where('id',$req->idDetailOld[$i])->update([
                                        // 'service_id'=>$id,
                                        // 'item_id'=>$req->itemsDetailOld[$i],
                                        'price'=>str_replace(",", '',$req->priceDetailOld[$i]),
                                        // 'qty'=>$req->qtyDetailOld[$i],
                                        'total_price'=>str_replace(",", '',$req->totalPriceDetailOld[$i]),
                                        'description' =>str_replace(",", '',$req->descriptionDetailOld[$i]),
                                        'type' =>$req->typeDetailOld[$i],
                                        'updated_by'=>Auth::user()->name,
                                        'updated_at'=>date('Y-m-d h:i:s'),
                                    ]);
                                    
                                }else{
                                    // return 'masuk 3.2';
                                    // jika qty di service_detail berbeda dengan QTY yang akan di update
                                    // return $checkDataOld;
                                    if($req->typeDetailOld[$i] == 'SparePart'){
                                        $descPengembalian[$i] = '(Update Service) Pengembalian Barang Pada Service '.$req->code;
                                    }else{
                                        $descPengembalian[$i] = '(Update Service) Pengembalian Barang Loss Pada Service '.$req->code;
                                    }
                                    StockMutation::create([
                                        'item_id'    =>$req->itemsDetailOld[$i],
                                        'unit_id'    =>$checkStockExisting[$i][0]->unit_id,
                                        'branch_id'  =>$checkStockExisting[$i][0]->branch_id,
                                        'qty'        =>$checkDataOld[$i]->qty,
                                        'code'       =>$req->code,
                                        'type'       =>'In',
                                        'description'=>$descPengembalian[$i],
                                    ]);

                                    // Pegeluaran atas data item yang dirubah
                                    if($req->typeDetailOld[$i] == 'SparePart'){
                                        $descPengeluaran[$i] = '(Update Service) Pengeluaran Barang Pada Service '.$req->code;
                                    }else{
                                        $descPengeluaran[$i] = '(Update Service) Pengeluaran Barang Loss Pada Service '.$req->code;
                                    }
                                    StockMutation::create([
                                        'item_id'    =>$req->itemsDetailOld[$i],
                                        'unit_id'    =>$checkStockExisting[$i][0]->unit_id,
                                        'branch_id'  =>$checkStockExisting[$i][0]->branch_id,
                                        'qty'        =>$req->qtyDetailOld[$i],
                                        'code'       =>$req->code,
                                        'type'       =>'Out',
                                        'description'=>$descPengeluaran[$i],
                                    ]);
                                    
                                    Stock::where('item_id',$checkDataOld[$i]->item_id)
                                    ->where('branch_id',$getEmployee->branch_id)->update([
                                        'stock'      =>$checkStockExisting[$i][0]->stock+$checkDataOld[$i]->qty-$req->qtyDetailOld[$i],
                                    ]);

                                    ServiceDetail::where('id',$req->idDetailOld[$i])->update([
                                        // 'service_id'=>$id,
                                        // 'item_id'=>$req->itemsDetailOld[$i],
                                        'price'=>str_replace(",", '',$req->priceDetailOld[$i]),
                                        'qty'=>$req->qtyDetailOld[$i],
                                        'total_price'=>str_replace(",", '',$req->totalPriceDetailOld[$i]),
                                        'description' =>str_replace(",", '',$req->descriptionDetailOld[$i]),
                                        'type' =>$req->typeDetailOld[$i],
                                        'updated_by'=>Auth::user()->name,
                                        'updated_at'=>date('Y-m-d h:i:s'),
                                    ]);
                                }
                            }else{
                                // return 'masuk 2.2';
                                // pengembalian stock atas item service_detail yang dirubah
                        
                                if($checkStockExistingOlder[$i][0]->item_id == $checkDataOld[$i]->item_id){
                                    Stock::where('item_id',$checkDataOld[$i]->item_id)
                                            ->where('branch_id',$getEmployee->branch_id)->update([
                                                'stock'      =>$checkStockExistingOlder[$i][0]->stock+$checkDataOld[$i]->qty,
                                            ]);
                                }
                            
                                if($checkDataOld[$i]->type == 'SparePart'){
                                    $descPengembalian[$i] = '(Update Service) Pengembalian Barang Pada Service '.$req->code;
                                }else{
                                    $descPengembalian[$i] = '(Update Service) Pengembalian Barang Loss Pada Service '.$req->code;
                                }
                                StockMutation::create([
                                    'item_id'    =>$checkDataOld[$i]->item_id,
                                    'unit_id'    =>$checkStockExisting[$i][0]->unit_id,
                                    'branch_id'  =>$checkStockExisting[$i][0]->branch_id,
                                    'qty'        =>$checkDataOld[$i]->qty,
                                    'code'       =>$req->code,
                                    'type'       =>'In',
                                    'description'=>$descPengembalian[$i],
                                ]);

                                // Pegeluaran atas data item yang dirubah
                                if($req->typeDetailOld[$i] == 'SparePart'){
                                    $descPengeluaran[$i] = '(Update Service) Pengeluaran Barang Pada Service '.$req->code;
                                }else{
                                    $descPengeluaran[$i] = '(Update Service) Pengeluaran Barang Loss Pada Service '.$req->code;
                                }
                                Stock::where('item_id',$req->itemsDetailOld[$i])
                                ->where('branch_id',$getEmployee->branch_id)->update([
                                    'stock'      =>$checkStockExisting[$i][0]->stock-$req->qtyDetailOld[$i],
                                ]);
                                StockMutation::create([
                                    'item_id'    =>$req->itemsDetailOld[$i],
                                    'unit_id'    =>$checkStockExisting[$i][0]->unit_id,
                                    'branch_id'  =>$checkStockExisting[$i][0]->branch_id,
                                    'qty'        =>$req->qtyDetailOld[$i],
                                    'code'       =>$req->code,
                                    'type'       =>'Out',
                                    'description'=>$descPengeluaran[$i],
                                ]);

                                ServiceDetail::where('id',$req->idDetailOld[$i])->update([
                                    // 'service_id'=>$id,
                                    'item_id'=>$req->itemsDetailOld[$i],
                                    'price'=>str_replace(",", '',$req->priceDetailOld[$i]),
                                    'qty'=>$req->qtyDetailOld[$i],
                                    'total_price'=>str_replace(",", '',$req->totalPriceDetailOld[$i]),
                                    'description' =>str_replace(",", '',$req->descriptionDetailOld[$i]),
                                    'type' =>$req->typeDetailOld[$i],
                                    'updated_by'=>Auth::user()->name,
                                    'updated_at'=>date('Y-m-d h:i:s'),
                                ]);

                            }
                        }
                    }
                }
                ServiceDetail::where('id',$req->idDetailOld[0])->update([
                    // 'service_id'=>$id,
                    'item_id'=>$req->itemsDetailOld[0],
                    'price'=>str_replace(",", '',$req->priceDetailOld[0]),
                    'qty'=>$req->qtyDetailOld[0],
                    'total_price'=>str_replace(",", '',$req->totalPriceDetailOld[0]),
                    'description' =>str_replace(",", '',$req->descriptionDetailOld[0]),
                    'type' =>$req->typeDetailOld[0],
                    'updated_by'=>Auth::user()->name,
                    'updated_at'=>date('Y-m-d h:i:s'),
                ]);
            }
            DB::commit();
            return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return$th;
            return Response::json(['status' => 'error','message'=>$th]);
        }
    }

    public function destroy(Request $req, $id)
    {
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Menghapus Data Kredit'
        // );
        DB::beginTransaction();
        try {
                $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
                $checkDataDeleted = ServiceDetail::where('service_id',$id)->get();
                $checkStockDeleted = [];
                for ($i=0; $i <count($checkDataDeleted) ; $i++) {
                    $checkStockDeleted[$i] = Stock::where('item_id',$checkDataDeleted[$i]->item_id)
                                                ->where('branch_id',$getEmployee->branch_id)
                                                ->where('id','!=',1)
                                                ->get();

                    if($checkDataDeleted[$i]->type == 'SparePart'){
                        $desc[$i] = '(Update Service) Pengembalian Barang Pada Service '.$req->code;
                    }else{
                        $desc[$i] = '(Update Service) Pengembalian Barang Loss Pada Service '.$req->code;
                    }
                    // return $desc;
                    Stock::where('item_id',$checkDataDeleted[$i]->item_id)
                    ->where('branch_id',$getEmployee->branch_id)->update([
                        'stock'      =>$checkStockDeleted[$i][0]->stock+$checkDataDeleted[$i]->qty,
                    ]);
                    StockMutation::create([
                        'item_id'    =>$checkDataDeleted[$i]->item_id,
                        'unit_id'    =>$checkStockDeleted[$i][0]->unit_id,
                        'branch_id'  =>$checkStockDeleted[$i][0]->branch_id,
                        'qty'        =>$checkDataDeleted[$i]->qty,
                        'code'       =>$req->code,
                        'type'       =>'In',
                        'description'=>$desc[$i],
                    ]);
                }

            DB::table('service')->where('id',$id)->delete();
            DB::table('service_detail')->where('id',$id)->delete();
            DB::table('service_payment')->where('id',$id)->delete();
            DB::table('service_status_mutation')->where('id',$id)->delete();
            // Stock::where('item_id',$checkDataOld[$i]->item_id)
            //                                     ->where('branch_id',$getEmployee->branch_id)->update([
            //                                         'stock'      =>$checkStockExistingOlder[$i][0]->stock+$checkDataOld[$i]->qty,
            //                                     ]);

            // Service::where('id',$id)->destroy($id);
            // ServiceDetail::where('service_id',$id)->destroy($id);
            // ServicePayment::where('service_id',$id)->destroy($id);
            // ServiceMutation::where('service_id',$id)->destroy($id);
            return Response::json(['status' => 'success']);
            DB::commit();
            return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return$th;
            return Response::json(['status' => 'error','message'=>$th]);
        }
    }
    public function serviceFormUpdateStatus()
    {
        // where('technician_id',Auth::user()->id)->
        $data = Service::get();
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
