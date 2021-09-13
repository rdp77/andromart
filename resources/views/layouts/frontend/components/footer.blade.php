<?php
use App\Models\Branch;

$branch = Branch::get();
?>
<footer id="footer">
	<div class="container">
		<div class="row py-5">
			<div class="col-md-4 d-flex justify-content-center justify-content-md-start mb-4 mb-lg-0">
				<a href="index.html" class="logo pr-0 pr-lg-3 pl-3 pl-md-0">
					<img alt="Porto Website Template" src="img/logo-default-slim-dark.png" height="33">
				</a>
			</div>
			<div class="col-md-8 d-flex justify-content-center justify-content-md-end mb-4 mb-lg-0">
				<div class="row">
					@foreach($branch as $row)
					<!-- <div class="col-lg-5 mb-4">
						<h4 class="mt-3 mb-0">{{ $row->name }}</h4>
						<ul class="list list-icons mt-3">
							<li><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong>{{ $row->address }}</li>
							<li><i class="fas fa-phone"></i> <strong>Phone:</strong> {{ $row->phone }}</li>
							<li><i class="far fa-envelope"></i> <strong>Email:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a></li>
						</ul>
					</div> -->
					<div class="col-md-6 mb-3 mb-md-0">
						<div class="ml-3 text-center text-md-right">
							<h5 class="text-3 mb-0 text-color-light">{{ $row->name }}</h5>
							<p class="text-4 mb-0"><i class="fab fa-whatsapp text-color-primary top-1 p-relative"></i><span class="pl-1">{{ $row->phone }}</span></p>            
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright footer-copyright-style-2">
		<div class="container py-2">
			<div class="row py-4">
				<div class="col-md-4 d-flex align-items-center justify-content-center justify-content-md-start mb-2 mb-lg-0">
					<p>© Copyright 2020. All Rights Reserved.</p>
				</div>
				<div class="col-md-8 d-flex align-items-center justify-content-center justify-content-md-end mb-4 mb-lg-0">
					<p><i class="far fa-envelope text-color-primary top-1 p-relative"></i><a href="mailto:mail@example.com" class="opacity-7 pl-1">mail@example.com</a></p>
					<ul class="footer-social-icons social-icons social-icons-clean social-icons-icon-light ml-3">
						<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
						<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
						<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>