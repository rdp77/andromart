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
    <div class="card-header">
        <a href="{{ route('stockOpname.print') }}" class="btn btn-large btn-primary" target="_blank">
            <i class="fas fa-print"></i> Print Data
        </a>
    </div>
    <div class="card-body">
        @foreach($category as $key => $el)
        <h5>Kategori : {{$el->name}}</h5>
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
