<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class MessageController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        // $data = Message::all();
        // dd($data);
        if ($req->ajax()) {
            $data = Message::all();
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function ($row) {
                //     $actionBtn = '<div class="btn-group">';
                //     $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                //             data-toggle="dropdown">
                //             <span class="sr-only">Toggle Dropdown</span>
                //         </button>';
                //     $actionBtn .= '<div class="dropdown-menu">
                //             <a class="dropdown-item" href="' . route('message.show', $row->id) . '">Lihat</a>';
                //     $actionBtn .= '</div></div>';
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.content.message.indexMessage');
        // return view('pages.backend.master.area.indexArea');
    }

    public function code($type)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $index = DB::table('purchasings')->max('id')+1;

        $index = str_pad($index, 3, '0', STR_PAD_LEFT);
        return $code = $type.$year . $month . $index;
    }
    public function create()
    {
        $code     = $this->code('PCS-');
        $employee = Employee::get();
        // $items    = Item::where('name','!=','Jasa Service')->get();
        $item     = Item::with('stock')->where('name','!=','Jasa Service')->get();
        $unit     = Unit::get();
        $branch   = Branch::get();
        return view('pages.backend.transaction.purchase.createPurchase',compact('employee','code','item', 'unit', 'branch'));
        // return view('pages.backend.transaction.purchase.createPurchase');
    }

    public function store(Request $req)
    {
        // return $req->all();
        dd("masuk");
        // return Response::json(['status' => 'success','message'=>'Data Tersimpan']);
        // return Redirect::route('notes.index')
        //     ->with([
        //         'status' => 'Berhasil membuat menambah notulensi',
        //         'type' => 'success'
        //     ]);
    }

    public function show(Notes $notes, $id)
    {
        $id = Crypt::decryptString($id);
        $models = Notes::where('id', $id)->first();
        // $models = Notes::where('notes.id', $id)
        // ->join('users', 'notes.users_id', '=', 'users.id')
        // ->select('notes.id as notes_id', 'notes.date as date', 'users.name as name', 'users.id as users_id', 'notes.title as title', 'notes.description as description')
        // ->first();
        $modelsFile = NotesPhoto::where('notes_id', $id)->get();
        // dd($modelsFile);
        return view('pages.backend.office.notes.showNotes', compact('models', 'modelsFile'));
    }

    public function edit($id)
    {
        $area = Area::find($id);
        return view('pages.backend.master.area.updateArea', ['area' => $area]);
    }

    public function update(Request $req, $id)
    {
        if($req->code == Area::find($id)->code){
            Validator::make($req->all(), [
                'name' => ['required', 'string', 'max:255'],
            ])->validate();
        }
        else{
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
            'Mengubah masrter area ' . Area::find($id)->name
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
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus master area ' . Area::find($id)->name
        );

        Area::destroy($id);

        return Response::json(['status' => 'success']);
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Purchasing $purchasing)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Purchasing $purchasing)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Purchasing $purchasing)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Purchasing  $purchasing
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Purchasing $purchasing)
    // {
    //     //
    // }
}
