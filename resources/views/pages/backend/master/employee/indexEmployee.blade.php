@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Karyawan'))
@section('titleContent', __('Karyawan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Karyawan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('employee.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Pengguna') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    {{-- <th class="text-center">
                        {{ __('NO') }}
                    </th> --}}
                    <th>{{ __('NIK') }}</th>
                    <th>
                        {{ __('Nama') }}
                    </th>
                    <th>{{ __('Cabang') }}</th>
                    <th>{{ __('Kontak') }}</th>
                    <th>{{ __('Alamat') }}</th>
                    <th>{{ __('Bagian') }}</th>
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
<script src="{{ asset('assets/pages/master/employeeScript.js') }}"></script>
@endsection
