@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Laporan Pembelian'))
@section('titleContent', __('Laporan Pembelian'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Laporan Pembelian') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
<form class="form-data">
    @csrf
    <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <h2 class="section-title">Search Data </h2>
          <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3 col-lg-3">
                            <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                            <input id="startDate" type="text" class="form-control datepicker" name="startDate">
                        </div>
                        <div class="form-group col-md-3 col-lg-3">
                            <label for="endDate">{{ __('Tanggal Akir') }}<code>*</code></label>
                            <input id="endDate" type="text" class="form-control datepicker" name="endDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-purchase.dataLoad') }}', '#data-load')"><i class="fas fa-eye"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-12">
        {{-- <h2 class="section-title">Total Pendapatan & Pengeluaran</h2> --}}
          <div class="table-responsive" id="data-load">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th>Akun Kas</th>
                        <th>Operator</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody class="dropHere" style="border: none !important">
                </tbody>
                <tfoot>
                    <tr style="color: #6777ef">
                        <th colspan="4"><h5>Jumlah Transaksi : 0</h5></th>
                        <th colspan="3"><h5>Total Pengeluaran : Rp. 0</h5></th>
                        {{-- <th colspan="2"><h5>Pendapatan Bersih : <b class="dropPendapatan">Rp. 0</b></h5></th> --}}
                    </tr>
                </tfoot>
            </table>
            {{-- <div class="dropHereTotalVal"></div> --}}

        </div>
      </div>
  </section>
</form>
@endsection
@section('script')
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
