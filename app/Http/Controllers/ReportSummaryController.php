<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Warranty;
use App\Models\SharingProfit;
use App\Models\SharingProfitDetail;
use App\Models\ServiceDetail;
use App\Models\ServiceStatusMutation;
use App\Models\Branch;
use App\Models\Journal;
use App\Models\JournalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;
// use DB;

class ReportSummaryController extends Controller
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

    public function reportSummary(Request $req)
    {
        $data = Journal::with('JournalDetail')->get();
        $branch = Branch::get();
        if ($req->startDate == null || $req->startDate == '') {
            $startDate = date('Y-03-07');
        } else {
            $startDate = $this->DashboardController->changeMonthIdToEn($req->startDate);
        }
        if ($req->endDate == null || $req->endDate == '') {
            $endDate = date('Y-03-07');
        } else {
            $endDate = $this->DashboardController->changeMonthIdToEn($req->endDate);
        }

        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
        // return $data;
        // return [$startDate,$endDate];
        // return $dateStart;
        $totalPenjualan = 0;
        $totalDiskonPenjualan = 0;
        $totalService = 0;
        $totalDiskonService = 0;
        $totalPembelian = 0;
        $totalPengeluaran = 0;
        if ($req->cabang == null || $req->cabang == '') {
            // return 'aas';
            $cabang = '-';
        }else{
            // return 'as';
            $cabang = $req->cabang;

        }
        // return $cabang;
        // return $data;
        // return $data[0]->JournalDetail[0]->AccountData;
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]->JournalDetail); $j++) {
                // if ($data[$i]->JournalDetail[$j]->AccountData == '12' || $data[$i]->JournalDetail[$j]->AccountData == '29') {
                // }else{
                if ($cabang != '-') {
                    if ($data[$i]->JournalDetail[$j]->AccountData->branch_id == $req->cabang) {
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '5') {
                            $totalService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '31') {
                            $totalDiskonService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                            $totalPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '30') {
                            $totalDiskonPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '11') {
                            $totalPembelian += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '14' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '15' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '16' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '17' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '18') {
                            $totalPengeluaran += $data[$i]->JournalDetail[$j]->total;
                        }
                    }
                }else{
                    if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '5') {
                            $totalService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '31') {
                            $totalDiskonService += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '27') {
                            $totalPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '30') {
                            $totalDiskonPenjualan += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '11') {
                            $totalPembelian += $data[$i]->JournalDetail[$j]->total;
                        }
                        if ($data[$i]->JournalDetail[$j]->AccountData->main_id == '6' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '14' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '15' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '16' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '17' || $data[$i]->JournalDetail[$j]->AccountData->main_detail_id == '18') {
                            $totalPengeluaran += $data[$i]->JournalDetail[$j]->total;
                        }
                }

                // }S
            }
        }
        // return $data;
        // return [$totalPenjualan,$totalPembelian];
        return view('pages.backend.report.reportSummary', compact('branch', 'totalPenjualan', 'totalPembelian', 'totalPengeluaran', 'totalDiskonPenjualan', 'totalService', 'totalDiskonService'));
    }
    public function searchReportSummary(Request $req)
    {
        // return $req->all();
        $data = Journal::with('JournalDetail', 'JournalDetail.AccountData')
            ->where('date', '>=', $this->DashboardController->changeMonthIdToEn($req->dateS))
            ->where('date', '<=', $this->DashboardController->changeMonthIdToEn($req->dateE))
            // ->where(function ($query) {
            // return $query->where('this_too', 'LIKE', '%fake%');
            // })
            ->get();

        if (count($data) == 0) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message, 'tipe' => $req->tipe, 'cabang' => $req->cabang]);
    }

    public function store(Request $req)
    {
        // return $req->all();
        $checkData = SharingProfit::where('date_start', $this->DashboardController->changeMonthIdToEn($req->startDate))
            ->where('date_end', $this->DashboardController->changeMonthIdToEn($req->endDate))
            ->where('employe_id', $req->technicianId)
            ->get();
        if (count($checkData) != 0) {
            return Response::json(['status' => 'fail', 'message' => 'Data Sudah Ada']);
        }
        $index = DB::table('sharing_profit')->max('id') + 1;
        SharingProfit::create([
            'id' => $index,
            'date' => date('Y-m-d'),
            'date_start' => $this->DashboardController->changeMonthIdToEn($req->startDate),
            'date_end' => $this->DashboardController->changeMonthIdToEn($req->endDate),
            'employe_id' => $req->technicianId,
            'total' => $req->totalValue,
            'created_by' => Auth::user()->name,
            'created_at' => date('Y-m-d h:i:s'),
        ]);

        for ($i = 0; $i < count($req->idDetail); $i++) {
            SharingProfitDetail::create([
                'id' => $i + 1,
                'sharing_profit_id' => $index,
                'service_id' => $req->idDetail[$i],
                'total' => $req->totalDetail[$i],
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        }
        return Response::json(['status' => 'success', 'message' => 'Data Tersimpan']);
    }

    public function edit($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.editService', ['Service' => $Service, 'member' => $member]);
    }
    public function printService($id)
    {
        $Service = Service::find($id);
        $member = User::get();
        return view('pages.backend.transaction.service.printService', ['Service' => $Service, 'member' => $member]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog($req->header('user-agent'), $req->ip(), 'Menghapus Data Kredit');
        ServiceDetail::where('service_id', $id)->destroy($id);
        return Response::json(['status' => 'success']);
    }
    public function serviceFormUpdateStatus()
    {
        $data = Service::where('technician_id', Auth::user()->id)->get();
        $employee = Employee::get();
        return view('pages.backend.transaction.service.indexFormUpdateService', compact('data', 'employee'));
    }
    public function serviceFormUpdateStatusLoadData(Request $req)
    {
        $data = Service::with(['ServiceDetail', 'ServiceDetail.Items', 'ServiceStatusMutation', 'ServiceStatusMutation.Technician'])
            ->where('id', $req->id)
            ->first();

        if ($data == null) {
            $message = 'empty';
        } else {
            $message = 'exist';
        }

        return Response::json(['status' => 'success', 'result' => $data, 'message' => $message]);
    }

    public function serviceFormUpdateStatusSaveData(Request $req)
    {
        try {
            // return $req->all();
            $index = ServiceStatusMutation::where('service_id', $req->id)->count() + 1;
            if ($req->status == 'Mutasi') {
                $technician_replacement_id = $req->technicianId;
            } else {
                $technician_replacement_id = null;
            }

            Service::where('id', $req->id)->update([
                'work_status' => $req->status,
                'technician_replacement_id' => $technician_replacement_id,
            ]);
            ServiceStatusMutation::create([
                'service_id' => $req->id,
                'technician_id' => Auth::user()->id,
                'index' => $index,
                'status' => $req->status,
                'description' => $req->description,
                'created_by' => Auth::user()->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            return Response::json(['status' => 'success', 'message' => 'Sukses Menyimpan Data']);
        } catch (\Throwable $th) {
            return Response::json(['status' => 'error', 'message' => $th]);
        }
    }
}
