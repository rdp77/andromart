<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Warranty;
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

class SharingProfitController extends Controller
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
        $data = Service::where('technician_id',Auth::user()->id)->get();
        $employee = Employee::get();
        return view('pages.backend.finance.sharing_profit.sharingProfit',compact('data','employee'));
    }
    public function sharingProfitLoadDataService(Request $req)
    {
        // return $req->all();
        $data = Service::with(['ServiceDetail','ServiceDetail.Items','ServiceStatusMutation','ServiceStatusMutation.Technician'])
        ->whereBetween('date', [$this->DashboardController->changeMonthIdToEn($req->dateS), $this->DashboardController->changeMonthIdToEn($req->dateE)])
        ->where('work_status','Diambil')
        ->where(function ($query) use ($req) {
            $query->where('technician_id',$req->id)
                  ->orWhere('technician_replacement_id', $req->id);
        })
        ->get();

        if(count($data) == 0){
            $message = 'empty';
        }else{
            $message = 'exist';
        }

        return Response::json(['status' => 'success','result'=>$data,'message'=>$message]);
    }
    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('service')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$year . $month . $index;
    }

    public function store(Request $req)
    {
        $tech1 = Service::where('technician_id',$req->technicianId)->where('work_status','!=','Selesai')->count();
        $tech2 = Service::where('technician_replacement_id',$req->technicianId)->where('work_status','!=','Selesai')->count();
        if($tech1+$tech2 >= 10){
            return Response::json(['status' => 'fail','message'=>'Teknisi Memiliki 10 Pekerjaan Belum Selesai']);
        }

        $getEmployee =  Employee::where('user_id',Auth::user()->id)->first();
        
        // return $req->all();
        $id = DB::table('service')->max('id')+1;
        $sharing_profit_store = (str_replace(",", '',$req->totalPrice)/100)*60;
        $sharing_profit_technician_1 = (str_replace(",", '',$req->totalPrice)/100)*40;
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
            $index = ServiceStatusMutation::where('service_id', $req->id)->count()+1;
            if($req->status == 'Mutasi'){
                $technician_replacement_id = $req->technicianId;
            }else{
                $technician_replacement_id = null;
            }
            
            
            Service::where('id', $req->id)->update([
                'work_status'=>$req->status,
                'technician_replacement_id'=>$technician_replacement_id,
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
