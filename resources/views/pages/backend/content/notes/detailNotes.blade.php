@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Notulensi'))
@section('titleContent', __('Detail'))
@section('breadcrumb', __('Tanggal ').date('d-M-Y'))

@section('content')
<!-- @include('layouts.backend.components.notification') -->
		<div class="section-body">
            <h2 class="section-title">Users</h2>
            <p class="section-lead">01 Januari 2020</p>

            <div class="row">
              <div class="col-12">
                <div class="card author-box card-primary">
                  <div class="card-body">
                    <!-- <div class="author-box-details"> -->
                      <div class="author-box-name">
                        <a href="#">Judul</a>
                      </div>
                      <!-- <div class="author-box-job">Judul</div> -->
                      <div class="author-box-description">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                      </div>
                      <div class="author-box-job">Foto</div>
                      <div class="gallery">
	                      <div class="gallery-item" data-image="../assets/img/news/img01.jpg" data-title="Image 1"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img02.jpg" data-title="Image 2"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img03.jpg" data-title="Image 3"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img04.jpg" data-title="Image 4"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img05.jpg" data-title="Image 5"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img06.jpg" data-title="Image 6"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img07.jpg" data-title="Image 7"></div>
	                      <div class="gallery-item" data-image="../assets/img/news/img08.jpg" data-title="Image 8"></div>
                      </div>
                    <!-- </div> -->
                  </div>
                </div>	
              </div>
            </div>
          </div>
@endsection