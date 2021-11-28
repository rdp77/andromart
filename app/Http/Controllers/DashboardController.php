<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Journal;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('createLog');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // $dataSale = SaleDetail::select('item_id')
        // ->where('created_at', date('Y-m-01'))
        // ->where('created_at', date('Y-m-t'))
        // ->sum('qty');
        // return $dataSale;

        $dataTrafficToday = DB::table('traffic')->where('date', date('Y-m-d'))->count();
        $dataServiceTotal = Service::where('date', date('Y-m-d'))->count();
        $dataServiceHandphone = Service::where('type', '2')->where('date', date('Y-m-d'))->count();
        $dataServiceLaptop = Service::where('type', '3')->where('date', date('Y-m-d'))->count();
        $checkDataSharingProfit =  $this->checkSharingProfit();
        $sharingProfit1Service = $checkDataSharingProfit[0];
        $sharingProfit2Service = $checkDataSharingProfit[1];
        $sharingProfitSaleSales = $checkDataSharingProfit[2];
        $sharingProfitSaleBuyer = $checkDataSharingProfit[3];
        $karyawan = $checkDataSharingProfit[4];
        $checkServiceStatus = $checkDataSharingProfit[5];
        // return $checkServiceStatus;
        $dataPendapatan = Journal::with('ServicePayment', 'Sale')
            ->where('journals.date', date('Y-m-d'))
            ->where(function ($query) {
                $query->where('journals.type', 'Pembayaran Service')
                    ->orWhere('journals.type', 'Penjualan');
            })
            ->get();
        $log = Log::limit(7)->get();
        $users = User::count();
        $logCount = Log::where('u_id', Auth::user()->id)
            ->count();

        $totalSharingProfit = 0;
        $totalServiceProgress = [];
        $totalServiceDone = [];
        $totalServiceCancel = [];

        for ($i = 0; $i < count($karyawan); $i++) {
            $totalSharingProfit += $sharingProfit1Service[$i] + $sharingProfit2Service[$i] + $sharingProfitSaleSales[$i] + $sharingProfitSaleBuyer[$i];

            $totalServiceProgress[$i] = 0;
            $totalServiceDone[$i] = 0;
            $totalServiceCancel[$i] = 0;
            for ($j = 0; $j < count($checkServiceStatus[$i]); $j++) {
                if ($checkServiceStatus[$i][$j]->work_status == 'Proses' || $checkServiceStatus[$i][$j]->work_status == 'Mutasi' || $checkServiceStatus[$i][$j]->work_status == 'Manifest') {
                    $totalServiceProgress[$i] += 1;
                }
                if ($checkServiceStatus[$i][$j]->work_status == 'Selesai' || $checkServiceStatus[$i][$j]->work_status == 'Diambil') {
                    $totalServiceDone[$i] += 1;
                }
                if ($checkServiceStatus[$i][$j]->work_status == 'Cancel' || $checkServiceStatus[$i][$j]->work_status == 'Return') {
                    $totalServiceCancel[$i] += 1;
                }
            }
        }
        // return [$totalServiceProgress,$totalServiceDone,$totalServiceCancel];
        return view('dashboard', [
            'log' => $log,
            'users' => $users,
            'logCount' => $logCount,
            'dataPendapatan' => $dataPendapatan,
            'dataServiceTotal' => $dataServiceTotal,
            'dataServiceHandphone' => $dataServiceHandphone,
            'dataServiceLaptop' => $dataServiceLaptop,
            'dataTrafficToday' => $dataTrafficToday,
            'karyawan' => $karyawan,
            'sharingProfit1Service' => $sharingProfit1Service,
            'sharingProfit2Service' => $sharingProfit2Service,
            'sharingProfitSaleSales' => $sharingProfitSaleSales,
            'sharingProfitSaleBuyer' => $sharingProfitSaleBuyer,
            'totalSharingProfit' => number_format($totalSharingProfit, 0, ',', '.'),
            // 'checkServiceStatus' => $checkServiceStatus
            'totalServiceProgress' => $totalServiceProgress,
            'totalServiceDone' => $totalServiceDone,
            'totalServiceCancel' => $totalServiceCancel,
        ]);
    }

    public function checkSharingProfit()
    {
        $chekSales = Employee::with('Service1', 'Service2')->where('id', '!=', 1)->get();
        for ($i = 0; $i < count($chekSales); $i++) {
            $sharingProfit1Service[$i] = Service::where('work_status', 'Diambil')
                ->where('date', date('Y-m-d'))
                ->where('payment_status', 'Lunas')
                ->where('technician_id', $chekSales[$i]->id)
                ->sum('sharing_profit_technician_1');
            $sharingProfit2Service[$i] = Service::where('work_status', 'Diambil')
                ->where('date', date('Y-m-d'))
                ->where('payment_status', 'Lunas')
                ->where('technician_replacement_id', $chekSales[$i]->id)
                ->sum('sharing_profit_technician_2');
            $sharingProfitSaleSales[$i] = SaleDetail::where('sales_id', $chekSales[$i]->id)
                ->where('created_at', date('Y-m-d'))
                ->sum('sharing_profit_sales');
            $sharingProfitSaleBuyer[$i] = SaleDetail::where('buyer_id', $chekSales[$i]->id)
                ->where('created_at', date('Y-m-d'))
                ->sum('sharing_profit_buyer');
            $checkServiceStatus[$i] = Service::where('date', date('Y-m-d'))
                ->where('technician_id', $chekSales[$i]->id)
                ->get();
        }
        return [$sharingProfit1Service, $sharingProfit2Service, $sharingProfitSaleSales, $sharingProfitSaleBuyer, $chekSales, $checkServiceStatus];
    }

    public function log(Request $req)
    {
        if ($req->ajax()) {
            $data = Log::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('added_at', function ($row) {
                    return date("d-M-Y H:m", strtotime($row->added_at));
                })
                ->rawColumns(['added_at'])
                ->make(true);
        }
        return view('pages.backend.log.IndexLog');
    }

    public function createLog($header, $ip, $action)
    {
        Log::create([
            'info' => $action,
            'u_id' => Auth::user()->id,
            'url' => URL::full(),
            'user_agent' => $header,
            'ip' => $ip,
            'added_at' => date("Y-m-d H:i:s"),
        ]);
    }
    public function changeMonthIdToEn($dateLocale)
    {
        $separateString = explode(' ', $dateLocale);
        $day    = $separateString[0];
        $monthLocale  = $separateString[1];
        $year   = $separateString[2];


        if ($monthLocale == 'Januari') {
            $month = 1;
        } elseif ($monthLocale == 'Februari') {
            $month = 2;
        } elseif ($monthLocale == 'Maret') {
            $month = 3;
        } elseif ($monthLocale == 'April') {
            $month = 4;
        } elseif ($monthLocale == 'Mei') {
            $month = 5;
        } elseif ($monthLocale == 'Juni') {
            $month = 6;
        } elseif ($monthLocale == 'Juli') {
            $month = 7;
        } elseif ($monthLocale == 'Agustus') {
            $month = 8;
        } elseif ($monthLocale == 'September') {
            $month = 9;
        } elseif ($monthLocale == 'Oktober') {
            $month = 10;
        } elseif ($monthLocale == 'November') {
            $month = 11;
        } elseif ($monthLocale == 'Desember') {
            $month = 12;
        }

        return $date = $year . '-' . $month . '-' . $day;
    }

    public function validator($validator)
    {
        $data = array();
        foreach ($validator as $message) {
            array_push($data, $message);
        }
        return $data;
    }

    public function createCode($string, $table)
    {
        $getEmployee =  Employee::with('branch')->where('user_id', Auth::user()->id)->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table($table)->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $string . $getEmployee->Branch->code . $year . $month . $index;
    }
}