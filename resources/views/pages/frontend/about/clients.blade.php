@if($contents['about_clients'] == true && $contents['about_clients_title'] == true)
<section class="section section-default section-footer border-0">
	<div class="container py-4">
		@if($contents['about_clients_title'] == true)
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="mb-0 mt-3 font-weight-extra-bold text-6">{{ $aboutClientsTitle->title }}</h2>
				<p class="text-4 mb-3">{{ $aboutClientsTitle->subtitle }}</p>
				<div class="divider divider-primary divider-small divider-small-center mb-3">
					<hr>
				</div>
			</div>
		</div>
		@endif
		@if($contents['about_clients'] == true)
		<div class="row mt-4">
			<div class="content-grid col mt-5 mb-4">
				<div class="row content-grid-row">
					@foreach($aboutClients as $row)
						<div class="content-grid-item col-lg-4 text-center py-4">
							<img class="img-fluid" src="{{ asset('$row->image') }}" style="max-width: 180px" alt="">
						</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
@endif