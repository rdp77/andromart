<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Role;
use App\Models\Notes;
use App\Models\NotesPhoto;
use App\Models\Regulation;
use App\Models\RegulationDetail;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
// use Illuminate\Http\UploadedFile;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class RegulationController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index(Request $req)
    {
        // dd(Regulation::get());
        if ($req->ajax()) {
            $data = Regulation::with('branch')->with('role')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group">';
                    $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                    $actionBtn .= '<div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('regulation.show', Crypt::encryptString($row->id)) . '">Lihat</a>';
                    $actionBtn .= '<a class="dropdown-item" href="' . route('regulation.edit', Crypt::encryptString($row->id)) . '">Edit</a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
                    $actionBtn .= '</div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.office.regulation.indexRegulation');
    }

    public function create()
    {
        $role = Role::get();
        $branch = Branch::get();
        return view('pages.backend.office.regulation.createRegulation', compact('role', 'branch'));
    }

    public function store(Request $req)
    {
        // dd($req->role);
        Validator::make($req->all(), [
            // 'code' => ['required', 'string', 'max:255', 'unique:areas'],
            'role' => ['required', 'integer'],
            'branch' => ['required', 'integer'],
            'titles' => ['required', 'string', 'max:255'],
            'description' => ['string'],
        ])->validate();

        $regulation = new Regulation;
        $regulation->role_id = $req->role;
        $regulation->branch_id = $req->branch;
        $regulation->date = date('Y-m-d');
        $regulation->title = $req->titles;
        $regulation->description = $req->description;
        $regulation->created_by = Auth::user()->name;
        $regulation->save();

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat Peraturan Baru'
        );
        // dd($req->file('file'));
        if($files = $req->file('file')){
            // dd($files[0]->getClientOriginalName());
            foreach($files as $file){
                $dir = 'file_regulation';
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

                    $regulationFile = new RegulationDetail;
                    $regulationFile->regulation_id = $regulation->id;
                    $regulationFile->name = $filename;
                    $regulationFile->file = "file_regulation/".$data;
                    $regulationFile->save();
                }
            }
        }

        return Redirect::route('regulation.index')
            ->with([
                'status' => 'Berhasil membuat menambah peraturan baru',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $models = Regulation::where('id', $id)->first();
        $modelsFile = RegulationDetail::where('regulation_id', $id)->get();
        // dd($modelsFile);
        return view('pages.backend.office.regulation.showRegulation', compact('models', 'modelsFile'));
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $model = Regulation::where('id', $id)->first();
        $models = RegulationDetail::where('regulation_id', $id)->get();
        $role = Role::get();
        $branch = Branch::get();
        // dd($models);
        return view('pages.backend.office.regulation.editRegulation', compact('role', 'branch', 'model', 'models'));
    }
    public function deleteDetail($id, $iddetail)
    {
        $model = RegulationDetail::where('id', $iddetail)->first();
        $model->delete();
        return Redirect::route('regulation.edit', Crypt::encryptString($id))
            ->with([
                'status' => 'Berhasil menghapus file',
                'type' => 'success'
            ]);
    }

    public function update(Request $req, $id)
    {
        // dd($req->role);
        Validator::make($req->all(), [
            // 'code' => ['required', 'string', 'max:255', 'unique:areas'],
            'role' => ['required', 'integer'],
            'branch' => ['required', 'integer'],
            'titles' => ['required', 'string', 'max:255'],
            'description' => ['string'],
        ])->validate();

        $regulation = Regulation::where('id', $id)->first();
        $regulation->role_id = $req->role;
        $regulation->branch_id = $req->branch;
        $regulation->date = date('Y-m-d');
        $regulation->title = $req->titles;
        $regulation->description = $req->description;
        $regulation->created_by = Auth::user()->name;
        $regulation->save();

        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Membuat Peraturan Baru'
        );
        // dd($req->file('file'));
        if($files = $req->file('file')){
            // dd($files[0]->getClientOriginalName());
            foreach($files as $file){
                $dir = 'file_regulation';
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

                    $regulationFile = new RegulationDetail;
                    $regulationFile->regulation_id = $regulation->id;
                    $regulationFile->name = $filename;
                    $regulationFile->file = "file_regulation/".$data;
                    $regulationFile->save();
                }
            }
        }

        return Redirect::route('regulation.index')
            ->with([
                'status' => 'Berhasil membuat menambah peraturan baru',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $req, $id)
    {
        $this->DashboardController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            'Menghapus peraturan ' . Regulation::find($id)->name
        );

        Regulation::destroy($id);

        return Response::json(['status' => 'success']);
    }
    public function all()
    {
        $models = Regulation::join('roles', 'regulations.role_id', 'roles.id')
        ->join('branches', 'regulations.branch_id', 'branches.id')
        ->select('regulations.id as id','regulations.title as title', 'regulations.description as description', 'regulations.date as date', 'branches.name as branchName', 'roles.name as roleName')
        ->get();
        // $models = [];
        return view('pages.backend.office.sop.indexSop', compact('models'));
    }
    public function select($id)
    {
        $model = Regulation::join('roles', 'regulations.role_id', 'roles.id')
        ->join('branches', 'regulations.branch_id', 'branches.id')
        ->select('regulations.id as id','regulations.title as title', 'regulations.description as description', 'regulations.date as date', 'branches.name as branchName', 'roles.name as roleName')
        ->where('regulations.id', $id)
        ->first();
        $file = [];
        $image = [];
        $models = RegulationDetail::where('regulation_id', $id)->get();
        foreach($models as $row) {
            $ext = substr($row->file,-3);
            if($ext == 'jpg' || $ext == 'png' || $ext == 'peg') {
                $image[] = $row->file;
            } else {
                $file[$row->name] = $row->file;
            }
        }
        $imageLength = count($image);
        if($imageLength == 0){
            $image[] = 'assetsfrontend/img/andromart.png';
        }
        return view('pages.backend.office.sop.showSop', compact('model', 'file', 'image', 'imageLength'));
    }
    public function visiMisi()
    {
        $visi = Content::where('content_types_id', 12)->first();
        $misi = Content::where('content_types_id', 13)->first();
        return view('pages.backend.office.sop.visiMisi', compact('visi', 'misi'));
    }
}
