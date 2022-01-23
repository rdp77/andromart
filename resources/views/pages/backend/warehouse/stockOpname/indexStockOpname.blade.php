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
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
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
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/warehouse/stockOpnameScript.js') }}"></script>
@endsection
