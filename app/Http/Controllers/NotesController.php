<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notes;
use App\Models\NotesPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class NotesController extends Controller
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

    public function index()
    {
        $models = Notes::join('users', 'notes.users_id', '=', 'users.id')
        ->select('notes.id as notes_id', 'notes.date as date', 'users.name as name', 'users.id as users_id', 'notes.title as title')
        ->get();
        // if($edit == null) {
        //     // $kelurahan = Kelurahan::get();
        // } else {
        //     dd($edit);
        //     $model = Notes::join('users', 'notes.users_id', '=', 'users.id')
        //     ->select('notes.id as notes_id', 'notes.date as date', 'users.name as name', 'users.id as users_id', 'notes.title as title')
        //     ->first();
        //     return view('pages.backend.content.notes.editNotes')->with('model', $model);
        // }
        return view('pages.backend.content.notes.indexNotes')->with('models', $models);
    }

    public function create()
    {
        return view('pages.backend.content.notes.createNotes');
    }
    public function store(Request $request)
    {
        $users_id = Auth::user()->id;
        $notes = new Notes;
        $notes->users_id = $users_id;
        $notes->date = now();
        $notes->title = $request->title;
        $notes->description = $request->description;
        $notes->save();
        $notes_id = $notes->id;
        $photo = array();
        if($files = $request->file('photo')){
            foreach($files as $file){

                $dir = 'photo_notes';
                $allowed = array("jpeg", "gif", "png", "jpg", "pdf");

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
                    $notesPhoto = new NotesPhoto;
                    $notesPhoto->notes_id = $notes_id;
                    $notesPhoto->photo = "photo_notes/".$data;
                    $notesPhoto->save();
                }
            }
        }
        return Redirect::route('notes.index')->with(['status' => 'Berhasil membuat user baru','type' => 'success']);
    }
        
    public function show($id)
    {
        $models = Notes::where('notes.id', $id)
        ->join('users', 'notes.users_id', '=', 'users.id')
        ->select('notes.id as notes_id', 'notes.date as date', 'users.name as name', 'users.id as users_id', 'notes.title as title', 'notes.description as description')
        ->first();
        $modelsPhoto = NotesPhoto::where('notes_id', $id)->get();
        return view('pages.backend.content.notes.detailNotes')->with('models', $models)->with('modelsPhoto', $modelsPhoto);
    }

    public function edit($id)
    {
        $models = Notes::where('id', $id)->first();
        $modelsPhoto = NotesPhoto::where('notes_id', $id)->get();
        return view('pages.backend.content.notes.editNotes')->with('models', $models)->with('modelsPhoto', $modelsPhoto);
        // return view('pages.backend.content.notes.editNotes');
    }

    public function update(Request $request, $id)
    {
        $notes = Notes::where('id', $id)->first();
        $notes->title = $request->title;
        $notes->description = $request->description;
        $notes->save();

        $photo = array();
        if($files = $request->file('photo')){
            foreach($files as $file){

                $dir = 'photo_notes';
                $allowed = array("jpeg", "gif", "png", "jpg", "pdf");

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
                    $notesPhoto = new NotesPhoto;
                    $notesPhoto->notes_id = $id;
                    $notesPhoto->photo = "photo_notes/".$data;
                    $notesPhoto->save();
                }
            }
        }
        return Redirect::route('notes.index')->with(['status' => 'Berhasil membuat user baru','type' => 'success']);
    }

    public function destroy(Request $request, $id)
    {
        $models = Notes::findOrFail($id);
        $models->delete();
        
        return redirect()->route('notes.edit', $id);
    }
    public function delete($id)
    {
        dd("ini id hapus wk ".$id);
        $models = Notes::findOrFail($id);
        $models->delete();
        return redirect()->route('notes.edit', $id);
    }
}
