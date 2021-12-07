<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class EmployeeController extends Controller
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
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        $employee = Employee::where('id', '!=', '1')->get();
        return view('pages.backend.master.employee.indexEmployee', compact('employee'));
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $role = Role::get();
        $branch = Branch::get();
        return view('pages.backend.master.employee.createEmployee', compact('role', 'branch'));
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6',],
            'identity' => ['required', 'string', 'max:255', 'unique:employees'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer'],
            'level' => ['required', 'integer', 'max:5'],
        ])->validate();

        $user = new \App\Models\User;
        $user->role_id = $req->role_id;
        $user->name = $req->name;
        $user->username = $req->username;
        $user->password = Hash::make($req->password);
        $user->save();

        $birthday = $this->DashboardController->changeMonthIdToEn($req->birthday);

        Employee::create([
            'user_id' => $user->id,
            'branch_id' => $req->branch_id,
            'level' => $req->level,
            'identity' => $req->identity,
            'name' => $req->name,
            'birthday' => $birthday,
            'contact' => $req->contact,
            'gender' => $req->gender,
            'address' => $req->address,
            'status' => 'aktif',
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master karyawan baru'
        );

        return Redirect::route('employee.index')
            ->with([
                'status' => 'Berhasil membuat master karyawan baru',
                'type' => 'success'
            ]);
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $branch = Branch::where('id', '!=', Employee::find($id)->branch_id)->get();
        $employee = Employee::find($id);
        $role = Role::where('id', '!=', $employee->user->role_id)->get();

        return view('pages.backend.master.employee.updateEmployee', compact('branch', 'employee', 'role'));
    }

    public function update(Request $req, $id)
    {
        if ($req->identity == Employee::find($id)->identity) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255',],
                'role_id' => ['required', 'integer'],
                'level' => ['required', 'integer', 'max:5'],
            ])->validate();
        } else {
            Validator::make($req->all(), [
                'identity' => ['required', 'string', 'max:255', 'unique:employees'],
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255',],
                'role_id' => ['required', 'integer'],
                'level' => ['required', 'integer', 'max:5'],
            ])->validate();
        }

        $birthday = $this->DashboardController->changeMonthIdToEn($req->birthday);
        // return $req->file('avatar')->getClientOriginalName();
        if ($req->hasFile('avatar')) {
            $req->file('avatar')->move('assetsmaster/avatar/', $req->file('avatar')->getClientOriginalName());
            Employee::where('id', $id)
                ->update([
                    'avatar' => $req->file('avatar')->getClientOriginalName(),
                    'branch_id' => $req->branch_id,
                    'level' => $req->level,
                    'identity' => $req->identity,
                    'name' => $req->name,
                    'birthday' => $birthday,
                    'contact' => $req->contact,
                    'gender' => $req->gender,
                    'address' => $req->address,
                    'status' => $req->status,
                    'updated_by' => Auth::user()->name,
                ]);

            User::where('id', Employee::find($id)->user_id)
                ->update([
                    'name' => $req->name,
                    'role_id' => $req->role_id,
                ]);
        } else {
            Employee::where('id', $id)
                ->update([
                    'branch_id' => $req->branch_id,
                    'level' => $req->level,
                    'identity' => $req->identity,
                    'name' => $req->name,
                    'birthday' => $birthday,
                    'contact' => $req->contact,
                    'gender' => $req->gender,
                    'address' => $req->address,
                    'status' => $req->status,
                    'updated_by' => Auth::user()->name,
                ]);

            User::where('id', Employee::find($id)->user_id)
                ->update([
                    'name' => $req->name,
                    'role_id' => $req->role_id,
                ]);
        }

        $employee = Employee::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master karyawan ' . Employee::find($id)->name
        );

        $employee->save();

        return Redirect::route('employee.index')
            ->with([
                'status' => 'Berhasil merubah master karyawan ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'delete');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        $employee = Employee::find($id);
        $user = User::where('id', '=', $employee->user_id)->get();

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master karyawan ' . Employee::find($id)->name
        );

        Employee::destroy($id);
        User::destroy($user);

        return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
    }
}
