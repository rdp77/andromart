<section class="section section-default section-footer section-color-custom mt-0 pt-2 pb-5">
	<div class="container py-4">
		<div class="row align-items-center">
			@foreach($typeProduct as $row)
				<div class="col-12 col-lg-6 text-center" style="background-color: #fff;">
					<a href="{{ Route('frontendProductShow', $row->id) }}">
					<div>
						<img src="{{ asset('photo_product/'.$row->image) }}" style="width: 100%; object-fit: cover;">
						<br />
						<h3><b>{{ $row->name }}</b></h3>
						<br />
					</div>
					</a>
				</div>
			@endforeach
		</div>
	</div>
</section>