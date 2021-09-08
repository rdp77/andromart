@extends('layouts.frontend.default')
@section('title', 'Home')
@section('menu-active', 'home')
@push('custom-css')
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
@endpush
@section('content')
<div role="main" class="main">
@if(count($models) == 0)
  <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h1>404</h1>
            <div class="page-description">
              Maaf data service yang anda cari tidak tersedia
            </div>
            <div class="page-search">
              <div class="mt-3">
                <a href="/">Kembali</a>
              </div>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
          Copyright &copy; Stisla 2021
        </div>
      </div>
    </section>
@else
	  <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $id }}</h1>
          </div>
          <div class="section-body">
            <!-- <h2 class="section-title">September 2018</h2> -->
            <div class="row">
              <div class="col-12">
                <div class="activities">
                    @foreach($models as $row)
                    @php $tanggal = date('d-M-Y', strtotime($row->created_at)); @endphp
                    <div class="activity">
                      <div class="activity-icon bg-primary text-white shadow-primary">
                        <i class="fas fa-comment-alt"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job text-primary">{{ $tanggal }}</span>
                          <span class="bullet"></span>
                          <p>{{ $row->status }}</p>
                        </div>
                        <p>{{ $row->description }}</p>
                      </div>
                    </div>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div style="height: 500px;">
      </div>
@endif
</div>
@endsection
@push('custom-script')
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush