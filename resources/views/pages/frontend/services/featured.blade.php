@if($contents['services_action'] == true)
<div class="container-fluid">
	<div class="row featured-boxes-full featured-boxes-full-scale clearfix">
		@foreach($servicesAction as $row)
		<div class="col-lg-4 featured-box-full featured-box-full-primary">
			<i class="{{ $row->icon }} icons"></i>
			<h4 class="mt-3">{{ $row->title }}</h4>
			<p>{{ $row->description }}</p>
		</div>
		@endforeach
	</div>
</div>
@endif