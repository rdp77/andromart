@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Stok Mutasi'))
@section('titleContent', __('Stok Mutasi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Stok Mutasi') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    {{-- <div class="card-header">
        <a href="{{ route('stockMutation.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Stock Transaksi') }}</a>


    </div> --}}
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>{{ __('Kode Invoice') }}</th>
                    <th>{{ __('Cabang') }}</th>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Tipe / Qty') }}</th>
                    <th>{{ __('Operator') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    {{-- <th>{{ __('Action') }}</th> --}}
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/warehouse/stockMutationScript.js') }}"></script>
@endsection
