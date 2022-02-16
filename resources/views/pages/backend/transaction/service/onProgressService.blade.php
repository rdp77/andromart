@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Service On Progress'))
@section('titleContent', __('Service On Progress'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service On Progress') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<form class="form-data">
    @csrf
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="form-group col-6 col-md-6 col-lg-6">
                    <label for="technician">{{ __('Teknisi') }}<code>*</code></label>
                    <select class="select2 technician" id="technician_id" name="technician_id">
                        <option value="x"> Semua</option>
                        @foreach ($technician as $technician)
                        <option value="{{$technician->id}}">{{$technician->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-6 col-md-3">
                    <br><button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}', '{{ route('service.onProgressLoad') }}', '#data-load')">
                        <i class="fas fa-eye"></i> Cari
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="data-load">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('Faktur') }}</th>
                                <th class="text-center">{{ __('Pelanggan') }}</th>
                                <th class="text-center">{{ __('Barang') }}</th>
                                <th class="text-center" width="25%">{{ __('Keluhan') }}</th>
                                <th class="text-center">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        @foreach ($service as $service)
                        <tbody class="dropHere" style="border: none !important">
                            <td>
                                <table>
                                    <tr>
                                        <td>Kode</td>
                                        <th>{{ $service->code }}</th>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <th>{{ \Carbon\Carbon::parse($service->date)->locale('id')->isoFormat('LL') }}</th>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td>Operator</td>
                                        <th>{{ $service->created_by }}</th>
                                    </tr>
                                    <tr>
                                        <td>Teknisi 1</td>
                                        <th>{{ $service->Employee1->name }}</th>
                                    </tr>
                                    @if ($service->technician_replacement_id != null)
                                    <tr>
                                        <td>Teknisi 2</td>
                                        <th>{{ $service->Employee2->name }}</th>
                                    </tr>
                                    @endif
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <th>{{ $service->customer_name }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{ $service->customer_phone }}</th>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>Kategori</td>
                                        <th>{{ $service->Brand->Category->name }}</th>
                                        <td>Merk</td>
                                        <th>{{ $service->Brand->name }}</th>
                                    </tr>
                                    <tr>
                                        <td>Seri</td>
                                        <th>{{ $service->Type->name }}</th>
                                        <td>IMEI</td>
                                        <th>{{ $service->no_imei }}</th>
                                    </tr>
                                </table>
                            </td>
                            <th>
                                {{ $service->complaint }}
                            </th>
                            <td class="text-left">
                                @if ($service->work_status == 'Manifest')
                                    <div class="badge badge-primary">Manifest</div><br><br>
                                @elseif ($service->work_status == 'Proses')
                                    <div class="badge badge-warning">Proses</div><br><br>
                                @endif
                                @if ($service->payment_status == 'Lunas')
                                    <div class="badge badge-success">Lunas</div>
                                @elseif ($service->payment_status == 'Bayar DP')
                                    <div class="badge badge-warning">Bayar DP</div>
                                @elseif ($service->payment_status == null)
                                    <div class="badge badge-danger">Belum Bayar</div>
                                @endif
                            </td>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
@section('script')
<script type="text/javascript">
  var loading = `-- sedang memuat data --`;
  function changes(token, url, target) {
      var technician_id = document.getElementById("technician_id").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          technician_id,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
  }
</script>
@endsection
