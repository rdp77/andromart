<?php

namespace App\Http\Controllers;

use App\Models\AccountMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class AccountMainController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = AccountMain::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('account-main.edit', $row->id) . '">Edit</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.accountMain.indexAccountMain');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        return view('pages.backend.master.accountMain.createAccountMain');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255', 'unique:account_main'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        AccountMain::create([
            'code' => $req->code,
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master akun dasar baru'
        );

        return Redirect::route('account-main.index')
            ->with([
                'status' => 'Berhasil membuat master akun dasar baru',
                'type' => 'success'
            ]);
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $accountMain = AccountMain::find($id);
        return view('pages.backend.master.accountMain.updateAccountMain', ['accountMain' => $accountMain]);
    }

    public function update(Request $req, $id)
    {
        if ($req->code == AccountMain::find($id)->code) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        } else {
            Validator::make($req->all(), [
                'code' => ['required', 'string', 'max:255', 'unique:account_main'],
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        AccountMain::where('id', $id)
            ->update([
                'code' => $req->code,
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $accountMain = AccountMain::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master akun dasar ' . AccountMain::find($id)->name
        );

        $accountMain->save();

        return Redirect::route('account-main.index')
            ->with([
                'status' => 'Berhasil merubah master akun dasar ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master akun dasar ' . AccountMain::find($id)->name
        );

        AccountMain::destroy($id);

        return Response::json(['status' => 'success']);
    }
}
