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
use App\Models\Sale;
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

    public function index()
    {
        //
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
