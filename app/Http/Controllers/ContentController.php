<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Icon;
use App\Models\Content;
use App\Models\ContentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Carbon\carbon;

class ContentController extends Controller
{
    public function __construct(DashboardController $DashboardController)
    {
        $this->middleware('auth');
        $this->DashboardController = $DashboardController;
    }

    public function index()
    {
        // Request $req
        // if ($req->ajax()) {
        //     $data = Content::get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $actionBtn = '<div class="btn-group">';
        //             $actionBtn .= '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
        //                     data-toggle="dropdown">
        //                     <span class="sr-only">Toggle Dropdown</span>
        //                 </button>';
        //             $actionBtn .= '<div class="dropdown-menu">
        //                     <a class="dropdown-item" href="' . route('branch.edit', $row->id) . '">Edit</a>';
        //             $actionBtn .= '<a onclick="del(' . $row->id . ')" class="dropdown-item" style="cursor:pointer;">Hapus</a>';
        //             $actionBtn .= '</div></div>';
        //             return $actionBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $content = ContentType::orderBy('id', 'asc')->get();
        return view('pages.backend.content.contents.indexContents')->with('content', $content);
        // return view('pages.backend.master.branch.indexBranch');
    }

    public function creates($id)
    {
        $id = Crypt::decryptString($id);
        $contentType = ContentType::where('id', $id)->first();
        $content = Content::where('content_types_id', $id)->get();
        $icon = Icon::get();
        return view('pages.backend.content.contents.createContents')->with('content', $content)->with('contentType', $contentType)->with('icon', $icon);
        // return view('pages.backend.master.branch.createBranch', ['area' => $area]);
    }
    public function create()
    {
        $content = ContentType::get();
        return view('pages.backend.content.contents.createContents')->with('content', $content);
        // return view('pages.backend.master.branch.createBranch', ['area' => $area]);
    }
    public function showContent($id)
    {
        $id = Crypt::decryptString($id);
        $contentType = ContentType::where('id', $id)->first();
        $content = Content::where('content_types_id', $id)->get();
        // dd($content);
        return view('pages.backend.content.contents.indexShowContents')->with('content', $content)->with('contentType', $contentType);
    }

    public function stores(Request $req, $id)
    {
        $id = Crypt::decryptString($id);
        // dd($id);
        Validator::make($req->all(), [
            'title' => ['string', 'max:255'],
            'subtitle' => ['string', 'max:255'],
            'description' => ['string'],
            // 'image' => ['string', 'max:255'],
            'icon' => ['string', 'max:255'],
            'url' => ['string', 'max:255'],
            'class' => ['string', 'max:255'],
            'position' => ['string', 'max:255'],
        ])->validate();
        if($file = $req->file('image')){
            $dir = 'photo_frontend';
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
                return Redirect::route('contents.index')->with(['status' => 'Ukuran File Terlalu Besar','type' => 'danger']);
            } else if (!in_array($guessExtension, $allowed)){
                return Redirect::route('contents.index')->with(['status' => 'Tipe File Berkas Salah','type' => 'danger']);
            } else {
                $file->move($dir, $data);
                // dd($req->title);
                $image = "photo_frontend/".$data;
                // dd($req->title);
                $content = new Content();
                $content->content_types_id = $id;
                $content->title = $req->title;
                $content->subtitle = $req->subtitle;
                $content->description = $req->description;
                $content->image = $image;
                $content->icon = $req->icon;
                $content->url = $req->url;
                $content->class = $req->class;
                $content->position = $req->position;
                $content->save();
                // Content::create([
                //     'content_types_id' => $id,
                //     'title' => $req->title,
                //     'subtitle' => $req->subtitle,
                //     'description' => $req->description,
                //     'image' => $image,
                //     'icon' => $req->icon,
                //     'url' => $req->url,
                //     'class' => $req->class,
                //     'position' => $req->position,
                // ]);
            }
        }

        // $branch = Branch::find($id);
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Mengubah master cabang ' . Branch::find($id)->name
        // );
        // $branch->save();

        return Redirect::route('contents.show', Crypt::encryptString($id))
            ->with([
                'status' => 'Berhasil menambah content ',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $contentType = ContentType::where('id', $id)->first();
        $content = Content::where('content_types_id', $id)->get();
        // dd($content);
        return view('pages.backend.content.contents.indexShowContents')->with('content', $content)->with('contentType', $contentType);
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $content = Content::where('id', $id)->first();
        $contentType = ContentType::where('id', $content->content_types_id)->first();
        $icon = Icon::get();
        return view('pages.backend.content.contents.editContents')->with('content', $content)->with('contentType', $contentType)->with('icon', $icon);
    }

    public function update(Request $req, $id)
    {
        $id = Crypt::decryptString($id);
        $content = Content::where('id', $id)->first();
        // dd($id);
        Validator::make($req->all(), [
            'title' => ['string', 'max:255'],
            'subtitle' => ['string', 'max:255'],
            'description' => ['string'],
            // 'image' => ['string', 'max:255'],
            'icon' => ['string', 'max:255'],
            'url' => ['string', 'max:255'],
            'class' => ['string', 'max:255'],
            'position' => ['string', 'max:255'],
        ])->validate();
        if($file = $req->file('image')){
            // dd("if");
            $dir = 'photo_frontend';
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
                return Redirect::route('contents.index')->with(['status' => 'Ukuran File Terlalu Besar','type' => 'danger']);
            } else if (!in_array($guessExtension, $allowed)){
                return Redirect::route('contents.index')->with(['status' => 'Tipe File Berkas Salah','type' => 'danger']);
            } else {
                $file->move($dir, $data);
                // dd($req->title);
                $image = "photo_frontend/".$data;
                // dd($content);
                // $content->content_types_id = $id;
                $content->title = $req->title;
                $content->subtitle = $req->subtitle;
                $content->description = $req->description;
                $content->image = $image;
                $content->icon = $req->icon;
                $content->url = $req->url;
                $content->class = $req->class;
                $content->position = $req->position;
                $content->save();
            }
        } else {
            // dd($req->imageBefore);
            // dd($content);
            // $content->content_types_id = $id;
            $content->title = $req->title;
            $content->subtitle = $req->subtitle;
            $content->description = $req->description;
            $content->image = $req->imageBefore;
            $content->icon = $req->icon;
            $content->url = $req->url;
            $content->class = $req->class;
            $content->position = $req->position;
            $content->save();
        }
        $contentType = ContentType::where('id', $content->content_types_id)->first();
        return Redirect::route('contents.show', Crypt::encryptString($contentType->id))
            ->with([
                'status' => 'Berhasil menambah content ',
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
    public function active($id, $status)
    {
        // dd($status);
        $content = ContentType::where('id', $id)->first();
        // dd($content);
        $content->active = $status;
        $content->save();
        return Redirect::route('contents.index');
    }
}
