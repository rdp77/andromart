@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Peraturan'))
@section('titleContent', __('Peraturan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Peraturan') }}</div>
@endsection

@section('content')
<div class="section-body">
  <!-- <h2 class="section-title">Overview</h2>
  <p class="section-lead">
    Organize and adjust all settings about this site.
  </p> -->

  <div class="row">
    @foreach($models as $row)
    <div class="col-lg-4 col-sm-6 col-12">
      <a href="/office/regulation/select-sop/{{ $row->id }}">
        <div class="card card-statistic-2">
            <div class="card-icon bg-primary text-white">
                <i class="fas fa-cog"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ $row->title }}</h4>
                </div>
                <div class="card-body">
                  <p>{{ $row->roleName }}</p>
                </div>
            </div>
        </div>
      </a>
    </div>
    @endforeach
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/office/regulationScript.js') }}"></script>
@endsection
