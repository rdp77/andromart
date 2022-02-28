@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Laporan Pendapatan & Pengeluaran'))
@section('titleContent', __('Laporan Pendapatan & Pengeluaran'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Laporan Pendapatan & Pengeluaran') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')

{{-- <style>
    .areaToPrint{
        font-size: 10px;
    }
</style> --}}

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
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                            <input id="startDate" type="text" class="form-control datepicker"  name="startDate">
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            <label for="endDate">{{ __('Tanggal Akhir') }}<code>*</code></label>
                            <input id="endDate" type="text" class="form-control datepicker" name="endDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            <label for="startDate">{{ __('Tipe') }}<code>*</code></label>
                            <select class="form-control tipe" name="tipe">
                                <option value="">- select -</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                                <option value="Pemasukan">Pemasukan</option>
                            </select>
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            <label for="startDate">{{ __('cabang') }}<code>*</code></label>
                            <select class="form-control cabang" name="cabang">
                                <option value="">- select -</option>
                                @foreach ($branch as $el)
                                    <option value="{{$el->id}}">{{$el->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <button class="btn btn-primary" style="margin-right: 20px" type="button" onclick="checkData()"><i class="fas fa-eye"></i> Cari</button>
                            <button class="btn btn-warning" type="button" onclick="printDiv()"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-12">
        <h2 class="section-title">Total Pendapatan & Pengeluaran</h2>
        <div class="table-responsive">
          <table class="table table-striped " id="areaToPrint">
              <thead>
                  <tr>
                      <th>Nama</th>
                      <th>Tanggal</th>
                      <th>Transaksi</th>
                      <th>Akun</th>
                      <th>Debet</th>
                      <th>Kredit</th>
                      {{-- <th>total</th> --}}
                  </tr>
              </thead>
              <tbody class="dropHere" style="border: none !important">
              </tbody>
              <tfoot>
                  <tr>
                      <th colspan="3"><h5>Pengeluaran : <b class="dropPengeluaran">Rp. 0</b></h5></th>
                      <th colspan="3"><h5>Pendapatan : <b class="dropPendapatan">Rp. 0</b></h5></th>
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

<script src="{{ asset('assets/pages/finance/reportIncomeSpending.js') }}"></script>

@endsection
