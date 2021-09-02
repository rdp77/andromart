@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Gudang'))
@section('titleContent', __('Stok'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Stok') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    {{-- <div class="card-header">
        <a href="#" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Stok') }}</a>
    </div> --}}
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Kondisi') }}</th>
                    <th>{{ __('Cabang') }}</th>
                    <th>{{ __('Stok') }}</th>
                    <th>{{ __('Stok Min.') }}</th>
                    <th>{{ __('Satuan') }}</th>
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
<script src="{{ asset('assets/pages/warehouse/stockScript.js') }}"></script>
@endsection
