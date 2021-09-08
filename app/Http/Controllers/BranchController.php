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

class BranchController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Branch::with('area')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('branch.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.branch.indexBranch');
    }

    public function create()
    {
        $area = Area::all();
        return view('pages.backend.master.branch.createBranch', ['area' => $area]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'area_id' => ['required', 'integer'],
            'code' => ['required', 'string', 'max:255', 'unique:branches'],
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            // 'latitude' => ['double', 'max:255'],
            // 'longitude' => ['double', 'max:255'],
        ])->validate();

        Branch::create([
            'area_id' => $req->area_id,
            'code' => $req->code,
            'name' => $req->name,
            'title' => $req->title,
            'address' => $req->address,
            'phone' => $req->phone,
            'email' => $req->email,
            'latitude' => $req->latitude,
            'longitude' => $req->longitude,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master cabang baru'
        );

        return Redirect::route('branch.index')
            ->with([
                'status' => 'Berhasil membuat master cabang baru',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $branch = Branch::find($id);
        $area = Area::where('id', '!=', Branch::find($id)->area_id)->get();
        return view('pages.backend.master.branch.updateBranch', ['branch' => $branch, 'area' => $area]);
    }

    public function update(Request $req, $id)
    {

        $checkBranch = Branch::find($id);

        if($req->code != $checkBranch->code){
            Validator::make($req->all(), [
                'code' => ['required', 'unique'],
            ])->validate();
            return 'kode kembar';
        }
        Validator::make($req->all(), [
            'area_id' => ['required', 'integer'],
            'code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'latitude' => ['double', 'max:255'],
            'longitude' => ['double', 'max:255'],
        ])->validate();

        Branch::where('id', $id)
            ->update([
            'area_id' => $req->area_id,
            'code' => $req->code,
            'name' => $req->name,
            'title' => $req->title,
            'address' => $req->address,
            'phone' => $req->phone,
            'email' => $req->email,
            'latitude' => $req->latitude,
            'longitude' => $req->longitude,
            'updated_by' => Auth::user()->name,
            ]);

        $branch = Branch::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master cabang ' . Branch::find($id)->name
        );

        $branch->save();

        return Redirect::route('branch.index')
            ->with([
                'status' => 'Berhasil merubah master cabang ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master cabang ' . Branch::find($id)->name
        );

        Branch::destroy($id);

        return Response::json(['status' => 'success']);
    }
}
