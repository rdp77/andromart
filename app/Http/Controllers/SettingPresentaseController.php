<?php

namespace App\Http\Controllers;

use App\Models\SettingPresentase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SettingPresentaseController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index()
    {
        $checkRoles = $this->DashboardController->cekHakAkses(24,'view');
        if($checkRoles == 'akses ditolak'){
            return view('forbidden');
        }

        $presentase = SettingPresentase::all();
        return view('pages.backend.master.presentase.updatePresentase', compact('presentase'));
    }

    public function create()
    {

    }

    public function store(Request $req)
    {

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        SettingPresentase::where('id', $id)
            ->update([
            'total' => $req->total,
            'updated_by' => Auth::user()->name,
            ]);

        return Redirect::route('presentase.index')
            ->with([
                'status' => 'Berhasil merubah master presentase ',
                'type' => 'success'
            ]);
    }

    public function updates(Request $req)
    {
        for($i=0; $i <9; $i++){
            SettingPresentase::where('id', $i)
            ->update([
                'total' => $req->total,
                'updated_by' => Auth::user()->name,
            ]);
        }

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master presentase'
        );

        return Redirect::route('presentase.index')
            ->with([
                'status' => 'Berhasil mengubah nilai master presentase',
                'type' => 'success'
            ]);
    }

    public function destroy($id)
    {
        //
    }

}
