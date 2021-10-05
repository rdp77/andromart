@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Visi Misi'))
@section('titleContent', __('Visi Misi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Visi Misi') }}</div>
@endsection

@section('content')
<div class="section-body">
<div class="card">
  <div class="card-header">
      <a href="{{ route('regulationVisi') }}" class="btn btn-icon icon-left btn-primary">
          <i class="far fa-edit"></i>{{ __(' Ubah Visi') }}</a>
      <a href="{{ route('regulationMisi') }}" class="btn btn-icon icon-left btn-primary" style="margin-left: 10px;">
          <i class="far fa-edit"></i>{{ __(' Ubah Misi') }}</a>
  </div>
  <div class="card-body">
  <div class="row">
    <div class="col-12">
      <h3>Visi</h3>
      <?php echo $visi->description ?>
    </div>
    <div class="col-12" style="margin-top: 30px;">
      <h3>Misi</h3>
      <?php echo $misi->description ?>
    </div>
  </div>
  </div>
</div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/office/regulationScript.js') }}"></script>
@endsection
