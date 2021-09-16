<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $req)
    {
        if ($req->ajax()) {
            // $data = User::where('id', '!=', Auth::user()->id)->get();;
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<a onclick="reset(' . $row->id . ')" class="btn btn-primary text-white" style="cursor:pointer;">Reset Password</a>';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('users.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.users.indexUsers');
    }

    public function create()
    {
        return view('pages.backend.users.createUsers');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        User::create([
            'name' => $req->name,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat user baru'
        );

        return Redirect::route('users.index')
            ->with([
                'status' => 'Berhasil membuat user baru',
                'type' => 'success'
            ]);
    }

    public function showUser()
    {
        $user = User::find(Auth::user()->id);
        return view('pages.backend.users.showUsers', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.backend.users.updateUsers', ['user' => $user]);
    }

    public function update($id, Request $req)
    {
        if ($req->identity == User::find($id)->employee->identity) {
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

        if ($req->hasFile('avatar')) {
            $req->file('avatar')->move('assetsmaster/avatar/',$req->file('avatar')->getClientOriginalName());
            Employee::where('id', User::find($id)->employee->id)
            ->update([
                'identity' => $req->identity,
                'name' => $req->name,
                'birthday' => $birthday,
                'contact' => $req->contact,
                'gender' => $req->gender,
                'address' => $req->address,
                'avatar' => $req->file('avatar')->getClientOriginalName(),
                'updated_by' => Auth::user()->name,
            ]);
        }
        else {
            Employee::where('id', User::find($id)->employee->id)
            ->update([
                'identity' => $req->identity,
                'name' => $req->name,
                'birthday' => $birthday,
                'contact' => $req->contact,
                'gender' => $req->gender,
                'address' => $req->address,
                'updated_by' => Auth::user()->name,
            ]);
        }

        User::where('id', $id)
            ->update([
                'name' => $req->name,
            ]);

        $user = User::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah user ' . User::find($id)->name
        );

        $user->save();

        return Redirect::route('showUser')
            ->with([
                'status' => 'Berhasil mengubah data user',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus user ' . User::find($id)->name
        );

        User::destroy($id);

        return Response::json(['status' => 'success']);

        // return Redirect::route('users.index')
        //     ->with([
        //         'status' => 'Berhasil menghapus user',
        //         'type' => 'success'
        //     ]);
    }

    function reset($id, Request $req)
    {
        User::where('id', $id)
            ->update([
                'password' => Hash::make(1234567890),
            ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Reset password user ' . User::find($id)->name
        );

        return Redirect::route('users.index')
            ->with([
                'status' => 'Password untuk user ' . User::find($id)->name . ' telah diganti menjadi \'1234567890\'',
                'type' => 'success'
            ]);
    }

    public function changeName(Request $req)
    {
        $this->validate($req, [
            'name' => ['required', 'string', 'max:255']
        ]);

        $user = User::find(Auth::user()->id);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengganti nama ' . $user->name . ' menjadi ' . $req->name
        );

        $oldName = $user->name;
        $user->name = $req->name;
        $user->save();

        return Redirect::route('dashboard')
            ->with([
                'status' => 'Nama berhasil diganti dari ' . $oldName . ' menjadi ' . $req->name,
                'type' => 'success'
            ]);
    }

    public function changePassword()
    {
        return view('auth.forgot-password');
    }
}
