@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Gudang'))
@section('titleContent', __('Stok Opname'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Stok Opname') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="#" class="btn btn-large btn-primary">
            <i class="fas fa-print"></i> Print Data
        </a>
    </div>
    <div class="card-body">
        {{-- <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">{{ __('NO') }}</th>
                    <th class="text-center">{{ __('Barang') }}</th>
                    <th class="text-center">{{ __('Stok') }}</th>
                    <th class="text-center">{{ __('Satuan') }}</th>
                    <th class="text-center">{{ __('Harga Beli') }}</th>
                    <th class="text-center">{{ __('Saldo') }}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr style="color: #6777ef;">
                    <th colspan="2"><h5>Total Barang : {{ $sumItem }}</h5></th>
                    <th colspan="2"><h5>Total Saldo : Rp. {{ number_format($sumActiva, 0, ".", ",") }}</h5></th>
                </tr>
            </tfoot>
        </table> --}}

        <table class="table table-striped table-bordered" width="100%">
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
            @foreach($item as $key => $value)
            <tbody style="border: none !important">
                <tr>
                    <th scope="row" class="text-right">{{ $loop->iteration }}</th>
                    <td>{{$value->item->brand->name}} {{$value->item->name}}</td>
                    <td class="text-center">{{$value->stock}}</td>
                    <td class="text-center">{{$value->unit->code}}</td>
                    <td class="text-right">Rp. {{ number_format($value->item->buy, 0, ".", ",") }}</td>
                    <?php
                        $sumBuy = $value->stock*$value->item->buy;
                    ?>
                    <td class="text-right">Rp. {{ number_format($sumBuy, 0, ".", ",") }}</td>
                </tr>
            </tbody>
            @endforeach
            <tfoot>
                <tr style="color: #6777ef;">
                    <th colspan="3"><h5>Total Barang : {{ $sumItem }}</h5></th>
                    <th colspan="3"><h5>Total Saldo : Rp. {{ number_format($sumActiva, 0, ".", ",") }}</h5></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
@section('script')
{{-- <script src="{{ asset('assets/pages/warehouse/stockOpnameScript.js') }}"></script> --}}
@endsection
