<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class CustomerController extends Controller
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

        if ($req->ajax()) {
            $data = Customer::with('branch')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('customer.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.customer.indexCustomer');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $branch = Branch::all();
        return view('pages.backend.master.customer.createCustomer', ['branch' => $branch]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'branch_id' => ['required', 'integer'],
            'identity' => ['required', 'string', 'max:255', 'unique:customers'],
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ])->validate();

        Customer::create([
            'branch_id' => $req->branch_id,
            'identity' => $req->identity,
            'name' => $req->name,
            'contact' => $req->contact,
            'address' => $req->address,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master pelanggan baru'
        );

        return Redirect::route('customer.index')
            ->with([
                'status' => 'Berhasil membuat master pelanggan baru',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $customer = Customer::find($id);
        $branch = Branch::where('id', '!=', Customer::find($id)->branch_id)->get();
        return view('pages.backend.master.customer.updateCustomer', ['branch' => $branch, 'customer' => $customer]);
    }

    public function update(Request $req, $id)
    {
        if ($req->id == Customer::find($id)->identity) {
            Validator::make($req->all(), [
                'branch_id' => ['required', 'integer'],
                'name' => ['required', 'string', 'max:255'],
                'contact' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
            ])->validate();
        }
        else {
            Validator::make($req->all(), [
                'branch_id' => ['required', 'integer'],
                'identity' => ['required', 'string', 'max:255', 'unique:customers'],
                'name' => ['required', 'string', 'max:255'],
                'contact' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        Customer::where('id', $id)
            ->update([
                'branch_id' => $req->branch_id,
                'identity' => $req->identity,
                'name' => $req->name,
                'contact' => $req->contact,
                'address' => $req->address,
                'updated_by' => Auth::user()->name,
            ]);

        $customer = Customer::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master pelanggan ' . Customer::find($id)->name
        );

        $customer->save();

        return Redirect::route('customer.index')
            ->with([
                'status' => 'Berhasil merubah master pelanggan ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'delete');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master pelanggan ' . Customer::find($id)->name
        );

        Customer::destroy($id);

        return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
    }
}
