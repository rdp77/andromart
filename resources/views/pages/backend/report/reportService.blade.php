@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Laporan Service'))
@section('titleContent', __('Laporan Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Laporan Service') }}</div>
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
                          <a class="nav-link" id="type-tab3" data-toggle="tab" href="#type3" role="tab" aria-controls="type" aria-selected="false">Series</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="technician-tab3" data-toggle="tab" href="#technician3" role="tab" aria-controls="technician" aria-selected="false">Teknisi</a>
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
                                        onclick="changes('{{ csrf_token() }}', '{{ route('report-service.dataLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    {{-- <a href="{{ route('print-report-service.periode') }}"
                                        target="_blank" class="btn btn-primary" type="button">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </a> --}}
                                    <button class="btn btn-primary" type="button"
                                        onclick="changes('{{ csrf_token() }}', '{{ route('print-report-service.periode') }}')">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="type3" role="tabpanel" aria-labelledby="type-tab3">
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
                                    <label for="type">{{ __('Merk') }}<code>*</code></label>
                                    <select class="select2 type" id="type_id" name="type_id">
                                        <option value="">- Select -</option>
                                        @foreach ($type as $type)
                                        <option value="{{$type->id}}">{{$type->brand->name}} - {{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button"
                                        onclick="changes('{{ csrf_token() }}', '{{ route('report-service.typeLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="technician3" role="tabpanel" aria-labelledby="technician-tab3">
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
                                    <label for="technician">{{ __('Teknisi') }}<code>*</code></label>
                                    <select class="select2 technician" id="technician_id" name="technician_id">
                                        <option value="">- Select -</option>
                                        @foreach ($technician as $technician)
                                        <option value="{{$technician->id}}">{{$technician->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}', '{{ route('report-service.technicianLoad') }}', '#data-load')">
                                        <i class="fas fa-eye"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="branch3" role="tabpanel" aria-labelledby="branch-tab3">
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
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}', '{{ route('report-service.branchLoad') }}', '#data-load')">
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
        {{-- <h2 class="section-title">Total Pendapatan</h2> --}}
          <div class="table-responsive" id="data-load">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="13%">Tanggal</th>
                        <th width="12%">Faktur</th>
                        <th width="25%">Customer</th>
                        <th width="20%">Barang</th>
                        <th width="18%">Status</th>
                        <th width="12%">Jumlah</th>
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
      var startDate1 = document.getElementById("startDate1").value;
      var startDate2 = document.getElementById("startDate2").value;
      var startDate3 = document.getElementById("startDate3").value;
      var startDate4 = document.getElementById("startDate4").value;
      var endDate1 = document.getElementById("endDate1").value;
      var endDate2 = document.getElementById("endDate2").value;
      var endDate3 = document.getElementById("endDate3").value;
      var endDate4 = document.getElementById("endDate4").value;
      var type_id = document.getElementById("type_id").value;
      var technician_id = document.getElementById("technician_id").value;
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
          type_id,
          technician_id,
          branch_id,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
  }
</script>
@endsection
