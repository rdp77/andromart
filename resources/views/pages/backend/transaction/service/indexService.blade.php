@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Transaksi Service'))
@section('titleContent', __('Service'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('service.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Service') }}</a>&emsp;
        <a href="{{ route('service.onProgress') }}" class="btn btn-icon icon-left btn-warning">
            <i class="fas fa-clipboard-list"></i>{{ __(' On Progress') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>{{ __('Informasi') }}</th>
                    <th>{{ __('Pelanggan') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th width="25%">{{ __('Biaya / Harga') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal  fade exampleModal" tabindex="-1" role="dialog" id="exampleModal" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="dropHereJournals"> --}}
                    <h6>Jurnal HPP</h6>
                    <table class="table table-stripped table-bordered">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>D</th>
                            <th>K</th>
                        </tr>
                        <tbody class="dropHereJournals">

                        </tbody>
                    </table>
                {{-- </div> --}}
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
@endsection
