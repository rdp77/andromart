<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class AreaController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Area::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('area.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.area.indexArea');
    }

    public function create()
    {
        return view('pages.backend.master.area.createArea');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => ['required', 'string', 'max:255', 'unique:areas'],
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        Area::create([
            'code' => $req->code,
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master area baru'
        );

        return Redirect::route('area.index')
            ->with([
                'status' => 'Berhasil membuat master area baru',
                'type' => 'success'
            ]);
    }

    public function show(Area $area)
    {
        //
    }

    public function edit($id)
    {
        $area = Area::find($id);
        return view('pages.backend.master.area.updateArea', ['area' => $area]);
    }

    public function update(Request $req, $id)
    {
        if ($req->code == Area::find($id)->code) {
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        } else {
            Validator::make($req->all(), [
                'code' => ['required', 'string', 'max:255', 'unique:areas'],
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        Area::where('id', $id)
            ->update([
                'code' => $req->code,
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $area = Area::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master area ' . Area::find($id)->name
        );

        $area->save();

        return Redirect::route('area.index')
            ->with([
                'status' => 'Berhasil merubah master area ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $branch = Branch::where('area_id', '=', $id)->get();
        $checkBranch = count($branch);

        if($checkBranch > 0){
            return Response::json(['status' => 'error', 'message' => "Data yang sudah di transaksikan tidak bisa dihapus ! "]);
        }
        else{

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master area ' . Area::find($id)->name
        );

        Area::destroy($id);

        return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
        }
    }
}