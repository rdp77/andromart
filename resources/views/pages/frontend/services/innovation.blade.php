@if($contents['services_innovation'] == true)
<section class="section section-default section-footer section-color-custom mt-0 pt-2 pb-5">
	<div class="container py-4">
		<div class="row mt-2 mb-4 align-items-center">
			<div class="col-4 text-center">
				<img class="img-fluid appear-animation mt-5 pt-5" src="{{ asset('$servicesInovation->image') }}" style="width: 125% !important; max-width: 125%; left: -25%; position: relative;" alt="layout styles" data-appear-animation="fadeInLeft">
			</div>
			<div class="col-8">
				<h2 class="mb-1 mt-5 font-weight-bold text-6">{{ $servicesInovation->title }}</h2>
				<div class="divider divider-primary divider-small mb-5">
					<hr>
				</div>
				<p class="lead">
					{{ $servicesInovation->subtitle }}
				</p>
				<p>
					<?php echo $servicesInovation->description ?>
				</p>
				<a class="btn btn-outline btn-primary text-1 font-weight-semibold text-uppercase px-5 btn-py-2 mb-3" href="{{ $servicesInovation->url }}">Get a Quote</a>
			</div>
		</div>
	</div>
</section>
@endif