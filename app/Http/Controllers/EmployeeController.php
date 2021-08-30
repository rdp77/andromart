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
        if ($req->ajax()) {
            $data = Employee::with('branch')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('employee.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.employee.indexEmployee');
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
            'contact' => ['required', 'string', 'max:13',],
        ])->validate();

        // User::create([
        //     'name' => $req->name,
        //     'username' => $req->username,
        //     'role_id' => '1',
        //     'password' => Hash::make($req->password),
        // ]);

        $user = new \App\Models\User;
        $user->role_id = '1';
        $user->name = $req->name;
        $user->username = $req->username;
        $user->password = Hash::make($req->password);
        $user->save();

        Employee::create([
            'user_id' => $user->id,
            'branch_id' => $req->branch_id,
            'level' => $req->level,
            'identity' => $req->identity,
            'name' => $req->name,
            'birthday' => $req->birthday,
            'contact' => $req->contact,
            'gender' => $req->gender,
            'address' => $req->address,
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

    public function edit(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
        //
    }

    public function destroy(Employee $employee)
    {
        //
    }
}
