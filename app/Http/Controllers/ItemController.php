<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Branch;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ItemController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Item::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('area.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.item.indexItem');
    }

    public function create()
    {
        $branch = Branch::all();
        $category = Category::all();
        $supplier = supplier::all();
        return view('pages.backend.master.item.createItem', ['branch' => $branch, 'category' => $category, 'supplier' => $supplier]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'branch_id' => ['required', 'integer'],
            'supplier_id' => ['required', 'integer'],
            'buy' => ['required', 'string', 'max:255'],
            'sell' => ['required', 'string', 'max:255'],
            // 'discount' => ['string', 'max:255'],
            'status' => ['required', 'boolean'],
            // 'description' => ['string', 'max:255'],
            // 'image' => ['string', 'max:255'],
        ])->validate();

        Item::create([
            'name' => $req->name,
            'categoryid' => $req->category_id,
            'branch_id' => $req->branch_id,
            'supplier_id' => $req->supplier_id,
            'buy' => $req->buy,
            'sell' => $req->sell,
            'discount' => $req->discount,
            'status' => $req->status,
            'description' => $req->description,
            'image' => $req->image,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat barang baru'
        );

        return Redirect::route('item.index')
            ->with([
                'status' => 'Berhasil membuat barang baru',
                'type' => 'success'
            ]);
    }

    public function edit($id)
    {

    }

    public function update($id, Request $req)
    {

    }

    public function destroy(Request $req, $id)
    {

    }
}
