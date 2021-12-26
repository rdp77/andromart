@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Laporan Penjualan'))
@section('titleContent', __('Laporan Penjualan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Laporan Penjualan') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
<form class="form-data">
    @csrf
    <section class="section">
      <div class="row">
        <div class="col-12">
          <h2 class="section-title">Search Data </h2>
          <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-3 col-md-3 col-lg-3">
                            <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                            <input id="startDate" type="text" class="form-control datepicker" name="startDate">
                        </div>
                        <div class="form-group col-3 col-md-3 col-lg-3">
                            <label for="endDate">{{ __('Tanggal Akir') }}<code>*</code></label>
                            <input id="endDate" type="text" class="form-control datepicker" name="endDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.dataLoad') }}', '#data-load')">
                                <i class="fas fa-eye"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-12">
        {{-- <h2 class="section-title">Total Pendapatan</h2> --}}
          <div class="table-responsive" id="data-load">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="15%">Tanggal</th>
                        <th width="12%">Faktur</th>
                        <th width="25%">Barang</th>
                        <th width="18%">Akun Kas</th>
                        <th width="15%">Laba Kotor</th>
                        <th width="15%">Laba Bersih</th>
                    </tr>
                </thead>
                <tbody class="dropHere" style="border: none !important">
                </tbody>
                <tfoot>
                    <tr style="color: #6777ef;">
                        <th colspan="2"><h5>Jumlah Transaksi : 0</h5></th>
                        <th colspan="2"><h5>Pendapatan Kotor : Rp. 0</h5></th>
                        <th colspan="2"><h5>Pendapatan Bersih : Rp. 0</h5></th>
                    </tr>
                </tfoot>
            </table>

        </div>
      </div>
  </section>
</form>
@endsection
@section('script')
{{-- <script src="{{ asset('assets/pages/report/reportSale.js') }}"></script> --}}
<script type="text/javascript">
  var loading = `-- sedang memuat data --`;
  function changes(token, url, target) {
      var startDate = document.getElementById("startDate").value;
      var endDate = document.getElementById("endDate").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          startDate,
          endDate,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
  }
</script>
@endsection
