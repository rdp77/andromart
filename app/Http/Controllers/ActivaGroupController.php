<?php

namespace App\Http\Controllers;

use App\Models\ActivaGroup;
use App\Models\AccountData;
use App\Models\JournalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ActivaGroupController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(54,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = ActivaGroup::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('activa-group.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.activaGroup.indexActivaGroup');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(54,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }
        return view('pages.backend.master.activaGroup.createActivaGroup');
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {

            ActivaGroup::create([
                'name' => $req->name,
                'estimate_age' => $req->estimate_age,
                'depreciation_rate' => $req->depreciation_rate,
                'created_by' => Auth::user()->name,
            ]);

            $this->DashboardController->createLog(
                $req->header('user-agent'),
                $req->ip(),
                'Membuat master golongan aktiva baru'
            );

            DB::commit();
            return Redirect::route('activa-group.index')
                ->with([
                    'status' => 'Berhasil membuat master golongan aktiva',
                    'type' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function show(Area $area)
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(54,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $AccountData = AccountData::get();
        $data = ActivaGroup::find($id);


        return view('pages.backend.master.activaGroup.updateActivaGroup', compact('AccountData','data'));
    }

    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
        ActivaGroup::where('id', $id)
            ->update([
                'name' => $req->name,
                'estimate_age' => $req->estimate_age,
                'depreciation_rate' => $req->depreciation_rate,
                'updated_by' => Auth::user()->name,
            ]);

        $Asset = ActivaGroup::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master golongan aktiva ' . ActivaGroup::find($id)->name
        );
        $Asset->save();

    
        DB::commit();
        return Redirect::route('activa-group.index')
            ->with([
                'status' => 'Berhasil mengubah master golongan aktiva',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function destroy(Request $req, $id)
    {
        DB::beginTransaction();
        try {
        $checkRoles = $this->DashboardController->cekHakAkses(54,'delete');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $data = ActivaGroup::find($id);

        // $transaction = JournalDetail::where('account_id', '=', $data->account_assessment_id)->get();
        // $transaction1 = JournalDetail::where('account_id', '=', $data->account_accumulation_id)->get();
        // $checkTransaction = count($transaction);
        // $checkTransaction1 = count($transaction1);
     
        // if ($checkTransaction > 0) {
        //     return Response::json([
        //         'status' => 'error',
        //         'message' => 'Data yang sudah di transaksikan tidak bisa dihapus !'
        //     ]);
        // } 
        // if ($checkTransaction1 > 0) {
        //     return Response::json([
        //         'status' => 'error',
        //         'message' => 'Data yang sudah di transaksikan tidak bisa dihapus !'
        //     ]);
        // } 

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master golongan aktiva ' . ActivaGroup::find($id)->name
        );

        ActivaGroup::destroy($id);

        
        DB::commit();
        return Response::json([
            'status' => 'success',
            'message' => 'Data master berhasil dihapus !'
        ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }
}
