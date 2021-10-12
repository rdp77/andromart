@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Akun Detail'))
@section('titleContent', __('Master Akun Detail'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Akun Detail') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('account-main-detail.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Akun Detail') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center" width="8%">
                        {{ __('NO') }}
                    </th>
                    <th> {{ __('Akun Dasar') }} </th>
                    <th width="15%"> {{ __('Kode') }} </th>
                    <th> {{ __('Nama') }} </th>
                    <th> {{ __('Aksi') }} </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/master/accountMainDetailScript.js') }}"></script>
@endsection
