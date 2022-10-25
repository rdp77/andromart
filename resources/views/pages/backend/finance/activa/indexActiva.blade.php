@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Aktiva / Penyusutan'))
@section('titleContent', __('Aktiva / Penyusutan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Aktiva / Penyusutan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('activa.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Aktiva') }}</a>
        
        <a href="{{ route('activa.depreciation') }}" class="btn btn-icon icon-left btn-success ml-3">
            <i class="fas fa-angle-double-down"></i>{{ __(' Lakukan Penyusutan') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>
                        {{ __('Kode') }}
                    </th>
                    <th>
                        {{ __('Nama/Barang') }}
                    </th>
                    <th>
                        {{ __('Cabang') }}
                    </th>
                    <th>
                        {{ __('Bulan Selesai') }}
                    </th>
                    <th>
                        {{ __('Akun') }}
                    </th>
                    {{-- <th>
                        {{ __('Nilai Penyusutan') }}
                    </th> --}}
                    <th>
                        {{ __('Golongan') }}
                    </th>
                    <th>
                        {{ __('Jenis Asset') }}
                    </th>
                    <th>
                        {{ __('Nilai') }}
                    </th>
                    <th>
                        {{ __('Deskripsi') }}
                    </th>
                    <th>
                        {{ __('Status') }}
                    </th>
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
<script src="{{ asset('assets/pages/master/activaScript.js') }}"></script>
@endsection
