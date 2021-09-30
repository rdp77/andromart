@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Peraturan'))
@section('titleContent', __('Peraturan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Peraturan') }}</div>
@endsection

@section('content')
<div class="section-body">
  <h2 class="section-title">Peraturan</h2>
  <!-- <p class="section-lead">
    Some customers need your help.
  </p> -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
              <h4>{{ $model->title }}</h4>
              <div class="font-weight-600">{{ $model->roleName }}</div>
              <div class="bullet"></div>
              <div class="font-weight-600">{{ $model->roleBranch }}</div>
              @if($imageLength <= 1)
                <div class="gallery gallery-fw" data-item-height="500">
                  <div class="gallery-item" data-image="{{ asset($image[0]) }}" data-title="Image 1"></div>
                </div>
              @else
                <div class="gallery gallery-fw" data-item-height="500">
                  <div class="gallery-item" data-image="{{ asset($image[0]) }}" data-title="Image 1"></div>
                </div>
                <div class="gallery">
                @foreach($image as $i => $row)
                  @if($i != 0)
                    <div class="gallery-item" data-image="{{ asset($row) }}" data-title="Image 1"></div>
                  @endif
                @endforeach
                </div>
              @endif
              <?php echo $model->description ?>
              <h6>File tambahan : </h6>
              <div class="row">
              @foreach($file as $key => $value)
                <div class="col-2">
                  <center><i class="fas fa-file-alt" style="font-size: 20px;"></i></center>
                  <center><a href="{{ asset($value) }}"> Unduh</a></center>
                </div>
              @endforeach
              </div>
            </div>
            <div class="col-1"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/office/regulationScript.js') }}"></script>
@endsection
