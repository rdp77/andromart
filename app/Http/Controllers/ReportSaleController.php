<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Employee;
use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ReportSaleController extends Controller
{
    public function __construct(DashboardController $dashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $dashboardController;
    }

    public function index()
    {

    }

    public function reportSale()
    {
        // $data = Journal::with('JournalDetail')->get();
        $data = Sale::with(['SaleDetail', 'SaleDetail.Item', 'accountData'])->get();
        // return $data;

        return view('pages.backend.report.reportSale', compact('data'));
    }

    public function searchReportSale(Request $req)
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
