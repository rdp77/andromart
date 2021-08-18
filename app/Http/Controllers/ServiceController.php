<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\ServiceDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

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
                            <a class="dropdown-item" href="' . route('service.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('totalValue', function ($row) {
                    return number_format($row->total,2,".",",");
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.transaction.service.indexService');
    }

    public function create()
    {
        $member = User::get();
        return view('pages.backend.transaction.service.createService',compact('member'));
    }

    public function store(Request $req)
    {
        
        // return $req->all();
        $id = Service::max('id')+1;
        Service::create([
            'id'         => $id,
            'sales_id'   => $req->salesId,
            'liquid_date'=> date('Y-m-d',strtotime($req->liquidDate)),
            'total'      => str_replace(",", '',$req->total),
            'created_by' => Auth::user()->name,
            'updated_by' => '',
            'accepted'   => 'no',
            'created_at' => date('Y-m-d h:i:s'),
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat Dana Kredit Pagu per PDL'
        );
        return Redirect::route('users.index')
            ->with([
                'status' => 'Berhasil membuat user baru',
                'type' => 'success'
            ]);
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
}
