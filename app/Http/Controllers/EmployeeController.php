<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
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
        $employee = Employee::all();
        return view('pages.backend.master.employee.indexEmployee', compact('employee'));
    }

    public function create()
    {
        $branch = Branch::get();
        return view('pages.backend.master.employee.createEmployee', ['branch' => $branch]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6',],
            'identity' => ['required', 'string', 'max:255', 'unique:employees'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255',],
        ])->validate();

        $user = new \App\Models\User;
        $user->role_id = '1';
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
        $branch = Branch::where('id', '!=', Employee::find($id)->branch_id)->get();
        $employee = Employee::find($id);
        return view('pages.backend.master.employee.updateEmployee', ['employee' => $employee, 'branch' => $branch]);
    }

    public function update(Request $req, $id)
    {
        if ($req->identity == Employee::find($id)->identity) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255',],
            ])->validate();
        }
        else {
            Validator::make($req->all(), [
                'identity' => ['required', 'string', 'max:255', 'unique:employees'],
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255',],
            ])->validate();
        }

        $birthday = $this->DashboardController->changeMonthIdToEn($req->birthday);

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
                'updated_by' => Auth::user()->name,
            ]);

        User::where('id', Employee::find($id)->user_id)
            ->update([
                'name' => $req->name,
            ]);

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

    public function destroy(Employee $employee)
    {
        //
    }
}
