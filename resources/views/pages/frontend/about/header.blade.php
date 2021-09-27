@if($contents['carousel_about'] == true)
<div class="slider-container rev_slider_wrapper" style="height: 350px;">
	<div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': 800, 'gridheight': 350, 'spinner': 'off'}">
		<ul>
			<li data-transition="fade">
				<img 
					src="{{ asset($carouselAbout->image) }}"
					alt=""
					data-bgposition="center center" 
					data-bgfit="cover" 
					data-bgrepeat="no-repeat" 
					class="rev-slidebg">
			</li>
		</ul>
	</div>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8 mt-5 title-with-video-custom text-center">
			<h1 class="mt-5 pt-5 font-weight-semibold">{{ $carouselAbout->title }}</h1>
			<p class="mb-0 text-4 opacity-7"><?php echo $carouselAbout->description ?></p>
		</div>
	</div>
</div>
<!-- <section class="parallax section section-text-light section-parallax section-center mt-0 mb-5" data-plugin-parallax data-plugin-options="{'speed': 1.5}" data-image-src="{{ $carouselAbout->image }}" style="min-height: 560px;">
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-lg-8 mt-5">
				<h1 class="mt-5 pt-5 font-weight-semibold">{{ $carouselAbout->title }}</h1>
				<p class="mb-0 text-4 opacity-7">{{ $carouselAbout->description }}</p>
			</div>
		</div>
	</div>
</section> -->
@endif