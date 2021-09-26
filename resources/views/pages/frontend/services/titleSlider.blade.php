@if($contents['carousel_services'] == true)
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8 mt-5 title-with-video-custom text-center">
			<h2 class="mt-4 pt-4 font-weight-semibold">{{ $carouselServices->title }}</h2>
			<h4 class="mt-1 pt-1 font-weight-semibold"><?php echo $carouselServices->description ?></h4>
		</div>
	</div>
</div>
@endif