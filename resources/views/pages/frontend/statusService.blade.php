@extends('layouts.frontend.default')
@section('title', 'Home')
@section('menu-active', 'home')
@push('custom-css')
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
@endpush
@section('content')
<div role="main" class="main">
	  <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Ini Id</h1>
          </div>
          <div class="section-body">
            <h2 class="section-title">September 2018</h2>
            <div class="row">
              <div class="col-12">
                <div class="activities">
                  <div class="activity">
                    <div class="activity-icon bg-primary text-white shadow-primary">
                      <i class="fas fa-comment-alt"></i>
                    </div>
                    <div class="activity-detail">
                      <div class="mb-2">
                        <span class="text-job text-primary">Tanggal</span>
                        <span class="bullet"></span>
                        <!-- <a class="text-job" href="#">View</a> -->
                      </div>
                      <p>Akan Dikerjakan</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
</div>
@endsection
@push('custom-script')
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush