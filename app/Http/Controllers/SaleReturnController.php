<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
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
            $data = Sale::with('SaleDetail', 'SaleDetail.Item')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('sale.edit', $row->id) . '" ><i class="fas fa-pencil-alt"></i> Edit</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Nota Besar</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('sale.printSmallSale', $row->id) . '" target="output"><i class="fas fa-print"></i> Nota Kecil</a>';
                    // $actionBtn .= '<a onclick="" class="dropdown-item" style="cursor:pointer;"><i class="far fa-eye"></i> Lihat</a>';
                    // $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('dataDateOperator', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . Carbon::parse($row->date)->locale('id')->isoFormat('LL') . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->created_by . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataCustomer', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->customer_name . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->customer_address . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<th>' . $row->customer_phone . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('dataItem', function ($row) {
                    $htmlAdd = '<table>';
                    foreach ($row->SaleDetail as $key => $value) {
                        // $item = $value->Item()->withTrashed()->get('name');
                        $htmlAdd .=   '<tr>';
                        $htmlAdd .=      '<th>' . $value->item->name . '</th>';
                        $htmlAdd .=      '<th>' . $value->qty . '</th>';
                        $htmlAdd .=   '</tr>';
                    }
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })
                ->addColumn('finance', function ($row) {
                    $htmlAdd = '<table>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Barang</td>';
                    $htmlAdd .=      '<th>' . number_format($row->item_price, 0, ".", ",") . '</th>';
                    $htmlAdd .=      '<td>S.P Sales</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_profit_sales, 0, ".", ",") . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Diskon</td>';
                    $htmlAdd .=      '<th>' . number_format($row->discount_price, 0, ".", ",") . '</th>';
                    $htmlAdd .=      '<td>S.P Buyer</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_profit_buyer, 0, ".", ",") . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .=   '<tr>';
                    $htmlAdd .=      '<td>Total</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_price, 0, ".", ",") . '</th>';
                    $htmlAdd .=      '<td>S.P Toko</td>';
                    $htmlAdd .=      '<th>' . number_format($row->total_profit_store, 0, ".", ",") . '</th>';
                    $htmlAdd .=   '</tr>';
                    $htmlAdd .= '<table>';

                    return $htmlAdd;
                })

                ->rawColumns(['action', 'dataItem', 'dataCustomer', 'finance', 'dataDateOperator'])
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
        $warranty = Item::with('warranty')
            ->find(SaleDetail::find($req->item)->item_id)->warranty;
        $date = Carbon::parse(SaleDetail::with('Sale')->find($req->item)->Sale->date);
        $dayWarranty = $this->getDayWarranty($warranty->name, $warranty->periode);
        $warranty = $date->addDays($dayWarranty);

        // dd($dayWarranty);
        // dd($warranty->diffInDays(Carbon::now()));
        // dd(Carbon::now()->diffInDays($warranty));
        // dd($date->diffInDays());


        // dd($item->warranty);
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
        $item = SaleDetail::with('Sale', 'Item')->find($req->item_id);

        $data = [
            'date' => Carbon::parse($item->Sale->date)->format('d F Y'),
            'qty' => $item->qty,
            'price' => number_format($item->price),
            'total' => number_format($item->total),
            'operator' => User::find($item->Sale->user_id)->name
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
}