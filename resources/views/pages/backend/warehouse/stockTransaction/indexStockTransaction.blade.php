@extends('layouts.backend.default')
@section('title', __('pages.title').__('Stock Transaksi'))
@section('titleContent', __('Stock Transaksi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Stock Transaksi') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('stockTransaction.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Stock Transaksi') }}</a>

        {{-- <a href="#" onclick="" class="btn btn-icon icon-left btn-danger"> --}}
                {{-- <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}</a> --}}
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Item</th>
                    <th>Satuan</th>
                    <th>Cabang</th>
                    <th>Qty</th>
                    <th>Tipe</th>
                    <th>Alasan</th>
                    <th>Tgl</th>
                    <th>Keterangan</th>
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
<script src="{{ asset('assets/pages/warehouse/stockTransactionScript.js') }}"></script>
@endsection