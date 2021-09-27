<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Item;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
            $data = Item::where('id', '!=', 1)->with('brand', 'brand.category', 'supplier')->get();
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

                ->addColumn('brand', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Kategori</td>';
                    $htmlAdd .=      '<th>'.$row->brand->category->code.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Merk</td>';
                    $htmlAdd .=      '<th>'.$row->brand->name.'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })

                ->addColumn('price', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Beli</td>';
                    $htmlAdd .=      '<th>'.number_format($row->buy,0,".",",").'</th>';
                    $htmlAdd .=      '<td>Profit</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sell - $row->buy,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Jual</td>';
                    $htmlAdd .=      '<th>'.number_format($row->sell,0,".",",").'</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;

                })

                ->rawColumns(['action', 'brand', 'price'])
                ->make(true);
        }
        return view('pages.backend.master.item.indexItem');
    }

    public function create()
    {
        $branch = Branch::get();
        $category = Category::get();
        $brand = Brand::get();
        $type = Type::get();
        $supplier = Supplier::get();
        return view('pages.backend.master.item.createItem', compact('branch', 'category', 'brand', 'type', 'supplier'));
    }

    public function store(Request $req)
    {
        $id = DB::table('items')->max('id')+1;
        $image = $req->image;
            $image = str_replace('data:image/jpeg;base64,','', $image);
            $image = base64_decode($image);
            if ($image != null) {
                $fileSave = 'public/assetsmaster/image/item/IMG_' . $id . '.' .'png';
                $fileName = 'IMG_' . $id . '.' .'png';
                Storage::put($fileSave, $image);
            }else{
                $fileName = null;
            }

            Item::create([
                'id' => $id,
                'name' => $req->name,
                'brand_id' => $req->brand,
                'supplier_id' => $req->supplier_id,
                'buy' => str_replace(",", '',$req->buy),
                'sell' => str_replace(",", '',$req->sell),
                'discount' => str_replace(",", '',$req->discount),
                'condition' => $req->condition,
                'image' => $fileName,
                'description' => $req->description,
                'created_by' => Auth::user()->name,
            ]);

        // if ($req->hasFile('image')) {
        //     $req->file('image')->move('assetsmaster/image/item/',$req->file('image')->getClientOriginalName());
        //     Item::create([
        //         'id' => $id,
        //         'name' => $req->name,
        //         'brand_id' => $req->brand,
        //         'supplier_id' => $req->supplier_id,
        //         'buy' => str_replace(",", '',$req->buy),
        //         'sell' => str_replace(",", '',$req->sell),
        //         'discount' => str_replace(",", '',$req->discount),
        //         'condition' => $req->condition,
        //         'description' => $req->description,
        //         'image' => $req->file('image')->getClientOriginalName(),
        //         'created_by' => Auth::user()->name,
        //     ]);
        // }
        // else {
        //     Item::create([
        //         'id' => $id,
        //         'name' => $req->name,
        //         'brand_id' => $req->brand,
        //         'supplier_id' => $req->supplier_id,
        //         'buy' => str_replace(",", '',$req->buy),
        //         'sell' => str_replace(",", '',$req->sell),
        //         'discount' => str_replace(",", '',$req->discount),
        //         'condition' => $req->condition,
        //         'description' => $req->description,
        //         'created_by' => Auth::user()->name,
        //     ]);
        // }

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
        $item = Item::with('brand')->find($id);
        $category = Category::get();
        $brand = Brand::get();
        $supplier = Supplier::where('id', '!=', Item::find($id)->supplier_id)->get();
        return view('pages.backend.master.item.updateItem', compact('item', 'category', 'brand', 'brand', 'supplier'));
    }

    public function update($id, Request $req)
    {
        // Validator::make($req->all(), [
        //     'name' => ['required', 'string', 'max:255'],
        //     'brand_id' => ['required', 'integer'],
        //     'supplier_id' => ['required', 'integer'],
        //     'buy' => ['required', 'string', 'max:255'],
        //     'sell' => ['required', 'string', 'max:255'],
        //     'condition' => ['required', 'string', 'max:10'],
        // ])->validate();
        $checkData = Item::where('id',$id)->first();
        $image = $req->image;
        $image = str_replace('data:image/jpeg;base64,','', $image);
        $image = base64_decode($image);
        if ($image != null) {
            $fileSave = 'public/assetsmaster/image/item/IMG_' . $checkData->id . '.' .'png';
            $fileName = 'IMG_' . $checkData->id . '.' .'png';
            Storage::put($fileSave, $image);
        }else{
            $fileName = $checkData->image;
        }

        Item::where('id', $id)
            ->update([
            'name' => $req->name,
            'brand_id' => $req->brand,
            'supplier_id' => $req->supplier_id,
            'buy' => str_replace(",", '',$req->buy),
            'sell' => str_replace(",", '',$req->sell),
            'discount' => str_replace(",", '',$req->discount),
            'condition' => $req->condition,
            'description' => $req->description,
            'image' => $fileName,
            'updated_by' => Auth::user()->name,
            ]);
        // if ($req->hasFile('image')) {
        //     $req->file('image')->move('assetsmaster/image/item/',$req->file('image')->getClientOriginalName());
        //     Item::where('id', $id)
        //     ->update([
        //     'name' => $req->name,
        //     'brand_id' => $req->brand,
        //     'supplier_id' => $req->supplier_id,
        //     'buy' => str_replace(",", '',$req->buy),
        //     'sell' => str_replace(",", '',$req->sell),
        //     'discount' => str_replace(",", '',$req->discount),
        //     'condition' => $req->condition,
        //     'description' => $req->description,
        //     'image' => $req->file('image')->getClientOriginalName(),
        //     'updated_by' => Auth::user()->name,
        //     ]);
        // }
        // else {
        //     Item::where('id', $id)
        //     ->update([
        //     'name' => $req->name,
        //     'brand_id' => $req->brand,
        //     'supplier_id' => $req->supplier_id,
        //     'buy' => str_replace(",", '',$req->buy),
        //     'sell' => str_replace(",", '',$req->sell),
        //     'discount' => str_replace(",", '',$req->discount),
        //     'condition' => $req->condition,
        //     'description' => $req->description,
        //     'updated_by' => Auth::user()->name,
        //     ]);
        // }

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
        // $tr = SaleDetail::where('item_id', $id);
        // $checkStock = Item::with('Stocks', 'stock')->find($id)->get();
        // if ($checkStock > 0) {
        //     return Response::json(['status' => 'error', 'message' => 'Data tidak bisa dihapus']);
        // }
        // else {
        //     $this->DashboardController->createLog(
        //         $req->header('user-agent'),
        //         $req->ip(),
        //         'Menghapus master barang ' . Item::find($id)->name
        //     );

        //     Item::destroy($id);
        //     Stock::destroy(Item::where('item_id', $id));
        //     return Response::json(['status' => 'success']);
        // }
        // ------
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master barang ' . Item::find($id)->name
        );

        Item::destroy($id);
        Stock::destroy(Item::where('item_id', $id));
        return Response::json(['status' => 'Berhasil menghapus Master Barang', 'type' => 'success']);
    }
}
