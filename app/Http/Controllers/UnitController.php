<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class UnitController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Unit::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('unit.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.unit.indexUnit');
    }

    public function create()
    {
        return view('pages.backend.master.unit.createUnit');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255', 'unique:units'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Unit::create([
            'code' => $req->code,
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master satuan baru'
        );

        return Redirect::route('unit.index')
            ->with([
                'status' => 'Berhasil membuat master satuan baru',
                'type' => 'success'
            ]);
    }

    public function show(Unit $unit)
    {
        //
    }

    public function edit($id)
    {
        $unit = Unit::find($id);
        return view('pages.backend.master.unit.updateUnit', ['unit' => $unit]);
    }

    public function update(Request $req, $id)
    {
        if ($req->code == Unit::find($id)->code) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        } else {
            Validator::make($req->all(), [
                'code' => ['required', 'string', 'max:255', 'unique:units'],
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        Unit::where('id', $id)
            ->update([
                'code' => $req->code,
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $unit = Unit::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master satuan ' . Unit::find($id)->name
        );

        $unit->save();

        return Redirect::route('unit.index')
            ->with([
                'status' => 'Berhasil merubah master satuan ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master satuan ' . Unit::find($id)->name
        );

        Unit::destroy($id);

        return Response::json(['status' => 'success']);
    }
}