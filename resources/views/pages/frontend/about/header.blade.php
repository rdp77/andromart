@if($contents['carousel_about'] == true)
<section class="parallax section section-text-light section-parallax section-center mt-0 mb-5" data-plugin-parallax data-plugin-options="{'speed': 1.5}" data-image-src="{{ $carouselAbout->image }}" style="min-height: 560px;">
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-lg-8 mt-5">
				<h1 class="mt-5 pt-5 font-weight-semibold">{{ $carouselAbout->title }}</h1>
				<p class="mb-0 text-4 opacity-7">{{ $carouselAbout->description }}</p>
			</div>
		</div>
	</div>
</section>
@endif