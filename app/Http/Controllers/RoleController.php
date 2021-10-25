<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class RoleController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Role::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('role.edit', $row->id) . '">Edit</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.role.indexRole');
    }

    public function create()
    {
        return view('pages.backend.master.role.createRole');
    }

    public function store(Request $req)
    {
        Role::create([
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master role baru'
        );

        return Redirect::route('role.index')
            ->with([
                'status' => 'Berhasil membuat master role baru',
                'type' => 'success'
            ]);
    }

    public function show(role $role)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('pages.backend.master.role.updateRole', compact('role'));
    }

    public function update(Request $req, $id)
    {
        Role::where('id', $id)
            ->update([
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $role = Role::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah masrter role ' . Role::find($id)->name
        );

        $role->save();

        return Redirect::route('role.index')
            ->with([
                'status' => 'Berhasil merubah master role ',
                'type' => 'success'
            ]);
    }

    public function destroy(role $role)
    {
        //
    }
}