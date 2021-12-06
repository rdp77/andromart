<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class SupplierController extends Controller
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
            $data = Supplier::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('supplier.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.supplier.indexSupplier');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'create');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        return view('pages.backend.master.supplier.createSupplier');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255',],
            'contact' => ['required', 'string', 'max:13',],
        ])->validate();

        Supplier::create([
            'name' => $req->name,
            'address' => $req->address,
            'contact' => $req->contact,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master supplier baru'
        );

        return Redirect::route('supplier.index')
            ->with([
                'status' => 'Berhasil membuat master supplier baru',
                'type' => 'success'
            ]);
    }

    public function show(Supplier $supplier)
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'edit');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        $supplier = Supplier::find($id);
        return view('pages.backend.master.supplier.updateSupplier', ['supplier' => $supplier]);
    }

    public function update(Request $req, $id)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255',],
            'contact' => ['required', 'string', 'max:13',],
        ])->validate();

        Supplier::where('id', $id)
            ->update([
                'name' => $req->name,
                'address' => $req->address,
                'contact' => $req->contact,
                'updated_by' => Auth::user()->name,
            ]);

        $supplier = Supplier::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master supplier ' . Supplier::find($id)->name
        );

        $supplier->save();

        return Redirect::route('supplier.index')
            ->with([
                'status' => 'Berhasil merubah master supplier ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(1,'delete');

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }

        $item = Item::where('supplier_id', '=', $id)->get();
        $checkItem = count($item);

        if($checkItem > 0){
            return Response::json(['status' => 'error', 'message' => 'Data terrelasi dengan Item, data tidak bisa dihapus !']);
        }
        else {
            $this->DashboardController->createLog(
                $req->header('user-agent'),
                $req->ip(),
                'Menghapus master supplier ' . Supplier::find($id)->name
            );

            Supplier::destroy($id);

            return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
        }
    }
}
