@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Transaksi Service'))
@section('titleContent', __('Service'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('service.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Service') }}</a>&emsp;
        <a href="{{ route('service.onProgress') }}" class="btn btn-icon icon-left btn-warning">
            <i class="fas fa-clipboard-list"></i>{{ __(' On Progress') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>{{ __('Informasi') }}</th>
                    <th>{{ __('Pelanggan') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th width="25%">{{ __('Biaya / Harga') }}</th>
                    <th>{{ __('Status') }}</th>
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
