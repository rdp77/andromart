<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Employee;
use App\Models\Service;
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
use DB;

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
        $data = Service::get();
        
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
                            <a class="dropdown-item" href="' . route('service.edit', $row->id) . '"><i class="far fa-edit"></i> Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-trash-alt"></i> Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('dataDateOperator', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.Carbon::parse($row->date)->locale('id')->isoFormat('LL').'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->created_by.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';
                    
                    return $htmlAdd;
                })
                ->addColumn('dataCustomer', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_name.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>'.$row->customer_address.'</th>';
                    $htmlAdd .=   '</tr>';
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
                    $htmlAdd .=      '<th>'.number_format(60/100*$row->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Part</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_part,0,".",",").'</th>';
                    $htmlAdd .=      '<td>S.P Teknisi</td>';
                    $htmlAdd .=      '<th>'.number_format(40/100*$row->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Lalai</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_loss,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Diskon</td>';
                    $htmlAdd .=      '<th>'.number_format($row->discount_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>'.number_format($row->total_price,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;

                })
                ->addColumn('currentStatus', function ($row) {
                    if($row->work_status == 'Proses'){
                        return '<div class="badge badge-warning">Proses Pengerjaan</div>';
                    }elseif($row->work_status == 'Mutasi'){
                        return '<div class="badge badge-warning">Perpindahan Teknisi</div>';
                    }elseif($row->work_status == 'Selesai'){
                        return '<div class="badge badge-success">Selesai</div>';
                    }elseif($row->work_status == 'Batal'){
                        return '<div class="badge badge-danger">Service Batal</div>';
                    }elseif($row->work_status == 'Manifest'){
                        return '<div class="badge badge-primary">Barang Diterima</div>';
                    }
                })

                ->rawColumns(['action','dataItem','dataCustomer','finance','dataDateOperator','currentStatus'])
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
        $code   = $this->code('SRV-');
        $employee = Employee::get();
        $items  = Item::where('name','!=','Jasa Service')->get();
        return view('pages.backend.transaction.service.createService',compact('employee','code','items'));
    }

    public function store(Request $req)
    {
        
        // return $req->all();
        $id = DB::table('service')->max('id')+1;
        if($req->totalDownPayment == 0){
            $downpaymentDate = null;
        }else{
            $downpaymentDate = date('Y-m-d');
        }
        Service::create([
            'id' =>$id,
            'code' =>$this->code('SRV-'),
            'user_id'=>Auth::user()->id,
            'customer_id'=>$req->customerId,
            'customer_name'=>$req->customerName,
            'customer_address'=>$req->customerAdress,
            'customer_phone'=>$req->customerPhone,
            'date'=>date('Y-m-d'),
            'estimate_date'=>date('Y-m-d',strtotime($req->estimateDate)),
            'brand'=>$req->brand,
            'series'=>$req->series,
            'type'=>$req->type,
            'no_imei'=>$req->noImei,
            'complaint'=>$req->complaint,
            'clock'=>date('h:i'),
            'total_service'=>$req->totalService,
            'total_part'=>$req->totalSparePart,
            'total_downpayment'=>$req->totalDownPayment,
            'total_loss'=>$req->totalLoss,
            'discount_price'=>$req->totalDiscountValue,
            'discount_percent'=>$req->totalDiscountPercent,
            'total_price'=>$req->totalPrice,
            'downpayment_date'=>$downpaymentDate,
            'work_status'=>'Manifest',
            'equipment'=>$req->equipment,
            'description'=>$req->description,
            'done'=>'Belum',
            'warranty_id'=>$req->warranty,
            'verification_price'=>$req->verificationPrice,
            'technician_id'=>$req->technicianId,
            'created_at' =>date('Y-m-d h:i:s'),
            'created_by' => Auth::user()->name,
            'created_at' => date('Y-m-d h:i:s'),
        ]);

        for ($i=0; $i <count($req->itemsDetail) ; $i++) { 
            ServiceDetail::create([
                'service_id'=>$id, 
                'item_id'=>$req->itemsDetail[$i],
                'price'=>$req->priceDetail[$i],
                'qty'=>$req->qtyDetail[$i],
                'total_price'=>$req->totalPriceDetail[$i],
                'description' =>$req->descriptionDetail[$i],
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

        if($req->verificationPrice == 'N'){
            echo 'menjurnal';

        }
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Membuat Dana Kredit Pagu per PDL'
        // );
        return Response::json(['status' => 'success']);

    }

    public function edit($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.editService', ['Service' => $Service,'member'=>$member]);
    }

    public function update($id, Request $req)
    {
        
        Service::where('id', $id)
            ->update([
            'sales_id'   => $req->salesId,
            'liquid_date'=> date('Y-m-d',strtotime($req->liquidDate)),
            'total'      => str_replace(",", '',$req->total),
            'updated_by' => Auth::user()->name,
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

        $Service = Service::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah Service ' . Service::find($id)->name
        );

        $Service->save();

        return Redirect::route('service.index')
            ->with([
                'status' => 'Berhasil merubah Dana Kredit',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Kredit'
        );

        Service::destroy($id);

        return Response::json(['status' => 'success']);
    }
    public function serviceFormUpdateStatus()
    {
        $data = Service::where('technician_id',Auth::user()->id)->get();
        return view('pages.backend.transaction.service.indexFormUpdateService',compact('data'));
    }
    public function serviceFormUpdateStatusLoadData(Request $req)
    {
        $data = Service::with(['ServiceDetail','ServiceStatusMutation','ServiceStatusMutation.Technician'])
                        ->where('id',$req->id)->first();
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

            Service::where('id', $req->id)->update([
                'work_status'=>$req->status,
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
                //throw $th;
            return Response::json(['status' => 'error','message'=>$th]);
        }
        
    }
}
