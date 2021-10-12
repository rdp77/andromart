@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Akun Dasar'))
@section('titleContent', __('Master Akun Dasar'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Akun Dasar') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('account-main.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Akun Dasar') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center" width="8%">
                        {{ __('NO') }}
                    </th>
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
<script src="{{ asset('assets/pages/master/accountMainScript.js') }}"></script>
@endsection
