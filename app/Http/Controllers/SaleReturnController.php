<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if ($req->ajax()) {
            $data = SaleReturn::with('Sale', 'SaleReturnDetail')->get();
            return Datatables::of($data)
                ->addColumn('code', function ($row) {
                    return $row->code;
                })
                ->addColumn('faktur', function ($row) {
                    return $row->Sale->code;
                })
                ->addColumn('name', function ($row) {
                    $html = '<table>';
                    foreach ($row->SaleReturnDetail as $i) {
                        $html .= '<tr><th>';
                        $html .= Item::find($i->item_id)->name;
                        $html .= '</th></tr>';
                    }
                    $html .= '</table>';

                    return $html;
                })
                ->addColumn('type', function ($row) {
                    $html = '<table>';
                    foreach ($row->SaleReturnDetail as $i) {
                        switch ($i->type) {
                            case 1:
                                $data = "Diservice";
                            case 2:
                                $data = "Diganti Baru";
                            case 3:
                                $data = "Tukar Tambah";
                            case 4:
                                $data = "Diganti Uang";
                            case 5:
                                $data = "Diganti Barang Lain";
                        }
                        $html .= '<tr><th>';
                        $html .= $data;
                        $html .= '</th></tr>';
                    }
                    $html .= '</table>';

                    return $html;
                })
                ->addColumn('desc', function ($row) {
                    return $row->desc;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-primary btn-block" target="_blank" href="' . route('sale.return.print', $row->Sale->id) . '">';
                    $actionBtn .= '<i class="fas fa-print"></i> Nota Besar</a>';
                    $actionBtn .= '<a class="btn btn-primary btn-block" target="_blank" href="' . route('sale.return.printSmall', $row->Sale->id) . '">';
                    $actionBtn .= '<i class="fas fa-print"></i> Nota Kecil</a>';
                    return $actionBtn;
                })

                ->rawColumns(['code', 'faktur', 'name', 'type', 'desc', 'action'])
                ->make(true);
        }
        return view('pages.backend.transaction.sale.return.indexReturn');
    }

    public function create()
    {
        $item = SaleDetail::with('Sale', 'Item')->get();
        $sale = Sale::with('SaleDetail')->get();
        return view('pages.backend.transaction.sale.return.createReturn', [
            'item' => $item,
            'sale' => $sale
        ]);
    }

    public function store(Request $req)
    {
        // Validator
        foreach ($req->data_item as $d) {
            if ($d == null) {
                return Response::json([
                    'status' => 'error',
                    'data' => array("Ada data yang kosong, pilih terlebih dahulu!")
                ]);
            }
        }

        foreach ($req->type as $t) {
            if ($t == null) {
                return Response::json([
                    'status' => 'error',
                    'data' => array("Ada perlakuan barang yang kosong, pilih terlebih dahulu!")
                ]);
            }
        }

        if (count(array_unique($req->data_item)) < count($req->data_item)) {
            // Array has duplicates
            return Response::json([
                'status' => 'error',
                'data' => array("Data Barang Sama")
            ]);
        }

        foreach ($req->data_item as $d) {
            // Initialization
            $warranty = Item::with('warranty')
                ->find($d)->warranty;
            // Mengambil Tanggal Faktur Dikeluarkan
            $date = Carbon::parse(Sale::find($req->item)->date);
            // Mengambil Jarak Garansi
            $dayWarranty = $this->getDayWarranty($warranty->name, $warranty->periode);
            // Mengambil Tanggal Garansi
            $warranty = $date->addDays($dayWarranty);
            // Check Garansi
            if (Carbon::now()->diffAsCarbonInterval($warranty)->d > $dayWarranty) {
                return Response::json([
                    'status' => 'error',
                    'data' => array(
                        "Barang " . Item::find($d)->name . " tidak bisa di return, karena melewati masa garansi"
                    )
                ]);
            }
        }

        // Check Return
        foreach ($req->type as $index => $t) {
            $this->getType($t);
        }

        $id = DB::table('sale_return')->max('id') + 1;
        SaleReturn::create([
            'id' => $id,
            'code' => $this->DashboardController->createCode('RTNP', 'sale_return'),
            'sale_id' => $req->item,
            'branch_id' => Employee::where('user_id', Auth::user()->id)->first()->branch_id,
            'desc' => $req->description,
            'created_at' => date('Y-m-d h:i:s'),
            'created_by' => Auth::user()->name,
        ]);

        foreach ($req->data_item as $index => $d) {
            SaleReturnDetail::create([
                'sale_return_id' => $id,
                'item_id' => $d,
                'type' => $req->type[$index],
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->name,
            ]);
        }

        return Response::json([
            'status' => 'success',
            'result' => "Data Pengembalian Penjualan Berhasil Disimpan"
        ]);
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
        // item_id = sale
        // $item = SaleDetail::with('Sale', 'Item')->find($req->item_id);
        $sale = Sale::with('SaleDetail')->find($req->item_id);
        $discountType = $sale->discount_type;
        $discount = $discountType == "percent" ? $sale->discount_percent
            : $sale->discount_price;
        // $taker = $item->buyer_id != null ? User::find($item->buyer_id)->name : null;

        $customer = '<div class="row"><div class="form-group col-12 col-md-6 col-lg-6"><label>Nama Customer</label>';
        $customer .= '<p>' . $sale->customer_name . '</p>';
        $customer .= '</div><div class="form-group col-12 col-md-6 col-lg-6"><label for="type">Alamat & No Telepon</label>';
        $customer .= '<p>' . $sale->customer_address . ' [ ' . $sale->customer_phone . ' ] </p></div></div></div>';

        // $table =  '<tr><td>' . $faktur . '</td>';
        // $table .= '<td>' . Item::find($dataItems[1])->name . '</td>';
        // $table .= '<td><select class="form-control" name="type"><option value="">- Pilih Metode Return -</option><option value="1">Service Barang</option>';
        // $table .= '<option value="2">Ganti Baru</option><option value="4">Tukar Tambah</option><option value="5">Ganti Uang</option>';
        // $table .= '<option value="6">Ganti Barang Lain</option></select></td></tr>';

        $data = [
            'date' => Carbon::parse($sale->date)->format('d F Y'),
            // 'qty' => $item->qty,
            // 'price' => number_format($item->price),
            'total' => number_format($sale->total_price),
            'operator' => User::find($sale->user_id)->name,
            'sale' => $sale->id,
            // 'item' => $dataItems[1],
            // 'sp_taker' => $item->sharing_profit_sales,
            // 'sp_seller' => $item->sharing_profit_buyer,
            // 'taker' => $taker,
            // 'seller' => User::find($item->sales_id)->name,
            'discount_type' => $discountType,
            'discount' => $discount,
            'customer' => $customer,
            // 'table' => $table
        ];

        return Response::json([
            'status' => 'success',
            'result' => $data
        ]);
    }

    public function add(Request $req)
    {
        $item = Sale::with('SaleDetail')->find($req->saleDetail);

        $table =  '<tr class="data data_+(data+1)+"><td>' . $item->code . '</td>';
        // $table =  '<tr class="data data_+(data+1)+"><td>qty</td>';
        // $table .= '<td>harga</td>';
        $table .= '<td><select class="form-control select2" name="data_item[]"><option value="">- Pilih Barang -</option>';
        foreach ($item->SaleDetail as $s) {
            foreach (Item::all() as $i) {
                if ($s->item_id == $i->id) {
                    $table .= '<option value="' . $i->id . '">' . $i->name . '</option>';
                }
            }
        }
        $table .= '</select></td>';
        $table .= '<td><select class="form-control" name="type[]"><option value="">- Pilih Metode Return -</option><option value="1">Service Barang</option>';
        $table .= '<option value="2">Ganti Baru</option><option value="4">Tukar Tambah</option><option value="5">Ganti Uang</option>';
        $table .= '<option value="6">Ganti Barang Lain</option></select></td>';
        // $table .= '<td><button type="button" class="btn btn-danger btn-block" onclick="remove_item(\''+(remove+1)+'\')"><i class="fas fa-trash"></i> Hapus</button>';
        // $table .='</td></tr>';
        $table .= '</tr>';

        return Response::json([
            'status' => 'success',
            'result' => $table
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

    public function getType($type)
    {
        switch ($type) {
                // Service
            case 1:
                // return Response::json([
                //     'status' => 'loss',
                //     'data' => "Barang akan diservice dan barang yang digantikan akan dijadikan barang loss sales!"
                // ]);
                break;
            case 2:
                // Ganti Baru
                // Sedangkan ssd rusak iku maeng akan di return ng supplier. Dadi mutasi barang ssd dengan keterangan barang direturn ng supplier.
                // return Response::json([
                //     'status' => 'new',
                //     'data' => "Barang akan diganti baru dan barang lama akan di return ke supplier!"
                // ]);
                break;
            case 3:
                // Tukar Tambah                
                break;
            case 4:
                // Diganti Uang
                // return Response::json([
                //     'status' => 'money',
                //     'data' => "Barang akan direturn menggunakan uang!"
                // ]);
                break;
            case 5:
                // Diganti Barang Lain
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

    public function printReturn($id)
    {
        $sale = Sale::with('SaleDetail', 'Sales', 'SaleDetail.Item', 'SaleDetail.Item.Warranty', 'SaleDetail.Item.Brand', 'SaleDetail.Item.Brand.Category', 'CreatedByUser', 'Return')
            ->find($id);
        $member = User::get();
        return view('pages.backend.transaction.sale.return.printReturn', [
            'sale' => $sale, 'member' => $member
        ]);
    }

    public function printSmallReturn($id)
    {
        $sale = Sale::with('SaleDetail', 'Sales', 'SaleDetail.Item', 'SaleDetail.Item.Brand', 'SaleDetail.Item.Brand.Category', 'CreatedByUser')->find($id);
        // return $Service;
        $member = User::get();
        return view('pages.backend.transaction.sale.return.printSmallReturn', ['sale' => $sale, 'member' => $member]);
    }
}