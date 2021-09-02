@if($contents['about_vision'] == true && $contents['about_mission'] == true && $contents['about_image'] == true && $contents['about_motivation'] == true)
<div class="container">
	<div class="row mb-5 pb-5 mt-5 pt-5">
		@if($contents['about_vision'] == true && $contents['about_mission'] == true && $contents['about_motivation'] == true)
		<div class="col-lg-9">
			@if($contents['about_vision'] == true && $contents['about_mission'] == true)
			<div class="row">
				@if($contents['about_vision'] == true)
				<div class="col-lg-6">
					<h4 class="font-weight-extra-bold">{{ $aboutVision->title }}</h4>
					<p class="">{{ $aboutVision->description }}</p>
				</div>
				@endif
				@if($contents['about_mission'] == true)
				<div class="col-lg-6">
					<h4 class="font-weight-extra-bold">{{ $aboutMission->title }}</h4>
					<p class="">{{ $aboutMission->description }}</p>
				</div>
				@endif
			</div>
			@endif
			@if($contents['about_motivation'] == true)
				@foreach($aboutMotivation as $row)
				<blockquote class="mt-5 ml-4 blockquote-primary">
					{{ $row->decription }}
					<footer>{{ $row->title }}</footer>
				</blockquote>
				@endforeach
			@endif
		</div>
		@endif
		@if($contents['about_image'] == true)
		<div class="col-lg-3 d-none d-sm-block">
			<div class="row text-center mt-5 mt-lg-0">
				@foreach($aboutImage as $row)
				<div class="col-md-8 col-lg-6 mx-auto">
					<img class="img-fluid m-3 my-0 mt-lg-5" src="{{ $row->image }}" alt="Office">
				</div>
				@endforeach
			</div>
		</div>
		@endif
	</div>
</div>
@endif