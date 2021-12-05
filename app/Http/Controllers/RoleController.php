<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleDetail;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class RoleController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        // if ($req->ajax()) {
        //     $data = Role::get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $actionBtn = '<div class="btn-group">';
        //             $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
        //                     data-toggle="dropdown">
        //                     <span class="sr-only">Toggle Dropdown</span>
        //                 </button>';
        //             $actionBtn .= '<div class="dropdown-menu">
        //                     <a class="dropdown-item" href="' . route('role.edit', $row->id) . '">Edit</a>';
        //             $actionBtn .= '</div></div>';
        //             return $actionBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $role = Role::get();

        return view('pages.backend.master.role.indexRole', compact('role'));
    }

    public function create()
    {
        return view('pages.backend.master.role.createRole');
    }

    public function store(Request $req)
    {
        Role::create([
            'name' => $req->name,
            'created_by' => Auth::user()->name,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat master role baru'
        );

        return Redirect::route('role.index')
            ->with([
                'status' => 'Berhasil membuat master role baru',
                'type' => 'success'
            ]);
    }

    public function show(role $role)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('pages.backend.master.role.updateRole', compact('role'));
    }

    public function update(Request $req, $id)
    {
        Role::where('id', $id)
            ->update([
                'name' => $req->name,
                'updated_by' => Auth::user()->name,
            ]);

        $role = Role::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah master role ' . Role::find($id)->name
        );

        $role->save();

        return Redirect::route('role.index')
            ->with([
                'status' => 'Berhasil merubah master role ',
                'type' => 'success'
            ]);
    }

    public function destroy(role $role)
    {
        //
    }

    public function rolesDetailSearch(Request $req)
    {
        $menu = SubMenu::with('RoleDetail')->get()->toArray();
        $menuRoles = [];
        for ($i=0; $i <count($menu) ; $i++) { 
            $menuRoles[$i]['name'] = $menu[$i]['name'];
            $menuRoles[$i]['id'] = $menu[$i]['id'];
            $menuRoles[$i]['view'] = 'off';
            $menuRoles[$i]['create'] = 'off';
            $menuRoles[$i]['edit'] = 'off';
            $menuRoles[$i]['delete'] = 'off';
            for ($j=0; $j < count($menu[$i]['role_detail']); $j++) { 
                if($menu[$i]['role_detail'][$j]['roles_id'] == $req->id){
                    $menuRoles[$i]['view'] = $menu[$i]['role_detail'][$j]['view'];
                    $menuRoles[$i]['create'] = $menu[$i]['role_detail'][$j]['create'];
                    $menuRoles[$i]['edit'] = $menu[$i]['role_detail'][$j]['edit'];
                    $menuRoles[$i]['delete'] = $menu[$i]['role_detail'][$j]['delete'];
                }
            }
        }
        // return $menuRoles;
        // return $menu;
        $role = RoleDetail::where('roles_id',$req->id)->get();
        return Response::json([
            'status' => 'success',
            'message' => 'berhasil Meload Data',
            'menu' => $menuRoles,
            // 'role' => $role,
        ]);
    }

    public function rolesDetailSave(Request $req)
    {
        // return $req->all();
        if(!isset($req->delete)){
            $del = [];
        }else{
            $del = $req->delete;
        }
        if(!isset($req->view)){
            $vie = [];
        }else{
            $vie = $req->view;
        }
        if(!isset($req->create)){
            $cre = [];
        }else{
            $cre = $req->create;
        }
        if(!isset($req->edit)){
            $edi = [];
        }else{
            $edi = $req->edit;
        }
        // return $del;
        $arr = [];
        for ($i=0; $i <count($req->menu) ; $i++) { 
            $arr[$i]['menu'] =  $req->menu[$i];
        }
        for ($i=0; $i <count($req->menu) ; $i++) { 
            $arr[$i]['menu'] = $req->menu[$i];
            $arr[$i]['view'] = 'off';
            $arr[$i]['create'] = 'off';
            $arr[$i]['edit'] = 'off';
            $arr[$i]['delete'] = 'off';
            for ($j=0; $j <count($vie) ; $j++) { 
                if($req->view[$j] == $req->menu[$i]){
                    $arr[$i]['view'] =  'on';
                }
            }
            for ($j=0; $j <count($cre) ; $j++) { 
                if($req->create[$j] == $req->menu[$i]){
                    $arr[$i]['create'] =  'on';
                }
            }
            for ($j=0; $j <count($edi) ; $j++) { 
                if($req->edit[$j] == $req->menu[$i]){
                    $arr[$i]['edit'] =  'on';
                }
            }
            for ($j=0; $j <count($del) ; $j++) { 
                if($req->delete[$j] == $req->menu[$i]){
                    $arr[$i]['delete'] =  'on';
                }
            }
        }
        RoleDetail::where('roles_id',$req->roles)->delete();
        for ($i=0; $i <count($arr) ; $i++) { 
            $index = DB::table('roles_detail')->max('id') + 1;
            RoleDetail::create([
                'id'=>$index,
                'roles_id'=>$req->roles,
                'menu'=>$arr[$i]['menu'],
                'view'=>$arr[$i]['view'],
                'create'=>$arr[$i]['create'],
                'edit'=>$arr[$i]['edit'],
                'delete'=>$arr[$i]['delete'],
                // 'branch'=>$req->branch[$i],
            ]);
        }
        return Response::json([
            'status' => 'success',
            'message' => 'berhasil Meload Data',
            // 'role' => $role,
        ]);
        // $role = RoleDetail::where('roles_id',$req->id)->get();
        
    }
}
