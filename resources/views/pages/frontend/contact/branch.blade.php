@if($contents['contacts_title'] == true && $contents['contacts_message_title'] == true)
<section class="section section-text-light section-default bg-color-dark section-center border-top-0 mt-0">
	<div class="container">
		@if($contents['contacts_title'] == true)
		<div class="row justify-content-center">
			<div class="col-lg-8 mt-5">
				<h1 class="mt-5 font-weight-semibold">{{ $contactsTitle->title }}</h1>
				<p class="mb-0 text-4 opacity-7">{{ $contactsTitle->subtitle }}</p>
			</div>
		</div>
		@endif
		<div class="row justify-content-center mt-4">
			<div class="col-lg-10">
				<div class="row justify-content-between mt-4 text-left">
					@foreach($branch as $row)
					<div class="col-lg-5 mb-4">
						<h4 class="mt-3 mb-0">{{ $row->name }}</h4>
						<ul class="list list-icons mt-3">
							<li><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong>{{ $row->address }}</li>
							<li><i class="fas fa-phone"></i> <strong>Phone:</strong> {{ $row->phone }}</li>
							<li><i class="far fa-envelope"></i> <strong>Email:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a></li>
						</ul>
					</div>
					@endforeach
				</div>
			</div>
		</div>

		@if($contents['contacts_message_title'] == true)
		<div class="row justify-content-center mt-4">
			<div class="col-lg-10 text-center">

				<div class="divider divider-primary divider-small divider-small-center mb-3">
					<hr>
				</div>

				<h2 class="mb-0 mt-4 font-weight-semibold">{{ $contactsMessageTitle->title }}</h2>
				<p class="text-4 mb-0 opacity-7">{{ $contactsMessageTitle->subtitle }}</p>

				<div class="divider divider-style-4 divider-primary divider-top-section-custom taller">
					<i class="fas fa-chevron-down"></i>
				</div>

			</div>
		</div>
		@endif
	</div>
</section>
@endif