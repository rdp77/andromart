<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Branch;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\Message;
use App\Models\Service;
use App\Models\ServiceStatusMutation;
use App\Models\Product;

use App\Library\QueryLibrary;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FrontendController extends Controller
{
    private $library;
    private $globalContent;

    public function __construct()
    {
        $this->library = new QueryLibrary();
        $querycontent = ContentType::get();
        $varcontents = array('type' => 'active');
        foreach ($querycontent as $row) {
            $varcontents[$row->type] = $row->active;
        }        
        $this->globalContent = $varcontents;
    }
    public function productDetail($id)
    {
        $carouselHome = $this->library->contentNameGet('Carousel Product'); // 1
        $content = Content::where('id', $id)->first();
        return view('pages.frontend.home.itemDetail', compact('content', 'carouselHome'));
    }
    public function product()
    {
        $carouselProduct = $this->library->contentNameGet('Carousel Product'); // 1
        $typeProduct = $this->library->productTypeGet();
        // $itemProduct = $this->library->productGet(1);
        $contents = $this->globalContent;
        return view('pages.frontend.product.indexProduct', compact('contents', 'carouselProduct', 'typeProduct'));
    }
    public function productShow($id, $sort=1)
    {
        $sort = intval($sort);
        $carouselProduct = $this->library->contentNameGet('Carousel Product'); // 1
        $show = $sort * 12;
        $queryProduct = $this->library->productGet($id, $show);
        $itemProduct = $queryProduct[0];
        $itemProductCount = $queryProduct[1];
        $itemProductRound = intval(ceil($itemProductCount / 12));
        $contents = $this->globalContent;
        // dd($itemProduct);
        return view('pages.frontend.product.indexItemProduct', compact('contents', 'carouselProduct', 'itemProduct', 'itemProductCount', 'itemProductRound', 'id', 'sort'));
    }
    public function productShowDetail($id)
    {
        $carouselProduct = $this->library->contentNameGet('Carousel Product'); // 1
        $itemProduct = Product::where('id', $id)->first();
        // dd($itemProduct);
        $contents = $this->globalContent;
        return view('pages.frontend.product.productDetail', compact('contents', 'carouselProduct', 'itemProduct'));
    }
    public function home()
    {
        $carouselHome = $this->library->contentNameGet('Carousel Home'); // 1
        $homeTab = $this->library->contentNameGet('Home Tab'); // 2
        $homeAboutUs = $this->library->contentNameFirst('Home About Us'); // 3
        $homeHireUs = $this->library->contentNameGet('Home Hire Us'); // 4
        $homeTestimonialTitle = $this->library->contentNameFirst('Home Testimonial Title'); // 5
        $homeTestimonial = $this->library->contentNameGet('Home Testimonial'); // 6
        $homeAchievement = $this->library->contentNameGet('Home Achievement'); // 7
        $homeVendor = $this->library->contentNameGet('Home Vendor'); // 8
        // $homeHotItem = $this->library->contentNameGet(32);
        $homeServiceUnit = $this->library->contentNameGet('Service Unit');
        $contents = $this->globalContent;
        $homeHotItem = Product::where('hot_item', 1)->get();
        // dd($homeHotItem);
        $branch = Branch::get();
        return view('pages.frontend.home.indexHome', compact('contents', 'carouselHome', 'homeTab', 'homeAboutUs', 'homeHireUs', 'homeTestimonialTitle', 'homeTestimonial', 'homeAchievement', 'homeVendor', 'homeHotItem', 'homeServiceUnit', 'branch'));
    }
    public function about()
    {
        $carouselAbout = $this->library->contentNameFirst('Carousel About'); // 1
        $aboutVision = $this->library->contentNameFirst('About Vision'); // 2
        $aboutMission = $this->library->contentNameFirst('About Mission'); // 3
        $aboutImage = $this->library->contentNameGet('About Image'); // 4
        $aboutMotivation = $this->library->contentNameGet('About Motivation'); // 5
        $aboutAchievement = $this->library->contentNameGet('About Achievement'); // 6
        $aboutLeadershipTitle = $this->library->contentNameFirst('About Leadership Title'); // 7
        $aboutLeadership = $this->library->contentNameGet('About Leadership'); // 8
        $aboutClientsTitle = $this->library->contentNameFirst('About Clients Title'); // 9
        $aboutClients = $this->library->contentNameGet('About Clients'); // 10

        $contents = $this->globalContent;
        return view('pages.frontend.about.indexAbout', compact('contents', 'carouselAbout', 'aboutVision', 'aboutMission', 'aboutImage', 'aboutMotivation', 'aboutAchievement', 'aboutLeadershipTitle', 'aboutLeadership', 'aboutClientsTitle', 'aboutClients'));
    }
    public function services()
    {
        $carouselServices = $this->library->contentNameFirst('Carousel Services');
        $servicesTitle = $this->library->contentNameFirst('Services Title');
        $servicesHelpTitle = $this->library->contentNameFirst('Services Help Title');
        $servicesHelp = $this->library->contentNameGet('Services Help');
        $servicesAction = $this->library->contentNameGet('Services Action');
        $servicesInovation = $this->library->contentNameFirst('Services Inovation');

        $contents = $this->globalContent;
        return view('pages.frontend.services.indexServices', compact('contents', 'carouselServices', 'servicesTitle', 'servicesHelpTitle', 'servicesHelp', 'servicesAction', 'servicesInovation'));
    }
    public function work()
    {
        $carouselWork = $this->library->contentNameFirst('Carousel Work');
        $workActivity1 = $this->library->contentNameGet('Work Activity 1');
        $workActivity2 = $this->library->contentNameGet('Work Activity 2');
        $workActivity3 = $this->library->contentNameGet('Work Activity 3');
        $workActivity4 = $this->library->contentNameGet('Work Activity 4');

        $contents = $this->globalContent;
        return view('pages.frontend.work.indexWork', compact('contents', 'carouselWork', 'workActivity1', 'workActivity2', 'workActivity3', 'workActivity4'));
    }
    public function contact()
    {
        $branch = Branch::get();
        // dd($branch);
        $contactsTitle = $this->library->contentNameFirst('Contacts Title');
        $contactsMessageTitle = $this->library->contentNameFirst('Contacts Message Title');

        $contents = $this->globalContent;
        return view('pages.frontend.contact.indexContact', compact('contents', 'contactsTitle', 'contactsMessageTitle', 'branch'));
    }
    public function login()
    {
        return view('home');
    }
    public function tracking($id)
    {
        // $models = ServiceStatusMutation::
        // join('service', 'service_status_mutation.service_id', '=', 'service.id')->where('service.code', $id)
        // ->get();
        $service = Service::where('code', $id)->with('ServiceDetail', 'ServiceDetail.Items', 'Employee1', 'Employee2', 'CreatedByUser', 'Type', 'Brand', 'Brand.Category', 'ServiceEquipment', 'ServiceCondition', 'ServiceStatusMutation')->first();
        return view('pages.frontend.statusService', compact('id', 'service'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */   
    public function index()
    {

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function message(Request $request)
    {
        // dd("masuk");
        $message = new Message;
        $message->name = $request->name;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->message = $request->message;
        if($message->save()) {
            return Redirect::route('frontendContact')
                ->with([
                    'status' => 'Berhasil memberikan masukan ',
                    'type' => 'success'
                ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkTable($table)
    {
        // $model = DB::select('select * from '.$table);
        $model = ContentType::select('id', 'name')->get();
        // $column = DB::getSchemaBuilder()->getColumnListing($table);
        return response()->json([
            // 'column' => $column,
            'model' => $model,
        ]);
    }
    public function inputs(Request $req)
    {
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
                return response()->json([
                    'status' => 'gagal'
                ]);
            } else if (!in_array($guessExtension, $allowed)){
                return response()->json([
                    'status' => 'gagal'
                ]);
            } else {
                $file->move($dir, $data);
                // dd($req->title);
                $image = "photo_frontend/".$data;

                $content = new Content();
                $content->content_types_id = $req->id;
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
            $content = new Content();
            $content->content_types_id = $req->id;
            $content->title = $req->title;
            $content->subtitle = $req->subtitle;
            $content->description = $req->description;
            $content->icon = $req->icon;
            $content->url = $req->url;
            $content->class = $req->class;
            $content->position = $req->position;
            // $content->created_by = Auth::user()->name;
            $content->save();
        }
        return response()->json([
            'status' => 'berhasil'
        ]);
    }

    public function getPubliclyStorgeFile($filename)
    {
        $path = storage_path('app/public/'. $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }   
}
