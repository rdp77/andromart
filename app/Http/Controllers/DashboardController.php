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
        $this->newvaruser = new User;
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
            ->select(
                'items.id',
                'items.name',
                'items.brand_id',
                'sale_details.item_id',
                DB::raw('SUM(sale_details.qty) as total')
            )
            ->groupBy('items.id', 'sale_details.item_id', 'items.name', 'items.brand_id',)
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();


        // return $topSales;

        $dataTrafficToday = DB::table('traffic')->where('date', date('Y-m-d'))->count();
        $dataServiceTotal = Service::where('created_at','like','%'.  date('Y-m-d').'%')->count();
        $dataServiceHandphone = Service::where('type', '11')->where('created_at','like','%'. date('Y-m-d').'%')->count();
        $dataServiceLaptop = Service::where('type', '10')->where('created_at','like','%'. date('Y-m-d').'%')->count();
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
        $topSales = DB::table('sale_details')
            ->leftJoin('items', 'items.id', '=', 'sale_details.item_id')
            ->select(
                'items.id',
                'items.name',
                'items.brand_id',
                'sale_details.item_id',
                DB::raw('SUM(sale_details.qty) as total')
            )
            ->where(function ($query) use ($req) {
                if ($req->type == 'Tanggal') {
                    $query
                        ->where('sale_details.created_at', '>=', $this->changeMonthIdToEn($req->startDate))
                        ->where('sale_details.created_at', '<=', $this->changeMonthIdToEn($req->endDate));
                } else if ($req->type == 'Bulan') {
                    $query
                        ->where('sale_details.created_at', '>=', date('Y-m-01 00:i:s', strtotime($req->month)))
                        ->where('sale_details.created_at', '<=', date('Y-m-t 00:i:s', strtotime($req->month)));
                } else if ($req->type == 'Tahun') {
                    $query
                        ->where('sale_details.created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                        ->where('sale_details.created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                }
                
                
            })
            ->groupBy('items.id', 'sale_details.item_id', 'items.name', 'items.brand_id',)
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $dataTrafficToday = DB::table('traffic')->where(function ($query) use ($req) {
            if ($req->type == 'Tanggal') {
                $query
                    ->where('date', '>=', $this->changeMonthIdToEn($req->startDate))
                    ->where('date', '<=', $this->changeMonthIdToEn($req->endDate));
            } else if ($req->type == 'Bulan') {
                $query
                    ->where('date', '>=', date('Y-m-01', strtotime($req->month)))
                    ->where('date', '<=', date('Y-m-t', strtotime($req->month)));
            } else if ($req->type == 'Tahun') {
                $query
                    ->where('date', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                    ->where('date', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
            }
        })->count();
        $dataServiceTotal = Service::where(function ($query) use ($req) {
            if ($req->type == 'Tanggal') {
                $query
                    ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                    ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
            } else if ($req->type == 'Bulan') {
                $query
                    ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                    ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
            } else if ($req->type == 'Tahun') {
                $query
                    ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                    ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
            }

            if ($req->branch != '') {
                $query
                    ->where('branch_id',$req->branch);
            }
        })->count();

        // return $this->changeMonthIdToEn($req->startDate). ' 00:00:00';
        $dataServiceHandphone = Service::where('type', '11')->where(function ($query) use ($req) {
            if ($req->type == 'Tanggal') {
                $query
                    ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                    ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
            } else if ($req->type == 'Bulan') {
                $query
                    ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                    ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
            } else if ($req->type == 'Tahun') {
                $query
                    ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                    ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
            }
            if ($req->branch != '') {
                $query
                    ->where('branch_id',$req->branch);
            }
        })->count();
        
        $dataServiceLaptop = Service::where('type', '10')->where(function ($query) use ($req) {
            if ($req->type == 'Tanggal') {
                $query
                    ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                    ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
            } else if ($req->type == 'Bulan') {
                $query
                    ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                    ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
            } else if ($req->type == 'Tahun') {
                $query
                    ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                    ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
            }
            if ($req->branch != '') {
                $query
                    ->where('branch_id',$req->branch);
            }
        })->count();

        $chekSales = Employee::with('Service1', 'Service2')->where('id', '!=', 1)->get();
        for ($i = 0; $i < count($chekSales); $i++) {
            $sharingProfit1Service[$i] = Service::where('work_status', 'Diambil')
                ->where(function ($query) use ($req) {
                    if ($req->type == 'Tanggal') {
                        $query
                            ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                            ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
                    } else if ($req->type == 'Bulan') {
                        $query
                            ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                            ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
                    } else if ($req->type == 'Tahun') {
                        $query
                            ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                            ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                    }
                    if ($req->branch != '') {
                        $query
                            ->where('branch_id',$req->branch);
                    }
                })
                ->where('payment_status', 'Lunas')
                ->where('technician_id', $chekSales[$i]->id)
                ->sum('sharing_profit_technician_1');

            $sharingProfit2Service[$i] = Service::where('work_status', 'Diambil')
                ->where(function ($query) use ($req) {
                    if ($req->type == 'Tanggal') {
                        $query
                            ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                            ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
                    } else if ($req->type == 'Bulan') {
                        $query
                            ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                            ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
                    } else if ($req->type == 'Tahun') {
                        $query
                            ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                            ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                    }

                    if ($req->branch != '') {
                        $query
                            ->where('branch_id',$req->branch);
                    }
                })
                ->where('payment_status', 'Lunas')
                ->where('technician_replacement_id', $chekSales[$i]->id)
                ->sum('sharing_profit_technician_2');
            $sharingProfitSaleSales[$i] = SaleDetail::where('sales_id', $chekSales[$i]->id)
                ->where(function ($query) use ($req) {
                    if ($req->type == 'Tanggal') {
                        $query
                            ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                            ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
                    } else if ($req->type == 'Bulan') {
                        $query
                            ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                            ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
                    } else if ($req->type == 'Tahun') {
                        $query
                            ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                            ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                    }
                })
                ->sum('sharing_profit_sales');
            $sharingProfitSaleBuyer[$i] = SaleDetail::where('buyer_id', $chekSales[$i]->id)
                ->where(function ($query) use ($req) {
                    if ($req->type == 'Tanggal') {
                        $query
                            ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                            ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
                    } else if ($req->type == 'Bulan') {
                        $query
                            ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                            ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
                    } else if ($req->type == 'Tahun') {
                        $query
                            ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                            ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                    }
                })
                ->sum('sharing_profit_buyer');
            $checkServiceStatus[$i] = Service::where(function ($query) use ($req) {
                if ($req->type == 'Tanggal') {
                    $query
                        ->where('created_at', '>=', $this->changeMonthIdToEn($req->startDate). ' 00:00:00')
                        ->where('created_at', '<=', $this->changeMonthIdToEn($req->endDate). ' 23:59:59');
                } else if ($req->type == 'Bulan') {
                    $query
                        ->where('created_at', '>=', date('Y-m-01', strtotime($req->month)))
                        ->where('created_at', '<=', date('Y-m-t', strtotime($req->month)));
                } else if ($req->type == 'Tahun') {
                    $query
                        ->where('created_at', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                        ->where('created_at', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                }
                if ($req->branch != '') {
                        $query
                            ->where('branch_id',$req->branch);
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
            ->where(function ($query) use ($req) {
                if ($req->type == 'Tanggal') {
                    $query
                        ->where('journals.date', '>=', $this->changeMonthIdToEn($req->startDate))
                        ->where('journals.date', '<=', $this->changeMonthIdToEn($req->endDate));
                } else if ($req->type == 'Bulan') {
                    $query
                        ->where('journals.date', '>=', date('Y-m-01', strtotime($req->month)))
                        ->where('journals.date', '<=', date('Y-m-t', strtotime($req->month)));
                } else if ($req->type == 'Tahun') {
                    $query
                        ->where('journals.date', '>=', date('Y-m-d 00:i:s', strtotime('first day of january ' . $req->year)))
                        ->where('journals.date', '<=', date('Y-m-t 00:i:s', strtotime('first day of december ' . $req->year)));
                }
                
            })
            ->where(function ($query) {
                $query->where('journals.type', 'Pembayaran Service')
                    ->orWhere('journals.type', 'Penjualan');
            })
            // ->where(function ($query) use ($req) {
            //     if ($req->branch != '') {
            //         $query
            //             ->where('service_payment.service.branch_id',$req->branch);
            //     }
            //     if ($req->branch != '') {
            //         $query
            //             ->where('Sale.branch_id',$req->branch);
            //     }
            // })
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

        // $totalKeseluruhanPendapatanService = 0;
        // $totalKeseluruhanPendapatanSale = 0;
        // $totalCash = 0;
        // $totalDebit = 0;
        // $totalTransfer = 0;
        // foreach ($dataPendapatan as $i => $el) {
        //     if ($el->type == 'Pembayaran Service') {

        //         if ($req->branch != '') {
        //             if ($el->ServicePayment->Service->branch_id == $req->branch) {
        //                 $totalKeseluruhanPendapatanService += $el->total;
        //             }
        //         }else{
        //             $totalKeseluruhanPendapatanService += $el->total;
        //         }

        //         if ($el->ServicePayment->payment_method == 'Cash') {
        //             if ($req->branch != '') {
        //                 if ($el->ServicePayment->Service->branch_id == $req->branch) {
        //                     $totalCash += $el->total;
        //                 }
        //             }else{
        //                 $totalCash += $el->total;
        //             }
        //         } elseif ($el->ServicePayment->payment_method == 'Debit') {
        //             if ($req->branch != '') {
        //                 if ($el->ServicePayment->Service->branch_id == $req->branch) {
        //                     $totalDebit += $el->total;
        //                 }
        //             }else{
        //                 $totalDebit += $el->total;
        //             }
        //         } elseif ($el->ServicePayment->payment_method == 'Transfer') {
        //             if ($req->branch != '') {
        //                 if ($el->ServicePayment->Service->branch_id == $req->branch) {
        //                     $totalTransfer += $el->total;
        //                 }
        //             }else{
        //                 $totalTransfer += $el->total;
        //             }
        //         }
        //     } elseif ($el->type == 'Penjualan') {
        //         if ($req->branch != '') {
        //             if ($el->sale->branch_id == $req->branch) {
        //                 $totalKeseluruhanPendapatanSale += $el->total;
        //             }
        //         }else{
        //             $totalKeseluruhanPendapatanSale += $el->total;
        //         }

        //         if ($el->sale->payment_method == 'Cash') {
        //             if ($req->branch != '') {
        //                 if ($el->sale->branch_id == $req->branch) {
        //                     $totalCash += $el->total;
        //                 }
        //             }else{
        //                 $totalCash += $el->total;
        //             }
                    
        //         } elseif ($el->sale->payment_method == 'Debit') {
        //             if ($req->branch != '') {
        //                 if ($el->sale->branch_id == $req->branch) {
        //                     $totalDebit += $el->total;
        //                 }
        //             }else{
        //                 $totalDebit += $el->total;
        //             }
                   
        //         } elseif ($el->sale->payment_method == 'Transfer') {
        //             if ($req->branch != '') {
        //                 if ($el->sale->branch_id == $req->branch) {
        //                     $totalTransfer += $el->total;
        //                 }
        //             }else{
        //                 $totalTransfer += $el->total;
        //             }
                                
        //         }
                    
        //     }
        // }
        // return $totalKeseluruhanPendapatanService;
        // return 'as';
        // return [$totalKeseluruhanPendapatanService,$totalKeseluruhanPendapatanSale,($totalKeseluruhanPendapatanService+$totalKeseluruhanPendapatanSale)];
        // return Response::json([
        //     'status' => 'success',
        //     'totalKeseluruhanPendapatan' => 'Rp. '.number_format($totalKeseluruhanPendapatan, 0, ',', '.'),
        //     'totalCash' =>  'Rp. '.number_format($totalCash, 0, ',', '.'),
        //     'totalDebit' => 'Rp. '.number_format($totalDebit, 0, ',', '.'),
        //     'totalTransfer' => 'Rp. '.number_format($totalTransfer, 0, ',', '.'),
        //     'topSales' => $topSales,
        //     'sharingProfit1Service' => $sharingProfit1Service,
        //     'sharingProfit2Service' => $sharingProfit2Service,
        //     'sharingProfitSaleSales' => $sharingProfitSaleSales,
        //     'sharingProfitSaleBuyer' => $sharingProfitSaleBuyer,
        //     'dataTraffic' => $dataTrafficToday,
        //     'dataServiceTotal' => $dataServiceTotal,
        //     'dataServiceHandphone' => $dataServiceHandphone,
        //     'dataServiceLaptop' => $dataServiceLaptop,
        //     'totalServiceProgress' => $totalServiceProgress,
        //     'totalServiceDone' => $totalServiceDone,
        //     'totalServiceCancel' => $totalServiceCancel,
        //     'totalServiceFix' => $totalServiceFix,
        //     'totalSharingProfitSplit' => $totalSharingProfitSplit,
        //     'totalSharingProfit' => 'Rp. '.number_format($totalSharingProfit, 0, ',', '.'),
        // ]);
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

    public function checkSharingProfit()
    {
        $chekSales = Employee::with('Service1', 'Service2')
        ->where('status','aktif')
        ->where('id', '!=', 1)->get();
        
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
    public function cekHakAkses($namaFitur, $namaPerintah)
    {
        return $this->newvaruser->akses($namaFitur, $namaPerintah);
    }
    public function rubahLinkMenu()
    {
        $menu = SubMenu::get();
        $rep = [];
        $hov = [];
        for ($i=0; $i <count($menu) ; $i++) { 
            $rep[$i]['id'] = $menu[$i]->id;
            $rep[$i]['url'] = str_replace("https://andromartindonesia.com","http://127.0.0.1:8000",$menu[$i]->url);
            $rep[$i]['hov'] = str_replace("https://andromartindonesia.com","http://127.0.0.1:8000",$menu[$i]->url);
        }

        for ($i=0; $i <count($rep) ; $i++) { 
            SubMenu::where('id',$rep[$i]['id'])->update([
                'url'=>$rep[$i]['url'],
                'hover'=>[$rep[$i]['hov']],
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
