@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Gudang'))
@section('titleContent', __('Stok Opname'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Stok Opname') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-body">
        <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active" id="category3" role="tabpanel" aria-labelledby="category-tab3">
                <div class="row">
                    <div class="form-group col-6 col-md-6 col-lg-6">
                        <label>{{ __('Kategori') }}<code>*</code></label>
                        <select name="category" id="category" class="select2 form-control">
                            <option value="0">Semua</option>
                            @foreach ($category as $el)
                                <option value="{{ $el->id }}">{{ $el->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-6 col-md-6 col-lg-6">
                        <label>{{ __('Nama Barang') }}<code>*</code></label>
                        <input type="text" class="form-control" name="nameItems" id="nameItems">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3 col-md-3">
                        <button class="btn btn-primary" type="button" onclick="changes('{{ csrf_token() }}','{{ route('stockOpname.dataLoad') }}', '#data-load')">
                            <i class="fas fa-eye"></i> Cari</button>
                    </div>
                    <div class="form-group col-3 col-md-3">
                        <button class="btn btn-primary" type="button" onclick="printStockOpname()">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header" style="background-color: #ffffdc; color:black">
        @php
            $totalActiva = 0;
            $totalServiceNyantol = 0;
        @endphp
        @foreach ($activa as $activa)
            @php
                $totalActiva += $activa->stock*$activa->hargabeli;
            @endphp
        @endforeach
        @foreach ($service as $service)
            @php
                $totalServiceNyantol += $service->ServiceDetailTotal;
            @endphp
        @endforeach
        

        <h3>Aktifa Lancar : Rp. {{ number_format($totalActiva, 0, ".", ",") }}  | Barang Terpakai Service Rp.  {{ number_format($totalServiceNyantol, 0, ".", ",") }} <br><br>  Total Activa Lancar Rp.  {{ number_format($totalActiva+$totalServiceNyantol, 0, ".", ",") }}</h3>
    </div>
    <div class="card-body" id="data-load">
        @foreach($stockCategory as $key => $el)
        <h5>Kategori : {{$el->name}}</h5><br>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th class="text-center" width="6%" >{{ __('NO') }}</th>
                    <th class="text-center" width="34%">{{ __('Barang') }}</th>
                    <th class="text-center" width="5%">{{ __('Stok') }}</th>
                    <th class="text-center" width="5%">{{ __('Satuan') }}</th>
                    <th class="text-center" width="25%">{{ __('Harga Beli') }}</th>
                    <th class="text-center" width="25%">{{ __('Saldo') }}</th>
                </tr>
            </thead>
            @php
                $no=1;
                $sumActiva = 0;
                $sumItem = 0;
            @endphp
            @foreach ($item as $key1 => $el1)
            @if ($el1->category == $el->code)
            @php
                $sumBuy = $el1->stock*$el1->hargabeli;
                $sumActiva += $el1->stock*$el1->hargabeli;
                $sumItem += $el1->stock;
            @endphp
            <tbody style="border: none !important">
                <tr>
                    <th scope="row" class="text-right">{{ $no++ }}</th>
                    <td>{{ $el1->merk }} {{ $el1->itemName }}</td>
                    <td>{{ $el1->stock }}</td>
                    <td>{{ $el1->satuan }}</td>
                    <td class="text-right">Rp. {{ number_format($el1->hargabeli, 0, ".", ",") }}</td>
                    <td class="text-right">Rp. {{ number_format($sumBuy, 0, ".", ",") }}</td>
                </tr>
            </tbody>
            @endif
            @endforeach
            <tfoot>
                <tr style="color: #6777ef;">
                    <th colspan="3" class="text-right"><h4>Total Barang : {{ $sumItem }} </h4></th>
                    <th colspan="3" class="text-right"><h4>Total Saldo : Rp. {{ number_format($sumActiva, 0, ".", ",") }}</h4></th>
                </tr>
            </tfoot>
        </table>
        <br>
        @endforeach
    </div>
</div>
@endsection
<script type="text/javascript">
    var loading = `-- Sedang Memuat Data --`;
    function changes(token, url, target) {
      var category = document.getElementById("category").value;
      var nameItems = document.getElementById("nameItems").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          category,
          nameItems
      },
      function (data) {
        //   console.log(data);
          $(target).html(data);
      });
    }
    function printStockOpname() {
        var category = document.getElementById("category").value;
        var nameItems = document.getElementById("nameItems").value;
        console.log(nameItems);
        window.location.href = '{{ route('stockOpname.print') }}?&category=' + category+'&nameItems='+nameItems
    }
</script>