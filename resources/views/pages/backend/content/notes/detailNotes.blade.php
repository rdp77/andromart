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
                        @php $no = 1 @endphp
                        @foreach($modelsPhoto as $rows)
	                       <div class="gallery-item" data-image="{{ URL::to($rows->photo) }}" data-title="Image {{ $no++ }}"></div>
                        @endforeach
                      </div>
                    <!-- </div> -->
                  </div>
                </div>	
              </div>
            </div>
          </div>
@endsection