@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Pembelian'))
@section('titleContent', __('Pembelian'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('purchase.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Pembelian') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Kode') }}</th>
                    <th>{{ __('Proses') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/purchaseScript.js') }}"></script>
@endsection
