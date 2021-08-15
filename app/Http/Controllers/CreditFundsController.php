<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Department;
use App\Models\CreditFunds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CreditFundsController extends Controller
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
            $data = CreditFunds::get();
        
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    // $actionBtn .= '<a onclick="reset(' . $row->id . ')" class="btn btn-primary text-white" style="cursor:pointer;">Reset Password</a>';
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
        return view('pages.backend.transaction.creditFunds.indexCreditFunds');
    }

    public function create()
    {
        $department = Department::where('name','like','%Sales%')->get();
        $departmentSales = [];
        for ($i=0; $i <count($department) ; $i++) { 
            $departmentSales[] = $department[$i]->id;
        }
        // return [$departmentSales];
        $member = Member::whereIn('department',$departmentSales)->get();
        return view('pages.backend.transaction.creditFunds.createCreditFunds',compact('member'));
    }

    public function store(Request $req)
    {
        
        // return $req->all();
        CreditFunds::create([
            'sales_id'   => $req->salesId,
            'liquid_date'=> date('Y-m-d',strtotime($req->liquidDate)),
            'total'      => $req->total,
            'created_by' => Auth::user()->name,
            'updated_by' => '',
            'accepted'   => 'no',
            'created_at' => date('Y-m-d h:i:s'),
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat Dana Kredit Pagu per PDL'
        );
        return Redirect::route('users.index')
            ->with([
                'status' => 'Berhasil membuat user baru',
                'type' => 'success'
            ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.backend.transaction.creditFunds.updateCreditFunds', ['user' => $user]);
    }

    public function update($id, Request $req)
    {
        User::where('id', $id)
            ->update([
                'name' => $req->name,
                'username' => $req->username
            ]);

        $user = User::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah user ' . User::find($id)->name
        );

        $user->save();

        return Redirect::route('users.index')
            ->with([
                'status' => 'Berhasil merubah user',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus Data Kredit'
        );

        CreditFunds::destroy($id);

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
