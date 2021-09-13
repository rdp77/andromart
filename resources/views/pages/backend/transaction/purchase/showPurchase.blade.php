@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Notulensi'))
@section('titleContent', __('Detail'))
@section('breadcrumb', __('Tanggal ').date('d-M-Y'))

@section('content')
<!-- @include('layouts.backend.components.notification') -->
		<div class="section-body">
            <h2 class="section-title">{{ $models->name }}</h2>
            <p class="section-lead">{{ $models->date }}</p>

            <div class="row">
              <div class="col-12">
                <div class="card author-box card-primary">
                  <div class="card-body">
                    <!-- <div class="author-box-details"> -->
                      <div class="author-box-name">
                        <a href="#">{{ $models->title }}</a>
                      </div>
                      <!-- <div class="author-box-job">Judul</div> -->
                      <div class="author-box-description">
                        <div><?php echo $models->description; ?></div>
                      </div>
                      <div class="author-box-job">Foto</div>
                      <div class="gallery">
                        <div class="row">
                        @php $no = 1 @endphp
                        @foreach($modelsFile as $rows)
                          <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article" style="text-align: center;">
                              <!-- <div class="article-header">
                                <div class="article-title">
                                </div>
                              </div> -->
                                  <h2>{{ $rows->description }}</h2>
                              <div class="article-details">
                                <i class="fas fa-file" style="font-size: 150px; margin-bottom: 20px;"></i>
                                <!-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. </p> -->
                                <div class="article-cta">
                                  <a href="{{ asset($rows->photo) }}" class="btn btn-primary" target="_blank">Unduh</a>
                                </div>
                              </div>
                            </article>
                          </div>
	                       <!-- <div class="gallery-item" data-image="{{ URL::to($rows->file) }}" data-title="Image {{ $no++ }}"></div> -->
                        @endforeach
                        </div>
                      </div>
                    <!-- </div> -->
                  </div>
                </div>	
              </div>
            </div>
          </div>
@endsection