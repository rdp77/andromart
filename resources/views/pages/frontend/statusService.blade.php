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
@if($service == null)
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
            <h1>Kode Service : {{ $id }}</h1>
          </div>
          <div class="section-body">
            <!-- <h2 class="section-title">September 2018</h2> -->
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5>Data Pelanggan</h5>
                    <table>
                      <tr>
                        <td width="100">Nama</td><td width="10"> : </td><td>{{ $service->customer_name }}</td>
                      </tr>
                      <tr>
                        <td>Telepon</td><td> : </td><td>{{ $service->customer_phone }}</td>
                      </tr>
                      <tr>
                        <td>Alamat</td><td> : </td><td>{{ $service->customer_address }}</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5>Data Barang</h5>
                    <table>
                      <tr>
                        <td width="100">Jenis Barang</td><td width="10"> : </td><td>{{ $service->Brand->Category->name }}</td>
                      </tr>
                      <tr>
                        <td>Merk</td><td> : </td><td>{{ $service->Brand->name }}</td>
                      </tr>
                      <tr>
                        <td>Tipe</td><td> : </td><td>{{ $service->Type->name }}</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5>Detail Service</h5>
                    <table>
                      <tr>
                        <td width="100">Dikerjakan oleh</td><td width="10"> : </td><td>{{$service->employee1->name}}</td>
                      </tr>
                      <tr>
                        <td>Keluhan</td><td> : </td><td>{{$service->complaint}}</td>
                      </tr>
                      <tr>
                        <td>Analisa</td><td> : </td><td>{{$service->estimate_day}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5>Kondisi Barang Awal</h5>
                    <img src="{{ asset('storage/'.$service->image) }}" style="width: 250px;">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header"><h5>Tracking Service</h5></div>
                  <div class="card-body">
                    <div class="activities">
                        @foreach($service->ServiceStatusMutation as $row)
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
                            <p>{{ asset($row->image) }}</p>
                          </div>
                        </div>
                        @endforeach
                    </div>
                  </div>
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