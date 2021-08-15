<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
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

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Item::where('id', '!=', Auth::item()->id)->get();;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<a onclick="edit" href="' . route('item.edit', $row->id) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.item.indexItem');
    }

    public function create()
    {
        return view('pages.backend.item.createItem');
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'merk' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'total' => ['required', 'string', 'max:255'],
            'info' => ['required', 'string', 'max:255'],
        ])->validate();

        Item::create([
            'name' => $req->name,
            'type' => $req->type,
            'merk' => $req->merk,
            'price' => $req->price,
            'total' => $req->total,
            'info' => $req->info,
        ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat barang baru'
        );

        return Redirect::route('item.index')
            ->with([
                'status' => 'Berhasil membuat barang baru',
                'type' => 'success'
            ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.backend.users.updateUsers', ['user' => $user]);
    }

    public function update($id, Request $req)
    {
        Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
        ])->validate();


        User::where('id', $id)
            ->update([
                'name' => $req->name,
                'username' => $req->username
            ]);

        $user = User::find($id);
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengubah user ' . User::find($id)->name
        );

        $user->save();

        return Redirect::route('users.index')
            ->with([
                'status' => 'Berhasil merubah user',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus user ' . User::find($id)->name
        );

        User::destroy($id);

        return Response::json(['status' => 'success']);

        // return Redirect::route('users.index')
        //     ->with([
        //         'status' => 'Berhasil menghapus user',
        //         'type' => 'success'
        //     ]);
    }

    function reset($id, Request $req)
    {
        User::where('id', $id)
            ->update([
                'password' => Hash::make(1234567890),
            ]);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Reset password user ' . User::find($id)->name
        );

        return Redirect::route('users.index')
            ->with([
                'status' => 'Password untuk user ' . User::find($id)->name . ' telah diganti menjadi \'1234567890\'',
                'type' => 'success'
            ]);
    }

    public function changeName(Request $req)
    {
        $this->validate($req, [
            'name' => ['required', 'string', 'max:255']
        ]);

        $user = User::find(Auth::user()->id);

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Mengganti nama ' . $user->name . ' menjadi ' . $req->name
        );

        $oldName = $user->name;
        $user->name = $req->name;
        $user->save();

        return Redirect::route('dashboard')
            ->with([
                'status' => 'Nama berhasil diganti dari ' . $oldName . ' menjadi ' . $req->name,
                'type' => 'success'
            ]);
    }

    public function changePassword()
    {
        return view('auth.forgot-password');
    }
}
