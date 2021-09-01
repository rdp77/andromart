<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Employee;
use App\Models\Service;
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
use DB;

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
        if ($req->ajax()) {
        $data = ServicePayment::with(['Service','ServiceDetail','user'])->get();
        
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
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
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
                ->addColumn('currentStatus', function ($row){
                    if($row->type == 'Lunas'){
                        return '<div class="badge badge-success">Lunas</div>';
                    }elseif($row->type == 'DownPayment'){
                        return '<div class="badge badge-warning">Bayar DP</div>';
                    }elseif($row->type == null){
                        return '<div class="badge badge-danger">Belum Bayar</div>';
                    }
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
        return view('pages.backend.transaction.servicePayment.indexServicePayment');
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
        $code   = $this->code('BYR-');
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $items  = Item::where('name','!=','Jasa Service')->get();
        $data = Service::where('technician_id',$employee->id)
        ->where(function ($query) {
            $query->where('payment_status','DownPayment');
            $query->orWhere('payment_status',null);                  
        })->get();
        return view('pages.backend.transaction.servicePayment.createServicePayment',compact('employee','code','items','data'));
    }

    public function store(Request $req)
    {
        
        // return $req->all();
        $dateConvert = $this->DashboardController->changeMonthIdToEn($req->date);
        $id = DB::table('service_payment')->max('id')+1;

        ServicePayment::create([
            'id' =>$id,
            'code' =>$req->code,
            'user_id'=>Auth::user()->id,
            'service_id'=>$req->serviceId,
            'date'=>$dateConvert,
            'total'=>str_replace(",", '',$req->totalPayment),
            'type'=>$req->type,
            'description'=>$req->description,
            'created_by' => Auth::user()->name,
            'created_at' => date('Y-m-d h:i:s'),
        ]);
        if($req->type == 'DownPayment'){
            Service::where('id',$req->serviceId)->update([
                'payment_status'=>$req->type,
                'downpayment_date'=>$dateConvert,
                'total_downpayment'=>str_replace(",", '',$req->totalPayment),
            ]);
        }else{
            Service::where('id',$req->serviceId)->update([
                'payment_status'=>$req->type,
                'payment_date'=>$dateConvert,
                'total_payment'=>str_replace(",", '',$req->totalPayment),
            ]);
        }
        


        // if($req->verificationPrice == 'N'){
            // echo 'menjurnal';

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
        return view('pages.backend.transaction.servicePayment.editServicePayment', ['Service' => $Service,'member'=>$member]);
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
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Kredit'
        );
        Service::destroy($id);
        ServiceDetail::where('service_id',$id)->destroy($id);
        return Response::json(['status' => 'success']);
    }
}
