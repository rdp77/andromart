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
                          <a class="nav-link" id="sales-tab3" data-toggle="tab" href="#sales3" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kas-tab3" data-toggle="tab" href="#kas3" role="tab" aria-controls="kas" aria-selected="false">Kas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="customer-tab3" data-toggle="tab" href="#customer3" role="tab" aria-controls="customer" aria-selected="false">Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="branch-tab3" data-toggle="tab" href="#branch3" role="tab" aria-controls="branch" aria-selected="false">Cabang</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="periode3" role="tabpanel" aria-labelledby="periode-tab3">
                            <div class="row">
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="startDate1">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate1" type="text" class="form-control datepicker" name="startDate1">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="endDate1">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate1" type="text" class="form-control datepicker" name="endDate1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.dataLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari</button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printPeriode()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="item3" role="tabpanel" aria-labelledby="item-tab3">
                            <div class="row">
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="startDate2">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate2" type="text" class="form-control datepicker" name="startDate2">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
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
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.itemLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari</button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printItem()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sales3" role="tabpanel" aria-labelledby="sales-tab3">
                            <div class="row">
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="startDate3">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate3" type="text" class="form-control datepicker" name="startDate3">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="endDate3">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate3" type="text" class="form-control datepicker" name="endDate3">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Sales') }}<code>*</code></label>
                                    <select name="sales" id="sales" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($sales as $sales)
                                        <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.salesLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari</button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printSales()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kas3" role="tabpanel" aria-labelledby="kas-tab3">
                            <div class="row">
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="startDate4">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate4" type="text" class="form-control datepicker" name="startDate4">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="endDate4">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate4" type="text" class="form-control datepicker" name="endDate4">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Akun Kas') }}<code>*</code></label>
                                    <select name="kas" id="kas" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($kas as $kas)
                                        <option value="{{ $kas->id }}">{{ $kas->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.kasLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari</button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printKas()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="customer3" role="tabpanel" aria-labelledby="customer-tab3">
                            <div class="row">
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="startDate5">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate5" type="text" class="form-control datepicker" name="startDate5">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="endDate5">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate5" type="text" class="form-control datepicker" name="endDate5">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Customer') }}<code>*</code></label>
                                    <select name="customer" id="customer" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($customer as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.customerLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari</button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printCustomer()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="branch3" role="tabpanel" aria-labelledby="branch-tab3">
                            <div class="row">
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="startDate6">{{ __('Tanggal Awal') }}<code>*</code></label>
                                    <input id="startDate6" type="text" class="form-control datepicker" name="startDate6">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label for="endDate6">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                    <input id="endDate6" type="text" class="form-control datepicker" name="endDate6">
                                </div>
                                <div class="form-group col-3 col-md-3 col-lg-3">
                                    <label>{{ __('Cabang') }}<code>*</code></label>
                                    <select name="branch" id="branch" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($branch as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->code }} - {{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('report-sale.branchLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari</button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printBranch()">
                                        <i class="fas fa-print"></i> Cetak Laporan
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
        {{-- <h2 class="section-title">Total Pendapatan</h2> --}}
          <div class="table-responsive" id="data-load">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" width="13%">Tanggal</th>
                        <th class="text-center" width="12%">Faktur</th>
                        <th class="text-center" width="25%">Barang</th>
                        <th class="text-center" width="18%">Akun Kas</th>
                        <th class="text-center" width="12%">Laba Kotor</th>
                        <th class="text-center" width="10%">HPP</th>
                        <th class="text-center" width="10%">Laba Bersih</th>
                    </tr>
                </thead>
                <tbody class="dropHere" style="border: none !important">
                </tbody>
                <tfoot>
                    <tr style="color: #6777ef;">
                        <th colspan="2"><h5>Jumlah Transaksi : 0</h5></th>
                        <th colspan="2"><h5>Pendapatan Kotor : Rp. 0</h5></th>
                        <th colspan="3"><h5>Pendapatan Bersih : Rp. 0</h5></th>
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
      var startDate1 = document.getElementById("startDate1").value;
      var startDate2 = document.getElementById("startDate2").value;
      var startDate3 = document.getElementById("startDate3").value;
      var startDate4 = document.getElementById("startDate4").value;
      var startDate5 = document.getElementById("startDate5").value;
      var startDate6 = document.getElementById("startDate6").value;
      var endDate1 = document.getElementById("endDate1").value;
      var endDate2 = document.getElementById("endDate2").value;
      var endDate3 = document.getElementById("endDate3").value;
      var endDate4 = document.getElementById("endDate4").value;
      var endDate5 = document.getElementById("endDate5").value;
      var endDate6 = document.getElementById("endDate6").value;
      var item = document.getElementById("item").value;
      var sales = document.getElementById("sales").value;
      var kas = document.getElementById("kas").value;
      var customer = document.getElementById("customer").value;
      var branch = document.getElementById("branch").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          startDate1,
          startDate2,
          startDate3,
          startDate4,
          startDate5,
          startDate6,
          endDate1,
          endDate2,
          endDate3,
          endDate4,
          endDate5,
          endDate6,
          item,
          sales,
          kas,
          customer,
          branch,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
  }

  function printPeriode() {
    var startDate1 = document.getElementById("startDate1").value;
    var endDate1 = document.getElementById("endDate1").value;
    window.location.href = '{{ route('print-report-sale.periode') }}?&startDate1=' + startDate1+'&endDate1=' + endDate1
  }

  function printItem() {
    var startDate2 = document.getElementById("startDate2").value;
    var endDate2 = document.getElementById("endDate2").value;
    var item = document.getElementById("item").value;
    window.location.href = '{{ route('print-report-sale.item') }}?&startDate2=' + startDate2+'&endDate2=' + endDate2+'&item=' + item
  }

  function printSales() {
    var startDate3 = document.getElementById("startDate3").value;
    var endDate3 = document.getElementById("endDate3").value;
    var sales = document.getElementById("sales").value;
    window.location.href = '{{ route('print-report-sale.sales') }}?&startDate3=' + startDate3+'&endDate3=' + endDate3+'&sales=' + sales
  }

  function printKas() {
    var startDate4 = document.getElementById("startDate4").value;
    var endDate4 = document.getElementById("endDate4").value;
    var kas = document.getElementById("kas").value;
    window.location.href = '{{ route('print-report-sale.kas') }}?&startDate4=' + startDate4+'&endDate4=' + endDate4+'&kas=' + kas
  }

  function printCustomer() {
    var startDate5 = document.getElementById("startDate5").value;
    var endDate5 = document.getElementById("endDate5").value;
    var customer = document.getElementById("customer").value;
    window.location.href = '{{ route('print-report-sale.customer') }}?&startDate5=' + startDate5+'&endDate5=' + endDate5+'&customer=' + customer
  }

  function printBranch() {
    var startDate6 = document.getElementById("startDate6").value;
    var endDate6 = document.getElementById("endDate6").value;
    var branch = document.getElementById("branch").value;
    window.location.href = '{{ route('print-report-sale.branch') }}?&startDate6=' + startDate6+'&endDate6=' + endDate6+'&branch=' + branch
  }
</script>
@endsection
