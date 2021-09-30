@if($contents['about_leadership'] == true && $contents['about_leadership_title'] == true)
<section class="m-5 pb-3">
	<div class="container py-4">
		@if($contents['about_leadership_title'] == true)
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="mb-0 mt-3 font-weight-extra-bold text-6">{{ $aboutLeadershipTitle->title }}</h2>
				<p class="text-4 mb-3">{{ $aboutLeadershipTitle->subtitle }}</p>
				<div class="divider divider-primary divider-small divider-small-center mb-3">
					<hr>
				</div>
			</div>
		</div>
		@endif
		@if($contents['about_leadership'] == true)
		<div class="row justify-content-center mt-4">
			<div class="col-lg-8">
				<div class="row mt-4 justify-content-center">
					@foreach($aboutLeadership as $row)
					<div class="col-lg-3 col-12 text-center mb-4">
						<div class="testimonial-author">
	                        <img src="{{ asset('$row->image') }}" class="img-fluid rounded-circle mb-0" alt="">
	                    </div>
						<h4 class="mt-3 mb-0">{{ $row->title }}</h4>
						<p class="mb-0">{{ $row->subtitle }}</p>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
@endif