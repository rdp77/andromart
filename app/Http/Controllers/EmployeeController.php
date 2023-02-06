<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Service;
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
        $checkRoles = $this->DashboardController->cekHakAkses(22,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        // $employee = Employee::where('id', '!=', '1')->where('status', 'aktif')->get();
        $employee = Employee::where('id', '!=', '1')
        ->orderBy('status', 'asc')
        ->orderBy('branch_id', 'asc')
        ->get();

        $totalSharingProfit = 0;
        $totalSharingProfitSplit = [];
        $totalServiceProgress = [];
        $totalServiceDone = [];
        $totalServiceCancel = [];

        for ($i=0; $i <count($employee) ; $i++) {
            $checkServiceStatus[$i] = Service::
            where('technician_id', $employee[$i]->id)
            ->get();
        }
        // return $checkServiceStatus;


        for ($i = 0; $i < count($employee); $i++) {

            $totalServiceProgress[$i] = 0;
            $totalServiceDone[$i] = 0;
            $totalServiceCancel[$i] = 0;
            $totalServiceFix[$i]['progress'] = 0;
            $totalServiceFix[$i]['done'] = 0;
            $totalServiceFix[$i]['cancel'] = 0;
            $totalServiceFix[$i]['nama'] = $employee[$i]->name;



            for ($j = 0; $j < count($checkServiceStatus[$i]); $j++) {
                if ($checkServiceStatus[$i][$j]->work_status == 'Proses' || $checkServiceStatus[$i][$j]->work_status == 'Mutasi' || $checkServiceStatus[$i][$j]->work_status == 'Manifest') {
                    $totalServiceProgress[$i] += 1;
                    $totalServiceFix[$i]['progress'] += 1;
                }
                if ($checkServiceStatus[$i][$j]->work_status == 'Selesai' || $checkServiceStatus[$i][$j]->work_status == 'Diambil') {
                    $totalServiceDone[$i] += 1;
                    $totalServiceFix[$i]['done'] += 1;
                }
                if ($checkServiceStatus[$i][$j]->work_status == 'Cancel' || $checkServiceStatus[$i][$j]->work_status == 'Return') {
                    $totalServiceCancel[$i] += 1;
                    $totalServiceFix[$i]['cancel'] += 1;
                }
            }
        }
        // return $employee;
        return view('pages.backend.master.employee.indexEmployee', compact('employee','totalServiceProgress','totalServiceDone','totalServiceCancel'));
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(22,'create');
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
        $checkRoles = $this->DashboardController->cekHakAkses(22,'edit');
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
            // $image = $req->image;
            // $image = str_replace('data:image/jpeg;base64,', '', $image);
            // $image = base64_decode($image);
            // if ($image != null) {
            //     $fileSave = 'public/Service_' . $avatar->code . '.' . 'png';
            //     $fileName = 'Service_' . $checkData->code . '.' . 'png';
            //     Storage::put($fileSave, $image);
            // } else {
            //     $fileName = $checkData->image;
            // }
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
                    'limit' => $req->limit,
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
                    'limit' => $req->limit,
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
        $checkRoles = $this->DashboardController->cekHakAkses(22,'delete');

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
