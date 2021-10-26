<?php

namespace App\Http\Controllers;

use App\Models\AccountMain;
use App\Models\AccountMainDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class AccountMainDetailController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = AccountMainDetail::with('main')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('account-main-detail.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.accountMainDetail.indexAccountMainDetail');
    }

    public function create()
    {
        $main = AccountMain::get();
        return view('pages.backend.master.accountMainDetail.createAccountMainDetail', compact('main'));
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255'],
            'main_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        AccountMainDetail::create([
            'code' => $req->code,
            'main_id' => $req->main_id,
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master area baru'
        );

        return Redirect::route('account-main-detail.index')
            ->with([
                'status' => 'Berhasil membuat master akun detailbaru',
                'type' => 'success'
            ]);
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $detail = AccountMainDetail::find($id);
        $main = AccountMain::get();
        return view('pages.backend.master.accountMainDetail.updateAccountMainDetail', compact('main', 'detail'));
    }

    public function update(Request $req, $id)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255'],
            'main_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        AccountMainDetail::where('id', $id)
            ->update([
                'code' => $req->code,
                'main_id' => $req->main_id,
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $area = AccountMainDetail::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master akun detail' . AccountMainDetail::find($id)->name
        );

        $area->save();

        return Redirect::route('account-main-detail.index')
            ->with([
                'status' => 'Berhasil merubah master akun detail',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master akun detail' . AccountMainDetail::find($id)->name
        );

        AccountMainDetail::destroy($id);

        return Response::json(['status' => 'success']);
    }
}