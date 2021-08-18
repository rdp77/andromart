@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Dana Kredit PDL'))
@section('titleContent', __('Dana Kredit PDL'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Dana Kredit PDL') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('creditFunds.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Dana Kredit PDL') }}</a>

        <a href="#" onclick="" class="btn btn-icon icon-left btn-danger">
                <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>
                        {{ __('Sales') }}
                    </th>
                    <th>{{ __('Tgl Cair') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Diterima') }}</th>
                    {{-- <th>{{ __('Nama') }}</th> --}}
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/creditFunds.js') }}"></script>
@endsection