<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SaleDetail;
use App\Models\SaleReturn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SaleReturnController extends Controller
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
        // dd(SaleReturn::with('Sale', 'Item')->get());
        if ($req->ajax()) {
            $data = SaleReturn::with('Sale', 'Item')->get();
            return Datatables::of($data)
                ->addColumn('faktur', function ($row) {
                    return $row->Sale->code;
                })
                ->addColumn('name', function ($row) {
                    return $row->Item->name;
                })
                ->addColumn('type', function ($row) {
                    switch ($row->type) {
                        case 1:
                            $data = "Barang Diservice";
                        case 2:
                            $data = "Barang Diganti Baru";
                        case 3:
                            $data = "Direturn Uang";
                        case 4:
                            $data = "Barang Diganti";
                    }
                    $html = '<span class="badge badge-info">';
                    $html .= $data;
                    $html .= '</span>';
                    return $html;
                })
                ->addColumn('desc', function ($row) {
                    return $row->desc;
                })
                // ->addColumn('action', function ($row) {
                //     // $actionBtn = '<div class="btn-group">';
                //     // $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                //     //         data-toggle="dropdown">
                //     //         <span class="sr-only">Toggle Dropdown</span>
                //     //     </button>';
                //     // $actionBtn .= '<div class="dropdown-menu">
                //     //         <a class="dropdown-item" href="' . route('sale.edit', $row->id) . '" ><i class="fas fa-pencil-alt"></i> Edit</a>';
                //     // $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Nota Besar</a>';
                //     // $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSmallSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Nota Kecil</a>';
                //     // // $actionBtn .= '<a onclick="" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                //     // // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                //     // $actionBtn .= '</div></div>';
                //     // return $actionBtn;
                //     return 'asds';
                // })

                ->rawColumns(['faktur', 'name', 'type', 'desc'])
                ->make(true);
        }
        return view('pages.backend.transaction.sale.return.indexReturn');
    }

    public function create()
    {
        $item = SaleDetail::with('Sale', 'Item')->get();
        return view('pages.backend.transaction.sale.return.createReturn', [
            'item' => $item
        ]);
    }

    public function store(Request $req)
    {
        // Validator
        if ($req->item == null) {
            return Response::json([
                'status' => 'error',
                'data' => array("Pilih barang terlebih dahulu!")
            ]);
        }
        // Initialization
        $warranty = Item::with('warranty')
            ->find(SaleDetail::find($req->item)->item_id)->warranty;
        // Mengambil Tanggal Faktur Dikeluarkan
        $date = Carbon::parse(SaleDetail::with('Sale')->find($req->item)->Sale->date);
        // Mengambil Jarak Garansi
        $dayWarranty = $this->getDayWarranty($warranty->name, $warranty->periode);
        // Mengambil Tanggal Garansi
        $warranty = $date->addDays($dayWarranty);
        // Check Garansi
        if (Carbon::now()->diffInDays($warranty) < 0) {
            return Response::json([
                'status' => 'error',
                'data' => array(
                    "Barang tidak bisa di return, karena melewati masa garansi"
                )
            ]);
        } else {
            return Response::json([
                'status' => 'service',
                'data' => 'Barang masih ada garansi, pilih metode return!'
            ]);
        }
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }

    public function getData(Request $req)
    {
        $dataItems = explode(",", $req->item_id);
        $item = SaleDetail::with('Sale', 'Item')->find($dataItems[0]);
        $discountType = $item->Sale->discount_type;
        $discount = $discountType == "percent" ? $item->Sale->discount_percent
            : $item->Sale->discount_price;

        $data = [
            'faktur' => $item->Sale->code,
            'date' => Carbon::parse($item->Sale->date)->format('d F Y'),
            'qty' => $item->qty,
            'price' => number_format($item->price),
            'total' => number_format($item->total),
            'operator' => User::find($item->Sale->user_id)->name,
            'sale' => $item->Sale->id,
            'item' => $dataItems[1],
            'sp_taker' => $item->sharing_profit_sales,
            'sp_seller' => $item->sharing_profit_buyer,
            'taker' => User::find($item->buyer_id)->name,
            'seller' => User::find($item->sales_id)->name,
            'discount_type' => $discountType,
            'discount' => $discount
        ];

        return Response::json([
            'status' => 'success',
            'result' => $data
        ]);
    }

    function getDayWarranty($type, $periode)
    {
        if ($type == 'Minggu') {
            $day = 7;
        } elseif ($type == 'Bulan') {
            $day = 30;
        }
        return $day + $periode;
    }

    public function getType(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'type' => 'required',
            'desc' => 'required',
        ]);

        $validator = $this->DashboardController
            ->validator($validator->errors()->all());

        if (count($validator) != 0) {
            return Response::json([
                'status' => 'error',
                'data' => $validator
            ]);
        }

        switch ($req->type) {
            case 1:
                $this->storedReturn(
                    $req->sale,
                    $req->item_id,
                    $req->type,
                    $req->desc
                );
                return Response::json([
                    'status' => 'loss',
                    'data' => "Barang akan diservice dan barang yang digantikan akan dijadikan barang loss sales!"
                ]);
                break;
            case 2:
                // Sedangkan ssd rusak iku maeng akan di return ng supplier. Dadi mutasi barang ssd dengan keterangan barang direturn ng supplier.
                $this->storedReturn(
                    $req->sale,
                    $req->item_id,
                    $req->type,
                    $req->desc
                );
                return Response::json([
                    'status' => 'new',
                    'data' => "Barang akan diganti baru dan barang lama akan di return ke supplier!"
                ]);
                break;
            case 3:
                $this->storedReturn(
                    $req->sale,
                    $req->item_id,
                    $req->type,
                    $req->desc
                );
                return Response::json([
                    'status' => 'money',
                    'data' => "Barang akan direturn menggunakan uang!"
                ]);
                break;
            case 4:
                return Response::json([
                    'status' => 'att',
                    'data' => "Barang akan diganti sesuai keinginan dan barang lama akan dibeli toko dan masuk ke dalam stok!"
                ]);
                break;
        }
    }

    function storedReturn($sale, $item, $type, $dsc)
    {
        SaleReturn::create([
            'sale_id' => $sale,
            'item_id' => $item,
            'type' => $type,
            'desc' => $dsc,
            'created_by' => Auth::user()->name,
            'updated_by' => '',
            'deleted_by' => ''
        ]);
    }

    // Tindakan Ketika Return
    public function dataLoss()
    {
    }

    public function toSupplier()
    {
    }

    public function toStock()
    {
    }
}