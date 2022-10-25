@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Golongan Aktiva'))
@section('titleContent', __('Master Golongan Aktiva'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Golongan Aktiva') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('activa-group.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Golongan Aktiva') }}</a>
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
                        {{ __('Estimasi Umur') }}
                    </th>
                    <th>
                        {{ __('Persentase') }}
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
<script src="{{ asset('assets/pages/master/activaGroupScript.js') }}"></script>
@endsection
