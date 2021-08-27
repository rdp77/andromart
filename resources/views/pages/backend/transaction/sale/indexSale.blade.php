@extends('layouts.backend.default')
@section('title', __('pages.title').__('Transaksi Penjualan'))
@section('titleContent', __('Penjualan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('service.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Service') }}</a>

        <a href="#" onclick="" class="btn btn-icon icon-left btn-danger">
                <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>

                    <th>{{ __('Faktur') }}</th>
                    <th>
                        {{ __('Tanggal & operator') }}
                    </th>
                    <th>{{ __('Pelanggan') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Biaya / Harga') }}</th>
                    <th>{{ __('Status') }}</th>
                    {{-- <th>{{ __('Jasa') }}</th>
                    <th>{{ __('SparePart') }}</th>
                    <th>{{ __('Loss') }}</th>
                    <th>{{ __('Diskon') }}</th>
                    <th>{{ __('Jumlah') }}</th> --}}
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
@endsection
