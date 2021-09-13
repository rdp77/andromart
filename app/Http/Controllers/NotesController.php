<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\NotesPhoto;
use App\Models\Area;
use App\Models\Regulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class NotesController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        // dd("masuk");
        // dd(Regulation::get());
        if ($req->ajax()) {
            // $data = Branch::with('area')->get();
            $data = Notes::with('users')->get();
            // $data = Notes::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('notes.show', Crypt::encryptString($row->id)) . '">Lihat</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('notes.edit', Crypt::encryptString($row->id)) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.office.notes.indexNotes');
    }

    public function create()
    {
        return view('pages.backend.office.notes.createNotes');
    }

    public function store(Request $req)
    {
        // dd($req->role);
        Validator::make($req->all(), [
            // 'code' => ['required', 'string', 'max:255', 'unique:areas'],
            'titles' => ['required', 'string', 'max:255'],
            'description' => ['string'],
        ])->validate();

        $notes = new Notes;
        $notes->users_id = Auth::user()->id;
        $notes->date = date('Y-m-d H:i:s');
        $notes->title = $req->titles;
        $notes->description = $req->description;
        $notes->created_by = Auth::user()->name;
        $notes->save();

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat Notulen Baru'
        );
        // dd($req->file('file'));
        if($files = $req->file('file')){
            // dd($files[0]->getClientOriginalName());
            foreach($files as $file){
                $dir = 'photo_notes';
                $allowed = array("jpeg", "gif", "png", "jpg", "pdf", "doc", "docx");
                if (!is_dir($dir)){
                    mkdir( $dir );       
                }
                $size = filesize($file);
                $input_file = $file->getClientOriginalName();
                $filename = pathinfo($input_file, PATHINFO_FILENAME);
                $md5Name = date("Y-m-d H-i-s")."_".$filename."_".md5($file->getRealPath());
                $guessExtension = $file->guessExtension();
                $data = $md5Name.".".$guessExtension;

                if($size > 5000000){
                    // return Redirect::route('notes.index')->with(['status' => 'Ukuran File Terlalu Besar','type' => 'danger']);
                } else if (!in_array($guessExtension, $allowed)){
                    // return redirect('/operator/berkas-pengajuan/insert-foto/'.$id_encrypt)->with('danger', 'Tipe file berkas salah');
                } else {
                    $file->move($dir, $data);

                    $notesFile = new NotesPhoto;
                    $notesFile->notes_id = $notes->id;
                    $notesFile->description = $filename;
                    $notesFile->photo = "photo_notes/".$data;
                    $notesFile->save();
                }
            }
        }

        return Redirect::route('notes.index')
            ->with([
                'status' => 'Berhasil membuat menambah notulensi',
                'type' => 'success'
            ]);
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
}
