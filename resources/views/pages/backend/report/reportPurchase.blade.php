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
          <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="periode-tab3" data-toggle="tab" href="#periode3" role="tab" aria-controls="periode" aria-selected="true">Periode</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="item-tab3" data-toggle="tab" href="#item3" role="tab" aria-controls="item" aria-selected="false">Item</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="supplier-tab3" data-toggle="tab" href="#supplier3" role="tab" aria-controls="supplier" aria-selected="false">Supplier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="branch-tab3" data-toggle="tab" href="#branch3" role="tab" aria-controls="branch" aria-selected="false">Cabang</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="periode3" role="tabpanel" aria-labelledby="periode-tab3">
                            <div class="row">
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="startDate1">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate1" type="text" class="form-control datepicker" name="startDate1">
                                </div>
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="endDate1">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate1" type="text" class="form-control datepicker" name="endDate1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-purchase.dataLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="item3" role="tabpanel" aria-labelledby="item-tab3">
                            <div class="row">
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="startDate2">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate2" type="text" class="form-control datepicker" name="startDate2">
                                </div>
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="endDate2">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate2" type="text" class="form-control datepicker" name="endDate2">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Item') }}<code>*</code></label>
                                    <select name="item" id="item" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($stock as $stock)
                                        <option value="{{ $stock->item->id }}">{{ $stock->item->brand->category->name }} {{ $stock->item->brand->name }} - {{ $stock->item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-purchase.itemLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="supplier3" role="tabpanel" aria-labelledby="supplier-tab3">
                            <div class="row">
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="startDate3">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate3" type="text" class="form-control datepicker" name="startDate3">
                                </div>
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="endDate3">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate3" type="text" class="form-control datepicker" name="endDate3">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Supplier') }}<code>*</code></label>
                                    <select name="supplier" id="supplier" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($supplier as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-purchase.supplierLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="branch3" role="tabpanel" aria-labelledby="branch-tab3">
                            <div class="row">
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="startDate4">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate4" type="text" class="form-control datepicker" name="startDate4">
                                </div>
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="endDate4">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate4" type="text" class="form-control datepicker" name="endDate4">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Cabang') }}<code>*</code></label>
                                    <select name="branch_id" id="branch_id" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($branch as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->code }} - {{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-purchase.branchLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                            </div>
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
      var startDate1 = document.getElementById("startDate1").value;
      var startDate2 = document.getElementById("startDate2").value;
      var startDate3 = document.getElementById("startDate3").value;
      var startDate4 = document.getElementById("startDate4").value;
      var endDate1 = document.getElementById("endDate1").value;
      var endDate2 = document.getElementById("endDate2").value;
      var endDate3 = document.getElementById("endDate3").value;
      var endDate4 = document.getElementById("endDate4").value;
      var item = document.getElementById("item").value;
      var supplier = document.getElementById("supplier").value;
      var branch_id = document.getElementById("branch_id").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          startDate1,
          startDate2,
          startDate3,
          startDate4,
          endDate1,
          endDate2,
          endDate3,
          endDate4,
          item,
          supplier,
          branch_id,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
  }
</script>
@endsection
