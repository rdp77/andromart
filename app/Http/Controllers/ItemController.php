<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Item;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $data = Item::with('category', 'supplier')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('item.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('buy', function ($row) {
                    $htmlAdd  =      '<tr>';
                    $htmlAdd .=         '<td>'.number_format($row->buy,0,".",",").'</td>';
                    $htmlAdd .=      '<tr>';

                    return $htmlAdd;

                })

                ->addColumn('sell', function ($row) {
                    $htmlAdd  =      '<tr>';
                    $htmlAdd .=         '<td>'.number_format($row->sell,0,".",",").'</td>';
                    $htmlAdd .=      '<tr>';

                    return $htmlAdd;

                })
                ->rawColumns(['action', 'buy', 'sell'])
                ->make(true);
        }
        return view('pages.backend.master.item.indexItem');
    }

    public function create()
    {
        $branch = Branch::all();
        $category = Category::all();
        $supplier = supplier::all();
        return view('pages.backend.master.item.createItem', ['branch' => $branch, 'category' => $category, 'supplier' => $supplier ]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'supplier_id' => ['required', 'integer'],
            'buy' => ['required', 'string', 'max:255'],
            'sell' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:10'],
        ])->validate();

        $id = DB::table('items')->max('id')+1;
        Item::create([
            'id' => $id,
            'name' => $req->name,
            'category_id' => $req->category_id,
            'supplier_id' => $req->supplier_id,
            'buy' => $req->buy,
            'sell' => $req->sell,
            'discount' => $req->discount,
            'condition' => $req->condition,
            'description' => $req->description,
            'image' => $req->image,
            'created_by' => Auth::user()->name,
        ]);

        for ($i=0; $i <count($req->branch_id) ; $i++){
            Stock::create([
                'item_id' => $id,
                'unit_id' => '1',
                'branch_id' => $req->branch_id[$i],
                'stock' => '0',
                'min_stock' => '0',
                'description' => $req->description,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        }

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
        $item = Item::find($id);
        $branch = Branch::all();
        $category = Category::where('id', '!=', Item::find($id)->category_id)->get();
        $supplier = Supplier::where('id', '!=', Item::find($id)->supplier_id)->get();
        return view('pages.backend.master.item.updateItem', ['branch' => $branch, 'item' => $item, 'category' => $category, 'supplier' => $supplier] );
    }

    public function update($id, Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'supplier_id' => ['required', 'integer'],
            'buy' => ['required', 'string', 'max:255'],
            'sell' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:10'],
        ])->validate();

        Item::where('id', $id)
            ->update([
            'name' => $req->name,
            'category_id' => $req->category_id,
            'supplier_id' => $req->supplier_id,
            'buy' => $req->buy,
            'sell' => $req->sell,
            'discount' => $req->discount,
            'condition' => $req->condition,
            'description' => $req->description,
            'image' => $req->image,
            'updated_by' => Auth::user()->name,
            ]);

        $item = Item::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master barang ' . Item::find($id)->name
        );

        $item->save();

        return Redirect::route('item.index')
            ->with([
                'status' => 'Berhasil merubah master barang ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master barang ' . Item::find($id)->name
        );

        Item::destroy($id);

        return Response::json(['status' => 'success']);
    }
}
