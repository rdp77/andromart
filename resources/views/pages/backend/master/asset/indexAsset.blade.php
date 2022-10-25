@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Asset'))
@section('titleContent', __('Master Asset'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Asset') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('asset.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Asset') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>
                        {{ __('Nama') }}
                    </th>
                    <th>
                        {{ __('Akun Beban Penyusutan') }}
                    </th>
                    <th>
                        {{ __('Akun Akumulasi Penyusutan') }}
                    </th>
                    <th>
                        {{ __('Deksripsi') }}
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
<script src="{{ asset('assets/pages/master/assetScript.js') }}"></script>
@endsection
