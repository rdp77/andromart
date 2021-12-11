<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Employee;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\Purchasing;
use App\Models\PurchasingDetail;
use App\Models\HistoryDetailPurchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ReportPurchaseController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function reportPurchase()
    {
        return view('pages.backend.report.reportPurchase');
    }

    public function searchReportPurchase(Request $req)
    {
        // return $req->all();
        // $data = Journal::with('JournalDetail','JournalDetail.AccountData')
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])
        ->where('date','>=',$this->DashboardController->changeMonthIdToEn($req->dateS))
        ->where('date','<=',$this->DashboardController->changeMonthIdToEn($req->dateE))
        // ->whereBetween('date', [$this->DashboardController->changeMonthIdToEn($req->dateS), $this->DashboardController->changeMonthIdToEn($req->dateE)])
        ->get();

        if(count($data) == 0){
            $message = 'empty';
        }else{
            $message = 'exist';
        }
        return $data;
        return Response::json(['status' => 'success','result'=>$data,'message'=>$message]);
    }
    public function changeDate($date) {
        $array = explode(' ', $date);
        $month = ['bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthNumber = array_search($array[1], $month);
        $output = $array[2]."-".$monthNumber."-".$array[0];
        return $output;
    }
    public function dataLoad(Request $req)
    {
        $startDate = $this->changeDate($req->startDate)." 00:00:00";
        $endDate = $this->changeDate($req->endDate)." 23:59:59";
        $data = Purchasing::whereBetween('date', [$startDate, $endDate])->with('purchasingDetail')->get();
        return view('pages.backend.report.reportPurchaseLoad')->with('data', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
