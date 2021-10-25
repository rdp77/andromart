@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Akun Data'))
@section('titleContent', __('Master Akun Data'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Akun Data') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('account-data.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Akun Data') }}</a>
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
                        {{ __('Nama') }}
                    </th>
                    <th>
                        {{ __('Debet Kredit') }}
                    </th>
                    <th>
                        {{ __('Active') }}
                    </th>
                    <th>
                        {{ __('Saldo Opening') }}
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
<script src="{{ asset('assets/pages/master/accountDataScript.js') }}"></script>
@endsection
