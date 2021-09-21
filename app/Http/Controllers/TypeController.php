<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class TypeController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Type::with(['brand', 'brand.category'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('type.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.type.indexType');
    }

    public function create()
    {
        $brand = Brand::all();
        return view('pages.backend.master.type.createType', ['brand' => $brand]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'brand_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Type::create([
            'brand_id' => $req->brand_id,
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master tipe baru'
        );

        return Redirect::route('type.index')
            ->with([
                'status' => 'Berhasil membuat master tipe baru',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $type = Type::find($id);
        $brand = Brand::where('id', '!=', Type::find($id)->brand_id)->get();
        return view('pages.backend.master.type.updateType', ['type' => $type, 'brand' => $brand]);
    }

    public function update(Request $req, $id)
    {
        Validator::make($req->all(), [
            'brand_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Type::where('id', $id)
            ->update([
                'brand_id' => $req->brand_id,
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $type = Type::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah masrter tipe ' . Type::find($id)->name
        );

        $type->save();

        return Redirect::route('type.index')
            ->with([
                'status' => 'Berhasil merubah master tipe ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master tipe ' . Type::find($id)->name
        );

        Type::destroy($id);

        return Response::json(['status' => 'success']);
    }
}
