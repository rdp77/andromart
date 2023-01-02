<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Journal;
use App\Models\SubMenu;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\AccountData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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
        $this->newvaruser = new User();
        $this->middleware('auth')->except('createLog');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // return $this->hit(81);
        // $sol3 = $this->solution3(1200000,12,1);
        // return $this->solution2(7,215.3);
        // return $this->solution1(-1,2,6);
        $branch = Branch::get();
        $topSales = DB::table('sale_details')
            ->leftJoin('items', 'items.id', '=', 'sale_details.item_id')
            ->select('items.id', 'items.name', 'items.brand_id', 'sale_details.item_id', DB::raw('SUM(sale_details.qty) as total'))
            ->groupBy('items.id', 'sale_details.item_id', 'items.name', 'items.brand_id')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        // return $topSales;

        $dataTrafficToday = DB::table('traffic')
            ->where('date', date('Y-m-d'))
            ->count();
        $dataServiceTotal = Service::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count();
        $dataServiceHandphone = Service::where('type', '11')
            ->where('created_at', 'like', '%' . date('Y-m-d') . '%')
            ->count();
        $dataServiceLaptop = Service::where('type', '10')
            ->where('created_at', 'like', '%' . date('Y-m-d') . '%')
            ->count();
        $checkDataSharingProfit = $this->checkSharingProfit();
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
                $query->where('journals.type', 'Pembayaran Service')->orWhere('journals.type', 'Penjualan');
            })
            ->get();
        $log = Log::limit(7)->get();
        $users = User::count();
        $logCount = Log::where('u_id', Auth::user()->id)->count();

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
            // 'sol3'=>$sol3,
            // 'tempo'=>12,
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
            'topSales' => $topSales,
            'branch' => $branch,
        ]);
    }

    public function filterDataDashboard(Request $req)
    {
        // return $req->all();
        // return date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year));
        // return $this->changeMonthIdToEn($req->startDate);

        if ($req->type == 'Bulan') {
            $date1 = date('Y-m-01', strtotime($req->month));
            $date2 = date('Y-m-t', strtotime($req->month));
        } elseif ($req->type == 'Tahun') {
            $date1 = date('m-01');
            $date2 = date('m-t');

            $date1 = $req->year . '-' . '01' . '-' . '01';
            $date2 = $req->year . '-' . '12' . '-' . '31';
        } elseif ($req->type == 'Tanggal') {
            $date1 = $this->changeMonthIdToEn($req->startDate);
            $date2 = $this->changeMonthIdToEn($req->endDate);
        } else {
            // $date1 = date('Y-10-20');
            // $date2 = date('Y-10-20');
            $date1 = date('Y-m-d');
            $date2 = date('Y-m-d');
        }
        if ($req->branch == '') {
            $branch = '';
        } else {
            $branch = $req->branch;
        }

        if (Auth::user()->role_id == 1) {
            return $this->filterDataDashboardOwner($req->type, $date1, $date2, $req->branch);
        }
        // return [$date1,$date2];
        $topSales = DB::table('sale_details')
            ->leftJoin('items', 'items.id', '=', 'sale_details.item_id')
            ->select('items.id', 'items.name', 'items.brand_id', 'sale_details.item_id', DB::raw('SUM(sale_details.qty) as total'))
            ->where(function ($query) use ($req, $date1, $date2) {
                if ($req->type == 'Tanggal') {
                    $query->where('sale_details.created_at', '>=', $date1 . ' 00:00:00')->where('sale_details.created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($req->type == 'Bulan') {
                    $query->where('sale_details.created_at', '>=', $date1 . ' 00:00:00')->where('sale_details.created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($req->type == 'Tahun') {
                    $query->where('sale_details.created_at', '>=', $date1 . ' 00:00:00')->where('sale_details.created_at', '<=', $date2 . ' 23:59:59');
                } else {
                    $query->where('sale_details.created_at', '>=', $date1 . ' 00:00:00')->where('sale_details.created_at', '<=', $date2 . ' 23:59:59');
                }
            })
            ->groupBy('items.id', 'sale_details.item_id', 'items.name', 'items.brand_id')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $dataTrafficToday = DB::table('traffic')
            ->where(function ($query) use ($req, $date1, $date2) {
                if ($req->type == 'Tanggal') {
                    $query->where('date', '>=', $date1)->where('date', '<=', $date2);
                } elseif ($req->type == 'Bulan') {
                    $query->where('date', '>=', $date1)->where('date', '<=', $date2);
                } elseif ($req->type == 'Tahun') {
                    $query->where('date', '>=', $date1)->where('date', '<=', $date2);
                } else {
                    $query->where('date', '>=', $date1)->where('date', '<=', $date2);
                }
            })
            ->count();
        $dataServiceTotal = Service::where(function ($query) use ($req, $date1, $date2) {
            if ($req->type == 'Tanggal') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } elseif ($req->type == 'Bulan') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } elseif ($req->type == 'Tahun') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } else {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            }

            if ($req->branch != '') {
                $query->where('branch_id', $req->branch);
            }
        })->count();

        // return $this->changeMonthIdToEn($req->startDate). ' 00:00:00';
        $dataServiceHandphone = Service::where('type', '11')
            ->where(function ($query) use ($req, $date1, $date2) {
                if ($req->type == 'Tanggal') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($req->type == 'Bulan') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($req->type == 'Tahun') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } else {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                }
                if ($req->branch != '') {
                    $query->where('branch_id', $req->branch);
                }
            })
            ->count();

        $dataServiceLaptop = Service::where(function ($query) use ($req, $date1, $date2) {
            if ($req->type == 'Tanggal') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } elseif ($req->type == 'Bulan') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } elseif ($req->type == 'Tahun') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } else {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            }
            if ($req->branch != '') {
                $query->where('branch_id', $req->branch);
            }
        })->count();

        $chekSales = Employee::with('Service1', 'Service2')
            ->where('id', '!=', 1)
            ->get();
        for ($i = 0; $i < count($chekSales); $i++) {
            $sharingProfit1Service[$i] = Service::where('work_status', 'Diambil')
                ->where(function ($query) use ($req, $date1, $date2) {
                    if ($req->type == 'Tanggal') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Bulan') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Tahun') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } else {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    }
                    if ($req->branch != '') {
                        $query->where('branch_id', $req->branch);
                    }
                })
                ->where('payment_status', 'Lunas')
                ->where('technician_id', $chekSales[$i]->id)
                ->sum('sharing_profit_technician_1');

            $sharingProfit2Service[$i] = Service::where('work_status', 'Diambil')
                ->where(function ($query) use ($req, $date1, $date2) {
                    if ($req->type == 'Tanggal') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Bulan') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Tahun') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } else {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    }

                    if ($req->branch != '') {
                        $query->where('branch_id', $req->branch);
                    }
                })
                ->where('payment_status', 'Lunas')
                ->where('technician_replacement_id', $chekSales[$i]->id)
                ->sum('sharing_profit_technician_2');

            $sharingProfitSaleSales[$i] = SaleDetail::where('sales_id', $chekSales[$i]->id)
                ->where(function ($query) use ($req, $date1, $date2) {
                    if ($req->type == 'Tanggal') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Bulan') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Tahun') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } else {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    }
                })
                ->sum('sharing_profit_sales');
            $sharingProfitSaleBuyer[$i] = SaleDetail::where('buyer_id', $chekSales[$i]->id)
                ->where(function ($query) use ($req, $date1, $date2) {
                    if ($req->type == 'Tanggal') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Bulan') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } elseif ($req->type == 'Tahun') {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    } else {
                        $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                    }
                })
                ->sum('sharing_profit_buyer');
            $checkServiceStatus[$i] = Service::where(function ($query) use ($req, $date1, $date2) {
                if ($req->type == 'Tanggal') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($req->type == 'Bulan') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($req->type == 'Tahun') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } else {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                }
                if ($req->branch != '') {
                    $query->where('branch_id', $req->branch);
                }
            })
                ->where('technician_id', $chekSales[$i]->id)
                ->get();
        }
        $sharingProfit1Service = $sharingProfit1Service;
        $sharingProfit2Service = $sharingProfit2Service;
        $sharingProfitSaleSales = $sharingProfitSaleSales;
        $sharingProfitSaleBuyer = $sharingProfitSaleBuyer;
        $karyawan = $chekSales;
        $checkServiceStatus = $checkServiceStatus;
        // return $chekSales;
        $dataPendapatan = Journal::with('ServicePayment.Service', 'Sale')
            // ->where('journals.date', date('Y-m-d'))
            ->where(function ($query) use ($req, $date1, $date2) {
                if ($req->type == 'Tanggal') {
                    $query->where('journals.date', '>=', $date1)->where('journals.date', '<=', $date2);
                } elseif ($req->type == 'Bulan') {
                    $query->where('journals.date', '>=', $date1)->where('journals.date', '<=', $date2);
                } elseif ($req->type == 'Tahun') {
                    $query->where('journals.date', '>=', $date1)->where('journals.date', '<=', $date2);
                } else {
                    $query->where('journals.date', '>=', $date1)->where('journals.date', '<=', $date2);
                }
            })
            ->where(function ($query) {
                $query->where('journals.type', 'Pembayaran Service')->orWhere('journals.type', 'Penjualan');
            })
            ->get();

        $log = Log::limit(7)->get();
        $users = User::count();
        $logCount = Log::where('u_id', Auth::user()->id)->count();

        $totalSharingProfit = 0;
        $totalSharingProfitSplit = [];
        $totalServiceProgress = [];
        $totalServiceDone = [];
        $totalServiceCancel = [];

        for ($i = 0; $i < count($karyawan); $i++) {
            $totalSharingProfit += $sharingProfit1Service[$i] + $sharingProfit2Service[$i] + $sharingProfitSaleSales[$i] + $sharingProfitSaleBuyer[$i];
            $totalSharingProfitSplit[$i]['nama'] = $karyawan[$i]->name;
            $totalSharingProfitSplit[$i]['total'] = $sharingProfit1Service[$i] + $sharingProfit2Service[$i] + $sharingProfitSaleSales[$i] + $sharingProfitSaleBuyer[$i];

            $totalServiceProgress[$i] = 0;
            $totalServiceDone[$i] = 0;
            $totalServiceCancel[$i] = 0;
            $totalServiceFix[$i]['progress'] = 0;
            $totalServiceFix[$i]['done'] = 0;
            $totalServiceFix[$i]['cancel'] = 0;
            $totalServiceFix[$i]['nama'] = $karyawan[$i]->name;

            for ($j = 0; $j < count($checkServiceStatus[$i]); $j++) {
                if ($checkServiceStatus[$i][$j]->work_status == 'Proses' || $checkServiceStatus[$i][$j]->work_status == 'Mutasi' || $checkServiceStatus[$i][$j]->work_status == 'Manifest') {
                    $totalServiceProgress[$i] += 1;
                    $totalServiceFix[$i]['progress'] += 1;
                }
                if ($checkServiceStatus[$i][$j]->work_status == 'Selesai' || $checkServiceStatus[$i][$j]->work_status == 'Diambil') {
                    $totalServiceDone[$i] += 1;
                    $totalServiceFix[$i]['done'] += 1;
                }
                if ($checkServiceStatus[$i][$j]->work_status == 'Cancel' || $checkServiceStatus[$i][$j]->work_status == 'Return') {
                    $totalServiceCancel[$i] += 1;
                    $totalServiceFix[$i]['cancel'] += 1;
                }
            }
        }

        $branchId = $req->branch;
        return view('load-dashboard', [
            // 'log' => $log,
            // 'users' => $users,
            // 'logCount' => $logCount,
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
            'topSales' => $topSales,
            'branchId' => $branchId,
        ]);
    }

    public function filterDataDashboardOwner($type, $date1, $date2, $branch)
    {
        $service = $this->dataService($type, $date1, $date2, $branch);
        $data = $this->labaRugi($type, $date1, $date2, $branch);
        $persediaan = $this->dataPersediaan($branch, $date2);
        $asset = $this->dataAsset($branch, $date2);
        $kas = $this->dataKas($branch, $date1, $date2);
        // return [ 'pendapatanKotor' => $data['pendapatanKotor'],
        //     'pendapatanBersih' => $data['pendapatanBersih'],
        //     'labaBersih' => $data['labaBersih'],
        //     'income' => $data['income'],
        //     'outcome' => $data['outcome'],
        //     'beban' => $data['beban'],
        //     'biaya' => $data['biaya'],
        //     'persediaan' => $persediaan,
        //     'asset' => $asset,
        //     'kas' => $kas,
        //     'service' => $service];
        return view('load-dashboard-owner', [
            'pendapatanKotor' => $data['pendapatanKotor'],
            'pendapatanBersih' => $data['pendapatanBersih'],
            'labaBersih' => $data['labaBersih'],
            'income' => $data['income'],
            'outcome' => $data['outcome'],
            'beban' => $data['beban'],
            'biaya' => $data['biaya'],
            'persediaan' => $persediaan,
            'asset' => $asset,
            'kas' => $kas,
            'service' => $service,
        ]);
    }

    public function labaRugi($type, $date1, $date2, $branch)
    {
        // $date1 = date('Y-m-01');
        // $date2 = date('Y-m-31');

        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $date1)
            ->where('date', '<=', $date2)
            ->get();
        // return $jurnal;

        // $jurnalSebelumnya = Journal::with('JournalDetail', 'JournalDetail.AccountData')->get();

        // return $account;
        // return $accountData;
        $HPP = 0;
        $gaji = 0;
        $totalService = 0;
        $sharingProfit = 0;
        $totalPenjualan = 0;
        $DiskonPenjualan = 0;
        $DiskonService = 0;
        $pendapatanLainLain = 0;
        $income = 0;
        $incomeRaw = [];
        $outcome = 0;
        $outcomeRaw = [];
        $beban = 0;
        $bebanRaw = [];
        $biaya = 0;
        $biayaRaw = [];

        $data = [];
        for ($i = 0; $i < count($jurnal); $i++) {
            // jika tidak memilih cabang
            if ($branch == '') {
                // income
                if ($jurnal[$i]->total != 0) {
                    if ($jurnal[$i]->JournalDetail[0]->accountData->main_detail_id == 29 || $jurnal[$i]->JournalDetail[0]->accountData->main_detail_id == 12 || $jurnal[$i]->JournalDetail[0]->accountData->main_detail_id == 28 || $jurnal[$i]->type == 'Transfer Masuk' || str_contains($jurnal[$i]->ref, 'SMT') || str_contains($jurnal[$i]->ref, 'SIN') || str_contains($jurnal[$i]->ref, 'SOT') || str_contains($jurnal[$i]->ref, 'PCS')) {
                    } else {
                        if (str_contains($jurnal[$i]->code, 'DD')) {
                            $income += $jurnal[$i]->total;
                            array_push($incomeRaw, [$jurnal[$i]->total, $jurnal[$i]->code, $jurnal[$i]->ref, $jurnal[$i]->date]);
                        }
                    }
                }

                // outcome
                if ($jurnal[$i]->total != 0) {
                    if ($jurnal[$i]->JournalDetail[0]->accountData->main_detail_id == 29 || $jurnal[$i]->JournalDetail[0]->accountData->main_detail_id == 12 || $jurnal[$i]->JournalDetail[0]->accountData->main_detail_id == 28 || $jurnal[$i]->type == 'Transfer Masuk' || str_contains($jurnal[$i]->ref, 'SMT') || str_contains($jurnal[$i]->ref, 'SIN') || str_contains($jurnal[$i]->ref, 'SOT') || str_contains($jurnal[$i]->ref, 'SRV') || str_contains($jurnal[$i]->ref, 'PJT') || str_contains($jurnal[$i]->ref, 'PJT')) {
                    } else {
                        if (str_contains($jurnal[$i]->code, 'KK')) {
                            $outcome += $jurnal[$i]->total;
                            array_push($outcomeRaw, [$jurnal[$i]->total, $jurnal[$i]->code, $jurnal[$i]->ref]);
                        }
                    }
                }
            } else {
                // income
                if ($jurnal[$i]->type == 'Transfer Masuk' || str_contains($jurnal[$i]->ref, 'SMT') || str_contains($jurnal[$i]->ref, 'SIN') || str_contains($jurnal[$i]->ref, 'SOT') || (str_contains($jurnal[$i]->ref, 'PCS') && $jurnal[$i]->JournalDetail[0]->AccountData->branch_id == $branch)) {
                } else {
                    if (str_contains($jurnal[$i]->code, 'DD')) {
                        $income += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                }
            }
            for ($j = 0; $j < count($jurnal[$i]->JournalDetail); $j++) {
                $data[] = $jurnal[$i]->JournalDetail[$j]->total;
                if ($branch == '') {
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 30) {
                        $DiskonPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 31) {
                        $DiskonService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29) {
                        $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if (($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 10 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 39) || ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 10 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 46) || ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 10 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 41)) {
                        $pendapatanLainLain += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7) {
                        if (str_contains($jurnal[$i]->JournalDetail[$j]->accountData->name, 'Fee Back Office') || str_contains($jurnal[$i]->JournalDetail[$j]->accountData->name, 'Mutasi') || str_contains($jurnal[$i]->JournalDetail[$j]->accountData->name, 'Transfer') || str_contains($jurnal[$i]->JournalDetail[$j]->accountData->name, 'Biaya HPP')) {
                        } else {
                            $beban += $jurnal[$i]->JournalDetail[$j]->total;

                            array_push($bebanRaw, [$jurnal[$i]->JournalDetail[$j]->total, $jurnal[$i]->code, $jurnal[$i]->ref, $jurnal[$i]->date, $jurnal[$i]->JournalDetail[$j]->accountData->name]);
                        }
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 6) {
                        $biaya += $jurnal[$i]->JournalDetail[$j]->total;

                        array_push($biayaRaw, [$jurnal[$i]->JournalDetail[$j]->total, $jurnal[$i]->code, $jurnal[$i]->ref, $jurnal[$i]->date, $jurnal[$i]->JournalDetail[$j]->accountData->name]);
                    }
                } else {
                    if (($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 6 || $jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 5) && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $totalService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->AccountData->main_detail_id == 27 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $totalPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 30 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $DiskonPenjualan += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 31 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $DiskonService += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $HPP += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 15 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $gaji += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 14 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        $sharingProfit += $jurnal[$i]->JournalDetail[$j]->total;
                    }

                    if (($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 10 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 39) || ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 10 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 46) || ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 10 && $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 41 && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch)) {
                        $pendapatanLainLain += $jurnal[$i]->JournalDetail[$j]->total;
                    }
                    // beban
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_id == 7 && ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id != 28 || $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id != 29) && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch) {
                        if ($jurnal[$i]->JournalDetail[$j]->accountData->debet_kredit == 'D') {
                            $beban += $jurnal[$i]->JournalDetail[$j]->total;
                        } else {
                            $beban -= $jurnal[$i]->JournalDetail[$j]->total;
                        }
                    }

                    // outcome
                    if ($jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 29 || $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 12 || $jurnal[$i]->JournalDetail[$j]->accountData->main_detail_id == 28 || $jurnal[$i]->type == 'Transfer Masuk' || str_contains($jurnal[$i]->ref, 'SMT') || str_contains($jurnal[$i]->ref, 'SIN') || str_contains($jurnal[$i]->ref, 'SOT') || str_contains($jurnal[$i]->ref, 'SRV') || (str_contains($jurnal[$i]->ref, 'PJT') && $jurnal[$i]->JournalDetail[$j]->AccountData->branch_id == $branch)) {
                    } else {
                        if (str_contains($jurnal[$i]->code, 'KK')) {
                            $outcome += $jurnal[$i]->JournalDetail[$j]->total;
                        }
                    }
                }
            }
        }
        // return [$totalService,$DiskonService,$totalPenjualan,$DiskonPenjualan,$pendapatanLainLain,$HPP];

        $pendapatanKotor = $totalService - $DiskonService + $totalPenjualan - $DiskonPenjualan + $pendapatanLainLain;
        $pendapatanBersih = $totalService - $DiskonService + $totalPenjualan - $DiskonPenjualan + $pendapatanLainLain - $HPP;
        $labaBersih = $totalService - $DiskonService + $totalPenjualan - $DiskonPenjualan + $pendapatanLainLain - $HPP - $beban - $biaya;
        return [
            'pendapatanKotor' => $pendapatanKotor,
            'pendapatanBersih' => $pendapatanBersih,
            'labaBersih' => $labaBersih,
            'income' => $income,
            'outcome' => $outcome,
            'beban' => $beban,
            'biaya' => $biaya,
        ];
        // return view('pages.backend.report.reportIncomeStatement', compact('HPP', 'gaji', 'sharingProfit', 'totalService', 'totalPenjualan', 'DiskonPenjualan', 'DiskonService', 'dataBiaya', 'dataBeban', 'branch','dataPendapatanLainLain','dataPenyusutan','date1','date2'));
    }

    public function dataKas($branch, $date1, $date2)
    {
        $accountData = AccountData::where('main_id', 1)->get();

        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData', 'JournalDetail.AccountData.AccountMainDetail')
            ->where('date', '<=', date('Y-m-t', strtotime($date2)))
            // ->where('date', '>=', date('Y-m-01', strtotime($req->dateS)))
            ->get();

        $data = [];
        for ($i = 0; $i < count($accountData); $i++) {
            if (
                $accountData[$i]->opening_date <= date('Y-m-t', strtotime($date2))
                // && $accountData[$i]->opening_date >= date('Y-m-01', strtotime($req->dateS))
            ) {
                $data[$i]['total'] = $accountData[$i]->opening_balance;
            } else {
                $data[$i]['total'] = 0;
            }
            $data[$i]['akun'] = $accountData[$i]->main_detail_id;
            $data[$i]['branch'] = $accountData[$i]->branch_id;
            $data[$i]['namaAkun'] = $accountData[$i]->AccountMainDetail->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountData[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountData[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $data[$i]['total'] += $jurnal[$j]->total;
                        } else {
                            $data[$i]['total'] -= $jurnal[$j]->total;
                        }
                    }
                }
            }
        }
        $dataKas = [];
        $kasKecil = 0;
        $kasBankJago = 0;
        $kasBankBCA = 0;
        $kasBesar = 0;
        for ($i = 0; $i < count($data); $i++) {
            if ($branch == '') {
                if ($data[$i]['namaAkun'] == 'Kas Kecil') {
                    $kasKecil += $data[$i]['total'];
                }
                if ($data[$i]['namaAkun'] == 'Kas Bank Jago') {
                    $kasBankJago += $data[$i]['total'];
                }
                if ($data[$i]['namaAkun'] == 'Kas Bank BCA') {
                    $kasBankBCA += $data[$i]['total'];
                }
                if ($data[$i]['namaAkun'] == 'Kas Besar') {
                    $kasBesar += $data[$i]['total'];
                }
            } else {
                if ($data[$i]['namaAkun'] == 'Kas Kecil') {
                    $kasKecil += $data[$i]['total'];
                }
                if ($data[$i]['namaAkun'] == 'Kas Bank Jago') {
                    $kasBankJago += $data[$i]['total'];
                }
                if ($data[$i]['namaAkun'] == 'Kas Bank BCA') {
                    $kasBankBCA += $data[$i]['total'];
                }
                if ($data[$i]['namaAkun'] == 'Kas Besar') {
                    $kasBesar += $data[$i]['total'];
                }
            }
        }
        $dataKas = ['Kas Kecil' => $kasKecil, 'Kas Bank Jago' => $kasBankJago, 'Kas Bank BCA' => $kasBankBCA, 'Kas Besar' => $kasBesar];
        return $dataKas;
    }

    public function dataPersediaan($branch, $date)
    {
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '<=', $date)
            ->get();

        $accountData = AccountData::where('main_id', 3)
            ->where(function ($q) use ($branch) {
                if ($branch == '') {
                } else {
                    $q->where('branch_id', $branch);
                }
            })
            ->get();

        $dataKas = [];
        $total = 0;
        $totalcek = 0;
        for ($i = 0; $i < count($accountData); $i++) {
            if ($accountData[$i]->opening_date <= $date) {
                $dataKas[$i]['total'] = $accountData[$i]->opening_balance;
                $totalcek = $accountData[$i]->opening_balance;
            } else {
                $dataKas[$i]['total'] = 0;
                $totalcek = 0;
            }
            $dataKas[$i]['akun'] = $accountData[$i]->main_detail_id;
            $dataKas[$i]['akun_nama'] = $accountData[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountData[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountData[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataKas[$i][$j]['jurnal_name']  = $jurnal[$j]->JournalDetail[$k]->AccountData->name;
                        // $dataKas[$i][$j]['jurnal_id']    = $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id;
                        // $dataKas[$i][$j]['jurnal_id']    = $jurnal[$j]->ref;

                        // $dataKas[$i][$j]['jurnal_dk']    = $jurnal[$j]->JournalDetail[$k]->debet_kredit;

                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataKas[$i]['total'] += $jurnal[$j]->total;
                            $dataKas[$i][$j]['jurnal_total'] = [$jurnal[$j]->ref, $jurnal[$j]->total, date('d F Y', strtotime($jurnal[$j]->date)), number_format($totalcek += $jurnal[$j]->total, 0, ',', '.')];
                        } else {
                            $dataKas[$i]['total'] -= $jurnal[$j]->total;
                            $dataKas[$i][$j]['jurnal_total'] = [$jurnal[$j]->ref, $jurnal[$j]->total, date('d F Y', strtotime($jurnal[$j]->date)), number_format($totalcek -= $jurnal[$j]->total, 0, ',', '.')];
                        }
                    }
                }
            }
            $total += $dataKas[$i]['total'];
        }
        return $total;
    }

    public function dataAsset($branch, $date)
    {
        $jurnal = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '<=', $date)
            ->get();

        $accountDataAsset = AccountData::where('main_id', 13)
            ->where(function ($q) use ($branch) {
                if ($branch == '') {
                } else {
                    $q->where('branch_id', $branch);
                }
            })
            ->get();

        $dataAsset = [];
        $total = 0;
        for ($i = 0; $i < count($accountDataAsset); $i++) {
            $dataAsset[$i]['total'] = 0;
            // $dataAsset[$i]['akun'] = $accountDataAsset[$i]->main_detail_id;
            // $dataAsset[$i]['namaAkun'] = $accountDataAsset[$i]->name;
            $dataAsset[$i]['jurnal'] = [];
            $dataAsset[$i]['dk'] = [];
            $dataAsset[$i]['code'] = [];
            $dataAsset[$i]['akun'] = $accountDataAsset[$i]->main_detail_id;
            $dataAsset[$i]['akun_nama'] = $accountDataAsset[$i]->name;
            for ($j = 0; $j < count($jurnal); $j++) {
                for ($k = 0; $k < count($jurnal[$j]->JournalDetail); $k++) {
                    if ($accountDataAsset[$i]->main_detail_id == $jurnal[$j]->JournalDetail[$k]->AccountData->main_detail_id && $accountDataAsset[$i]->branch_id == $jurnal[$j]->JournalDetail[$k]->AccountData->branch_id) {
                        // $dataAsset[$i]['jurnal'][$j]['jurnalDetail'][$k] = $jurnal[$j];
                        array_push($dataAsset[$i]['jurnal'], $jurnal[$j]->JournalDetail[$k]->total);
                        // array_push($dataAsset[$i]['dk'],[$jurnal[$j]->JournalDetail[$k]->debet_kredit,$jurnal[$j]->code]);
                        array_push($dataAsset[$i]['dk'], $jurnal[$j]->JournalDetail[$k]->debet_kredit);
                        array_push($dataAsset[$i]['code'], [$jurnal[$j]->ref, $jurnal[$j]->code, $jurnal[$j]->JournalDetail[$k]->total]);
                        if ($jurnal[$j]->JournalDetail[$k]->debet_kredit == 'D') {
                            $dataAsset[$i]['total'] += $jurnal[$j]->JournalDetail[$k]->total;
                        } else {
                            $dataAsset[$i]['total'] -= $jurnal[$j]->JournalDetail[$k]->total;
                        }
                    }
                }
            }
            $total += $dataAsset[$i]['total'];
        }
        return $total;
    }

    public function checkSharingProfit()
    {
        $chekSales = Employee::with('Service1', 'Service2')
            ->where('status', 'aktif')
            ->where('id', '!=', 1)
            ->get();

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

    public function dataService($type, $date1, $date2, $branch)
    {
        // $date1 = date('2022-10-01');
        // $date2 = date('2022-10-01');
        
        $belumDiambilSum = Service::select('total_price')->where('work_status','Selesai')->where(function ($query) use ($branch) {
            if ($branch != '') {
                $query->where('branch_id', $branch);
            }
        })->sum('total_price');


        $employee = Employee::where('status','aktif')->get();

        $serviceProgress = Service::select('code','brand','technician_id','technician_replacement_id')       
            ->with(['Employee1', 'Employee2', 'CreatedByUser', 'Type', 'Brand'])
            ->whereIn('work_status', ['Proses', 'Manifest','Mutasi'])
            ->where(function ($query) use ($branch) {
                if ($branch != '') {
                    $query->where('branch_id', $branch);
                }
            })
            ->orderBy('id', 'desc')
            ->get();

        $dataService = [];
        for ($i=0; $i <count($employee) ; $i++) {
            $dataService[$i]['nama'] = $employee[$i]->name;
            $dataService[$i]['total'] = 0;

            for ($j=0; $j <count($serviceProgress) ; $j++) {
                if ($employee[$i]->id == $serviceProgress[$j]->technician_id) {
                    $dataService[$i]['service'][] = $serviceProgress[$j]->code;
                    $dataService[$i]['total'] += 1;
                }
                if ($employee[$i]->id == $serviceProgress[$j]->technician_replacement_id) {
                    $dataService[$i]['service'][] = $serviceProgress[$j]->code;
                    $dataService[$i]['total'] += 1;
                }
            }
        }
        // return $dataService;

        $belumDiambilCount = Service::where('work_status','Selesai')->where(function ($query) use ($branch) {
            if ($branch != '') {
                $query->where('branch_id', $branch);
            }
        })->count();

        $dataServiceHandphone = Service::where('type', '11')
            ->where(function ($query) use ($type, $date1, $date2, $branch) {
                if ($type == 'Tanggal') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($type == 'Bulan') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } elseif ($type == 'Tahun') {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                } else {
                    $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
                }

                if ($branch != '') {
                    $query->where('branch_id', $branch);
                }
            })
            ->count();

        $dataServiceLaptop = Service::where('type', '10')->where(function ($query) use ($type, $date1, $date2, $branch) {
            if ($type == 'Tanggal') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } elseif ($type == 'Bulan') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } elseif ($type == 'Tahun') {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            } else {
                $query->where('created_at', '>=', $date1 . ' 00:00:00')->where('created_at', '<=', $date2 . ' 23:59:59');
            }

            if ($branch != '') {
                $query->where('branch_id', $branch);
            }
        })->count();

        return [
                'serviceHandphone'=> $dataServiceHandphone,
                'serviceLaptop'=> $dataServiceLaptop,
                'belumDiambilSum'=> $belumDiambilSum,
                'belumDiambilCount'=> $belumDiambilCount,
                'dataService'=>$dataService,
               ];
    }

    public function log(Request $req)
    {
        if ($req->ajax()) {
            $data = Log::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('added_at', function ($row) {
                    return date('d-M-Y H:m', strtotime($row->added_at));
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
            'added_at' => date('Y-m-d H:i:s'),
        ]);
    }
    public function changeMonthIdToEn($dateLocale)
    {
        $separateString = explode(' ', $dateLocale);
        $day = $separateString[0];
        $monthLocale = $separateString[1];
        $year = $separateString[2];

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
        $data = [];
        foreach ($validator as $message) {
            array_push($data, $message);
        }
        return $data;
    }

    public function createCode($string, $table)
    {
        $getEmployee = Employee::with('branch')
            ->where('user_id', Auth::user()->id)
            ->first();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table($table)->max('id') + 1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $string . $getEmployee->Branch->code . $year . $month . $index;
    }
    public function cekHakAkses($namaFitur, $namaPerintah)
    {
        return $this->newvaruser->akses($namaFitur, $namaPerintah);
    }
    public function rubahLinkMenu()
    {
        $menu = SubMenu::get();
        $rep = [];
        $hov = [];
        for ($i = 0; $i < count($menu); $i++) {
            $rep[$i]['id'] = $menu[$i]->id;
            $rep[$i]['url'] = str_replace('https://andromartindonesia.com', 'http://127.0.0.1:8000', $menu[$i]->url);
            $rep[$i]['hov'] = str_replace('https://andromartindonesia.com', 'http://127.0.0.1:8000', $menu[$i]->url);
        }

        for ($i = 0; $i < count($rep); $i++) {
            SubMenu::where('id', $rep[$i]['id'])->update([
                'url' => $rep[$i]['url'],
                'hover' => [$rep[$i]['hov']],
            ]);
        }

        // return $hov;
        // return $rep;
        // return $menu;
    }
    public function selarasJurnalLoss(Type $var = null)
    {
        # code...
    }
}
