<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class CashController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Cash::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('cash.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->addColumn('balance', function ($row) {
                    $htmlAdd  =      '<tr>';
                    $htmlAdd .=         '<td>'.number_format($row->balance,0,".",",").'</td>';
                    $htmlAdd .=      '<tr>';

                    return $htmlAdd;

                })
                ->rawColumns(['action', 'balance'])
                ->make(true);
        }
        return view('pages.backend.master.cash.indexCash');
    }

    public function create()
    {
        return view('pages.backend.master.cash.createCash');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255', 'unique:cashes'],
            'name' => ['required', 'string', 'max:255'],
            'balance' => ['required', 'string', 'max:255'],
        ])->validate();

        Cash::create([
            'code' => $req->code,
            'name' => $req->name,
            'balance' => $req->balance,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master kas baru'
        );

        return Redirect::route('cash.index')
            ->with([
                'status' => 'Berhasil membuat master kas baru',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cash = Cash::find($id);
        return view('pages.backend.master.cash.updateCash', ['cash' => $cash]);
    }

    public function update(Request $req, $id)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'balance' => ['required', 'string', 'max:255'],
        ])->validate();

        Cash::where('id', $id)
            ->update([
            'code' => $req->code,
            'name' => $req->name,
            'balance' => $req->balance,
            ]);

        $cash = Cash::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master kas ' . Cash::find($id)->name
        );

        $cash->save();

        return Redirect::route('cash.index')
            ->with([
                'status' => 'Berhasil merubah master kas ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master kas ' . Cash::find($id)->name
        );

        Cash::destroy($id);

        return view('pages.backend.master.cash.indexCash');
    }
}
