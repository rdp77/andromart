<?php

namespace App\Http\Controllers;

use App\Models\AccountData;
use App\Models\Branch;
use App\Models\Area;
use App\Models\AccountMain;
use App\Models\AccountMainDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class AccountDataController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(20,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = AccountData::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('account-data.edit', $row->id) . '">Edit</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.accountData.indexAccountData');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(20,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $AccountMain = AccountMain::get();
        $Branch = Branch::get();
        $AccountMainDetail = AccountMainDetail::get();
        return view('pages.backend.master.accountData.createAccountData', compact('AccountMain', 'AccountMainDetail', 'Branch'));
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {

            $AccountMainDetail = AccountMainDetail::where('id', $req->account_detail_id)->first();
            $AccountMain       = AccountMain::where('id', $AccountMainDetail->main_id)->first();
            $Branch            = Branch::where('id', $req->branch_id)->first();
            $Area              = Area::where('id', $Branch->area_id)->first();

            $code = $AccountMain->code . $AccountMainDetail->code . $Area->code . $Branch->code;


            $checkCode = AccountData::where('code', $code)->get();

            if(count($checkCode) != 0){
                return Response::json(['status' => 'fail','message'=>'Data Sudah Ada','result'=>$checkCode]);
            }

            $id = DB::table('account_data')->max('id') + 1;
            AccountData::create([
                'id' => $id,
                'code' => $code,
                'name' => $req->name,
                'area_id' => $Branch->area_id,
                'branch_id' => $req->branch_id,
                'debet_kredit' => $req->debet_kredit,
                'active' => $req->active,
                'account_type' => '-',
                'main_id' => $AccountMainDetail->main_id,
                'main_detail_id' => $req->account_detail_id,
                'opening_balance' => $req->opening_balance,
                'opening_date' => date('Y-m-d'),
                'created_by' => Auth::user()->name,
            ]);

            $this->DashboardController->createLog(
                $req->header('user-agent'),
                $req->ip(),
                'Membuat master area baru'
            );

            DB::commit();
            return Redirect::route('account-data.index')
                ->with([
                    'status' => 'Berhasil membuat master akun baru',
                    'type' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            //throw $th;
        }
    }

    public function show(Area $area)
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(20,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $area = Area::find($id);
        return view('pages.backend.master.accountData.updateAccountData', ['AccountData' => $area]);
    }

    public function update(Request $req, $id)
    {
        if ($req->code == Area::find($id)->code) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        } else {
            Validator::make($req->all(), [
                'code' => ['required', 'string', 'max:255', 'unique:areas'],
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        Area::where('id', $id)
            ->update([
                'code' => $req->code,
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $area = Area::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah masrter area ' . Area::find($id)->name
        );

        $area->save();

        return Redirect::route('area.index')
            ->with([
                'status' => 'Berhasil merubah master area ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master area ' . Area::find($id)->name
        );

        Area::destroy($id);

        return Response::json(['status' => 'success']);
    }
}
