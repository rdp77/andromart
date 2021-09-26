<div class="slider-container rev_slider_wrapper" style="height: 750px;">
    <div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': 1110, 'gridheight': [750,750,750,1250], 'responsiveLevels': [4096,1200,992,500]}">
        <ul>
        @foreach($carouselHome as $row)
            @if($row->position == "Left")
            <li class="slide-overlay slide-overlay-level-7" data-transition="fade">
                <img src="{{ asset($row->image) }}"
                    alt=""
                    data-bgposition="center center" 
                    data-bgfit="cover" 
                    data-bgrepeat="no-repeat" 
                    data-kenburns="on"
                    data-duration="9000"
                    data-ease="Linear.easeNone"
                    data-scalestart="115"
                    data-scaleend="100"
                    data-rotatestart="0"
                    data-rotateend="0"
                    data-offsetstart="0 -200"
                    data-offsetend="0 200"
                    data-bgparallax="0"
                    class="rev-slidebg">

                <div class="tp-caption tp-caption-overlay-opacity top-label font-weight-semibold"
                    data-frames='[{"delay":1000,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                    data-x="left" data-hoffset="['0','30','30','30']"
                    data-y="center" data-voffset="['-65','-65','-69','-73']"
                    data-fontsize="['18','18','18','30']"
                    data-paddingtop="['10','10','10','12']"
                    data-paddingbottom="['10','10','10','12']"
                    data-paddingleft="['18','18','18','18']"
                    data-paddingright="['18','18','18','18']">{{ $row->title }}</div>

                <h1 class="tp-caption tp-caption-overlay-opacity main-label"
                    data-frames='[{"delay":1300,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                    data-x="left" data-hoffset="['0','30','30','30']"
                    data-y="center"
                    data-fontsize="['50','50','50','60']"
                    data-letterspacing="0"
                    data-paddingtop="['10','10','10','10']"
                    data-paddingbottom="['10','10','10','10']"
                    data-paddingleft="['18','18','18','18']"
                    data-paddingright="['18','18','18','18']">{{ $row->subtitle }}</h1>

                <!-- <div class="tp-caption d-none d-md-block"
                    data-frames='[{"delay":3000,"speed":500,"frame":"0","from":"opacity:0;x:10%;","to":"opacity:1;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                    data-x="left" data-hoffset="['330','360','360','135']"
                    data-y="center" data-voffset="['30','30','30','-62']"><img src="assetsfrontend/img/slides/slide-white-line.png" alt=""></div> -->


                <div class="tp-caption font-weight-light text-color-light ws-normal"
                    data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                    data-x="left" data-hoffset="['3','35','35','35']"
                    data-y="center" data-voffset="['65','65','65','95']"
                    data-width="['690','690','690','800']"
                    data-fontsize="['18','18','18','35']"
                    data-lineheight="['29','29','29','40']">{{ $row->description }}</div>
            </li>
            @else
            <li class="slide-overlay slide-overlay-level-7" data-transition="fade">
                <img src="{{ asset($row->image) }}"  
                    alt=""
                    data-bgposition="center center" 
                    data-bgfit="cover" 
                    data-bgrepeat="no-repeat" 
                    data-kenburns="on"
                    data-duration="9000"
                    data-ease="Linear.easeNone"
                    data-scalestart="115"
                    data-scaleend="100"
                    data-rotatestart="0"
                    data-rotateend="0"
                    data-offsetstart="0 400px"
                    data-offsetend="0 -400px"
                    data-bgparallax="0"
                    class="rev-slidebg">

                <div class="tp-caption tp-caption-overlay-opacity top-label font-weight-semibold"
                    data-frames='[{"delay":1000,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                    data-x="left" data-hoffset="['550','550','550','450']"
                    data-y="center" data-voffset="['-65','-65','-69','-73']"
                    data-fontsize="['18','18','18','30']"
                    data-paddingtop="['10','10','10','12']"
                    data-paddingbottom="['10','10','10','12']"
                    data-paddingleft="['18','18','18','18']"
                    data-paddingright="['18','18','18','18']">{{ $row->title }}</div>

                <div class="tp-caption tp-caption-overlay-opacity main-label"
                    data-frames='[{"delay":1300,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                    data-x="left" data-hoffset="['550','550','550','450']"
                    data-y="center"
                    data-fontsize="['50','50','50','60']"
                    data-paddingtop="['10','10','10','12']"
                    data-paddingbottom="['10','10','10','12']"
                    data-paddingleft="['18','18','18','18']"
                    data-paddingright="['18','18','18','18']">{{ $row->subtitle }}</div>

                <div class="tp-caption font-weight-light text-color-light ws-normal"
                    data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                    data-x="left" data-hoffset="['550','550','550','450']"
                    data-y="center" data-voffset="['65','65','65','105']"
                    data-width="['600','600','600','600']"
                    data-fontsize="['18','18','18','30']"
                    data-lineheight="['29','29','29','40']"
                    style="margin-top: 30px;">{{ $row->description }}</div>

                <!-- <a class="tp-caption btn btn-primary font-weight-bold"
                    href="#"
                    data-frames='[{"delay":3000,"speed":2000,"frame":"0","from":"y:50%;opacity:0;","to":"y:0;o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                    data-x="left" data-hoffset="['550','550','550','450']"
                    data-y="center" data-voffset="['140','140','140','235']"
                    data-paddingtop="['16','16','16','31']"
                    data-paddingbottom="['16','16','16','31']"
                    data-paddingleft="['40','40','40','50']"
                    data-paddingright="['40','40','40','50']"
                    data-fontsize="['13','13','13','25']"
                    data-lineheight="['20','20','20','25']">GET STARTED NOW <i class="fas fa-arrow-right ml-1"></i></a> -->

            </li>
            @endif
        @endforeach
        </ul>
    </div>
</div>