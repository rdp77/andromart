<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class CategoryController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Category::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('category.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.category.indexCategory');
    }

    public function create()
    {
        return view('pages.backend.master.category.createCategory');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255', 'unique:categories'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Category::create([
            'code' => $req->code,
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master kategori baru'
        );

        return Redirect::route('category.index')
            ->with([
                'status' => 'Berhasil membuat master kategori baru',
                'type' => 'success'
            ]);
    }

    public function show(Category $category)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.backend.master.category.updateCategory', ['category' => $category]);
    }

    public function update(Request $req, $id)
    {
        if ($req->code == Category::find($id)->code) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }
        else{
            Validator::make($req->all(), [
                'code' => ['required', 'string', 'max:255', 'unique:categories'],
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        Category::where('id', $id)
            ->update([
            'code' => $req->code,
            'name' => $req->name,
            'updated_by' => Auth::user()->name,
            ]);

        $category = Category::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master kategori ' . Category::find($id)->name
        );

        $category->save();

        return Redirect::route('category.index')
            ->with([
                'status' => 'Berhasil merubah master kategori ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $brand = Brand::where('category_id', '=', $id)->get();
        $checkBrand = count($brand);

        if ($checkBrand > 0) {
            return Response::json(['status' => 'error', 'message' => 'Data terrelasi dengan Merk, data master tidak bisa dihapus !']);
        }
        else {
            $this->DashboardController->createLog(
                $req->header('user-agent'),
                $req->ip(),
                'Menghapus master kategori ' . Category::find($id)->name
            );

            Category::destroy($id);

            return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
        }
    }
}
