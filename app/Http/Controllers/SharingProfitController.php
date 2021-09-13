<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Warranty;
use App\Models\SharingProfit;
use App\Models\SharingProfitDetail;
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
        $data = Service::with(['ServiceDetail','ServiceDetail.Items','ServiceStatusMutation','ServiceStatusMutation.Technician','SharingProfitDetail','SharingProfitDetail.SharingProfit'])
        ->whereBetween('date', [$this->DashboardController->changeMonthIdToEn($req->dateS), $this->DashboardController->changeMonthIdToEn($req->dateE)])
        ->where('work_status','Diambil')
        ->where('payment_status','Lunas')
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
        // return $req->all();
        $checkData = SharingProfit::where('date_start',$this->DashboardController->changeMonthIdToEn($req->startDate))
                                  ->where('date_end',$this->DashboardController->changeMonthIdToEn($req->endDate))
                                  ->where('employe_id',$req->technicianId)
                                  ->get();
        if(count($checkData) != 0){
           return Response::json(['status' => 'fail','message'=>'Data Sudah Ada']);
        }
        $index = DB::table('sharing_profit')->max('id')+1;
        SharingProfit::create([
            'id'=>$index,
            'date'=>date('Y-m-d'),
            'date_start'=>$this->DashboardController->changeMonthIdToEn($req->startDate),
            'date_end'=>$this->DashboardController->changeMonthIdToEn($req->endDate),
            'employe_id'=>$req->technicianId,
            'total'=>$req->totalValue,
            'created_by'=>Auth::user()->name,
            'created_at'=>date('Y-m-d h:i:s'),
        ]);
        
        for ($i=0; $i <count($req->idDetail) ; $i++) {
            SharingProfitDetail::create([
                'id'=>$i+1,
                'sharing_profit_id'=>$index,
                'service_id'=>$req->idDetail[$i],
                'total'=>$req->totalDetail[$i],
                'created_by'=>Auth::user()->name,
                'created_at'=>date('Y-m-d h:i:s'),
            ]);
        }
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
