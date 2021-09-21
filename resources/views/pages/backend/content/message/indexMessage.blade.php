@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Pesan'))
@section('titleContent', __('Pesan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pesan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <!-- <div class="card-header">
        <a href="{{ route('notes.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Pesan') }}</a>
    </div> -->
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Subjek') }}</th>
                    <th>{{ __('Isi') }}</th>
                    <!-- <th>{{ __('Aksi') }}</th> -->
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/content/messageScript.js') }}"></script>
<!-- <script src="{{ asset('assets/pages/transaction/receptionScript.js') }}"></script> -->
@endsection
