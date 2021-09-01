@extends('layouts.backend.default')
@section('title', __('pages.title').__('Pelunasan Service'))
@section('titleContent', __('Pelunasan Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pelunasan Service') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('service-payment.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Pelunasan Service') }}</a>

        <a href="#" onclick="" class="btn btn-icon icon-left btn-danger">
                <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Submited</th>
                    <th>Informasi Service</th>
                    <th>Tgl Trans</th>
                    <th>Tipe Byr</th>
                    <th>Keterangan</th>
                    <th>Total</th>
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
<script src="{{ asset('assets/pages/transaction/servicePaymentScript.js') }}"></script>
@endsection