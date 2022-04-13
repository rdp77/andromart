@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Laporan Pembayaran Service'))
@section('titleContent', __('Laporan Pembayaran Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Laporan Pembayaran Service') }}</div>
@endsection

@section('content')
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
                                    <button class="btn btn-primary" type="button"
                                        onclick="changes('{{ csrf_token() }}', '{{ route('report-service-payment.dataLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <button class="btn btn-primary" type="button" onclick="printPeriode()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="branch3" role="tabpanel" aria-labelledby="branch-tab3">
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
                                    <label for="branch">{{ __('Cabang') }}<code>*</code></label>
                                    <select class="select2 branch" id="branch_id" name="branch_id">
                                        <option value="">- Select -</option>
                                        @foreach ($branch as $branch)
                                        <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 col-md-3">
                                    <button class="btn btn-primary" type="button" 
                                        onclick="changes('{{ csrf_token() }}', '{{ route('report-service-payment.branchLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
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
          <div class="table-responsive" id="data-load">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="12%">Tanggal</th>
                        <th class="text-center" width="25%" colspan="2">Faktur</th>
                        <th class="text-center" width="13%">Customer</th>
                        <th class="text-center" width="18%">Status</th>
                        <th class="text-center" width="13%">Keterangan</th>
                        <th class="text-center" width="14%">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="dropHere" style="border: none !important">
                </tbody>
                <tfoot>
                    <tr style="color: #6777ef;">
                        <th colspan="2" class="text-left"><h5>Jumlah Transaksi : 0</h5></th>
                        <th colspan="2" class="text-center"><h5>Pendapatan Kotor : Rp. 0</h5></th>
                        <th colspan="3" class="text-right"><h5>Pendapatan Bersih : Rp. 0</h5></th>
                    </tr>
                </tfoot>
            </table>
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
      var endDate1 = document.getElementById("endDate1").value;
      var endDate2 = document.getElementById("endDate2").value;
      var branch_id = document.getElementById("branch_id").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          startDate1,
          startDate2,
          endDate1,
          endDate2,
          branch_id,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
  }

  function printPeriode() {
    var startDate1 = document.getElementById("startDate1").value;
    var endDate1 = document.getElementById("endDate1").value;
    window.location.href = '{{ route('print-report-service-payment.periode') }}?&startDate1=' + startDate1+'&endDate1=' + endDate1+'&branch_id=' + branch_id
  }
  function printBranch() {
    var startDate2 = document.getElementById("startDate2").value;
    var endDate2 = document.getElementById("endDate2").value;
    var branch_id = document.getElementById("branch_id").value;
    window.location.href = '{{ route('print-report-service-payment.branch') }}?&startDate2=' + startDate2+'&endDate2=' + endDate2+'&branch_id=' + branch_id
  }
</script>
@endsection
