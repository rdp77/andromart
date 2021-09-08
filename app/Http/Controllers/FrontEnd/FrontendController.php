<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Content;
use App\Models\ContentType;
use App\Models\Service;
use App\Models\ServiceStatusMutation;

use App\Library\QueryLibrary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function home()
    {
        $carouselHome = $this->library->contentGet(1); // 1
        $homeTab = $this->library->contentGet(5); // 2
        $homeAboutUs = $this->library->contentFirst(6); // 3
        $homeHireUs = $this->library->contentGet(7); // 4
        $homeTestimonialTitle = $this->library->contentFirst(8); // 5
        $homeTestimonial = $this->library->contentGet(9); // 6
        $homeAchievement = $this->library->contentGet(10); // 7
        $homeVendor = $this->library->contentGet(11); // 8
        $contents = $this->globalContent;
        // dd($contents);
        // $content = ContentType::get();
        // $contents = array('type' => 'active');
        // foreach ($content as $row) {
        //     $contents[$row->type] = $row->active;
        // }
        // dd($contents['services_help']);
        // return view('pages.frontend.home.indexHome')->with('content', $content);
        return view('pages.frontend.home.indexHome', compact('contents', 'carouselHome', 'homeTab', 'homeAboutUs', 'homeHireUs', 'homeTestimonialTitle', 'homeTestimonial', 'homeAchievement', 'homeVendor'));
    }
    public function about()
    {
        $carouselAbout = $this->library->contentFirst(2); // 1
        $aboutVision = $this->library->contentFirst(12); // 2
        $aboutMission = $this->library->contentFirst(13); // 3
        $aboutImage = $this->library->contentGet(14); // 4
        $aboutMotivation = $this->library->contentGet(15); // 5
        $aboutAchievement = $this->library->contentGet(16); // 6
        $aboutLeadershipTitle = $this->library->contentFirst(17); // 7
        $aboutLeadership = $this->library->contentGet(18); // 8
        $aboutClientsTitle = $this->library->contentFirst(19); // 9
        $aboutClients = $this->library->contentGet(20); // 10

        $contents = $this->globalContent;
        return view('pages.frontend.about.indexAbout', compact('contents', 'carouselAbout', 'aboutVision', 'aboutMission', 'aboutImage', 'aboutMotivation', 'aboutAchievement', 'aboutLeadershipTitle', 'aboutLeadership', 'aboutClientsTitle', 'aboutClients'));
    }
    public function services()
    {
        $carouselServices = $this->library->contentFirst(3);
        $servicesTitle = $this->library->contentFirst(21);
        $servicesHelpTitle = $this->library->contentFirst(22);
        $servicesHelp = $this->library->contentGet(23);
        $servicesAction = $this->library->contentGet(24);
        $servicesInovation = $this->library->contentFirst(25);

        $contents = $this->globalContent;
        return view('pages.frontend.services.indexServices', compact('contents', 'carouselServices', 'servicesTitle', 'servicesHelpTitle', 'servicesHelp', 'servicesAction', 'servicesInovation'));
    }
    public function work()
    {
        $carouselWork = $this->library->contentFirst(4);
        $workActivity1 = $this->library->contentGet(26);
        $workActivity2 = $this->library->contentGet(27);
        $workActivity3 = $this->library->contentGet(28);
        $workActivity4 = $this->library->contentGet(29);

        $contents = $this->globalContent;
        return view('pages.frontend.work.indexWork', compact('contents', 'carouselWork', 'workActivity1', 'workActivity2', 'workActivity3', 'workActivity4'));
    }
    public function contact()
    {
        $contactsTitle = $this->library->contentFirst(30);
        $contactsMessageTitle = $this->library->contentFirst(31);

        $contents = $this->globalContent;
        return view('pages.frontend.contact.indexContact', compact('contents', 'contactsTitle', 'contactsMessageTitle'));
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
        $models = ServiceStatusMutation::get();
        return view('pages.frontend.statusService', compact('models', 'id'));
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
}
