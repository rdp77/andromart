<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class WarrantyController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Warranty::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('warranty.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.master.warranty.indexWarranty');
    }

    public function create()
    {
        return view('pages.backend.master.warranty.createWarranty');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:100'],
            'periode' => ['required', 'integer', 'max:31'],
        ])->validate();

        Warranty::create([
            'name' => $req->name,
            'periode' => $req->periode,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master garansi baru'
        );

        return Redirect::route('warranty.index')
            ->with([
                'status' => 'Berhasil membuat master garansi baru',
                'type' => 'success'
            ]);
    }

    public function show(Warranty $warranty)
    {
        //
    }

    public function edit($id)
    {
        $warranty = Warranty::find($id);
        return view('pages.backend.master.warranty.updateWarranty', ['warranty' => $warranty]);
    }

    public function update(Request $req, $id)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:100'],
            'periode' => ['required', 'integer', 'max:31'],
        ])->validate();

        Warranty::where('id', $id)
            ->update([
            'name' => $req->name,
            'periode' => $req->periode,
            'updated_by' => Auth::user()->name,
        ]);

        $warranty = Warranty::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master garansi ' . Warranty::find($id)->name
        );

        $warranty->save();

        return Redirect::route('warranty.index')
            ->with([
                'status' => 'Berhasil merubah master garansi ',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master garansi ' . Warranty::find($id)->name
        );

        Warranty::destroy($id);

        return Response::json(['status' => 'success', 'message' => 'Data master berhasil dihapus !']);
    }
}
