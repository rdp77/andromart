@if($contents['about_achievement'] == true)
<section class="section section-default border-0">
	<div class="container py-4">
		<div class="row counters justify-content-center">
			@foreach($aboutAchievement as $row)
			@php $angka = (int)$row->subtitle @endphp
			<div class="col-sm-6 col-lg-3 mb-5 mb-lg-0">
				<div class="counter">
					<i class="icons {{ $row->icon }} text-color-dark"></i>
					<strong class="text-color-dark font-weight-extra-bold" data-to="{{ $angka }}" data-append="+">0</strong>
					<label class="text-4 mt-1">{{ $row->title }}</label>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif