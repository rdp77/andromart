@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Pengeluaran'))
@section('titleContent', __('Pengeluaran'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pengeluaran') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('payment.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Pengeluaran') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th style = "width: 10%">
                        {{ __('Kode') }}
                    </th>
                    <th style = "width: 12%">{{ __('Tanggal') }}</th>
                    <th>{{ __('Biaya') }}</th>
                    <th>{{ __('Cabang') }}</th>
                    <th>{{ __('Kass') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Keterangan') }}</th>
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
<script src="{{ asset('assets/pages/transaction/paymentScript.js') }}"></script>
@endsection
