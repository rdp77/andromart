<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class BrandController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(29,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        if ($req->ajax()) {
            $data = Brand::with('category')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('brand.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.brand.indexBrand');
    }

    public function create()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(29,'create');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $category = Category::get();
        return view('pages.backend.master.brand.createBrand', compact('category'));
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Brand::create([
            'name' => $req->name,
            'category_id' => $req->category_id,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master merk baru'
        );

        return Redirect::route('brand.index')
            ->with([
                'status' => 'Berhasil membuat master merk baru',
                'type' => 'success'
            ]);
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(29,'edit');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $category = Category::where('id', '!=', Brand::find($id)->category_id)->get();
        $brand = Brand::find($id);
        return view('pages.backend.master.brand.updateBrand', ['brand' => $brand, 'category' => $category]);
    }

    public function update(Request $req, $id)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Brand::where('id', $id)
            ->update([
                'name' => $req->name,
                'category_id' => $req->category_id,
                'updated_by' => Auth::user()->name,
            ]);

        $brand = Brand::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master merk ' . Brand::find($id)->name
        );

        $brand->save();

        return Redirect::route('brand.index')
            ->with([
                'status' => 'Berhasil merubah master merk ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $checkRoles = $this->DashboardController->cekHakAkses(29,'delete');
        $item = Item::where('brand_id', '=', $id)->get();
        $checkItem = count($item);
        $type = Type::where('brand_id', '=', $id)->get();
        $checkType = count($type);

        if($checkRoles == 'akses ditolak'){
            return Response::json(['status' => 'restricted', 'message' => 'Kamu Tidak Boleh Mengakses Fitur Ini :)']);
        }


        if($checkItem > 0){
            return Response::json(['status' => 'error', 'message' => 'Data terrelasi dengan Item, data tidak bisa dihapus !']);
        }
        else{
            if($checkType > 0){
                return Response::json(['status' => 'error', 'message' => 'Data terrelasi dengan Tipe, data tidak bisa dihapus !']);
            }
            else{
                $this->DashboardController->createLog(
                    $req->header('user-agent'),
                    $req->ip(),
                    'Menghapus master merk ' . Brand::find($id)->name
                );

                Brand::destroy($id);

                return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
            }
        }
    }
}
