<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AccountMainDetail;
use App\Models\JournalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class AssetController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(53,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = Asset::with('AccountDepreciation','AccountAccumulation')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('asset.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('account_accumulation_rel', function ($row) {
                    return $row->AccountAccumulation->main->code.$row->AccountAccumulation->code.' <br> '.$row->AccountAccumulation->name;
                })
                ->addColumn('account_depreciation_rel', function ($row) {
                    return $row->AccountDepreciation->main->code.$row->AccountDepreciation->code.' <br> '.$row->AccountDepreciation->name;

                })
                ->rawColumns(['action','account_accumulation_rel','account_depreciation_rel'])
                ->make(true);
        }
        return view('pages.backend.master.asset.indexAsset');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(53,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $AccountMainDetail = AccountMainDetail::get();
        return view('pages.backend.master.asset.createAsset', compact('AccountMainDetail'));
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {

            Asset::create([
                'name' => $req->name,
                'account_depreciation_id' => $req->account_depreciation_id,
                'account_accumulation_id' => $req->account_accumulation_id,
                'description' => $req->description,
                'created_by' => Auth::user()->name,
            ]);

            $this->DashboardController->createLog(
                $req->header('user-agent'),
                $req->ip(),
                'Membuat master asset baru'
            );

            DB::commit();
            return Redirect::route('asset.index')
                ->with([
                    'status' => 'Berhasil membuat master asset',
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
        $checkRoles = $this->DashboardController->cekHakAkses(53,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $AccountMainDetail = AccountMainDetail::get();
        $data = Asset::find($id);


        return view('pages.backend.master.asset.updateAsset', compact('AccountMainDetail','data'));
    }

    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
        Asset::where('id', $id)
        ->update([
            'name' => $req->name,
            'account_depreciation_id' => $req->account_depreciation_id,
            'account_accumulation_id' => $req->account_accumulation_id,
            'description' => $req->description,
            'updated_by' => Auth::user()->name,
        ]);

        $Asset = Asset::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master asset ' . Asset::find($id)->name
        );
        $Asset->save();

    
        DB::commit();
        return Redirect::route('asset.index')
            ->with([
                'status' => 'Berhasil mengubah master asset',
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
        $checkRoles = $this->DashboardController->cekHakAkses(53,'delete');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        // $data = Asset::find($id);

        // $transaction = JournalDetail::where('account_id', '=', $data->account_depreciation_id)->get();
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
            'Menghapus master asset ' . Asset::find($id)->name
        );

        Asset::destroy($id);

        
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
