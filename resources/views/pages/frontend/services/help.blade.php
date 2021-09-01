@if($contents['services_help_title'] == true && $contents['services_help'] == true)
<section class="m-5 pb-3">
	<div class="container pt-4 pb-3">
		<div class="row">
			<div class="col text-center">
				<h2 class="mb-0 mt-3 font-weight-bold text-6">{{ $servicesHelpTitle->title }}</h2>
				<p class="text-4 mb-3">{{ $servicesHelpTitle->subtitle }}</p>
				<div class="divider divider-primary divider-small divider-small-center mb-3">
					<hr>
				</div>
			</div>
		</div>
		<div class="row justify-content-center mt-5">
			@foreach($servicesHelp as $row)
			<div class="col-md-10 col-lg-4 text-center">
				<div class="feature-box feature-box-style-4 justify-content-center appear-animation" data-appear-animation="fadeInUp" data-appear-animation-delay="0">
					<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
						<span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
							<span class="box-content p-0 m-0">
								<i class="icon-featured {{ $row->icon }} icons"></i>
							</span>
						</span>
					</span>	
					<div class="feature-box-info">
						<h4 class="mb-2 mt-3 text-4 text-uppercase font-weight-bold">{{ $row->title }}</h4>
						<p class="mb-4">{{ $row->description }}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif