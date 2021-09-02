<?php

namespace App\Http\Controllers;

use App\Models\Area;
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
        $content = ContentType::get();
        return view('pages.backend.content.contents.indexContents')->with('content', $content);
        // return view('pages.backend.master.branch.indexBranch');
    }

    public function creates($id)
    {
        $id = Crypt::decryptString($id);
        $contentType = ContentType::where('id', $id)->first();
        $content = Content::where('content_types_id', $id)->get();
        return view('pages.backend.content.contents.createContents')->with('content', $content)->with('contentType', $contentType);
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

    public function store(Request $req)
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

        Content::create([
            'title' => $req->title,
            'subtitle' => $req->subtitle,
            'description' => $req->description,
            'image' => $req->image,
            'icon' => $req->icon,
            'url' => $req->url,
            'class' => $req->class,
            'position' => $req->position,
            ]);

        // $branch = Branch::find($id);
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Mengubah master cabang ' . Branch::find($id)->name
        // );
        // $branch->save();

        return Redirect::route('contents.index')
            ->with([
                'status' => 'Berhasil merubah master cabang ',
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
        return view('pages.backend.content.contents.editContents')->with('content', $content)->with('contentType', $contentType);
    }

    public function update(Request $req, $id)
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

        Content::where('id', $id)
            ->update([
            'title' => $req->title,
            'subtitle' => $req->subtitle,
            'description' => $req->description,
            'image' => $req->image,
            'icon' => $req->icon,
            'url' => $req->url,
            'class' => $req->class,
            'position' => $req->position,
            ]);

        // $branch = Branch::find($id);
        // $this->DashboardController->createLog(
        //     $req->header('user-agent'),
        //     $req->ip(),
        //     'Mengubah master cabang ' . Branch::find($id)->name
        // );
        // $branch->save();

        return Redirect::route('contents.index')
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
