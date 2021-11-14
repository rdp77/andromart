@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Transaksi Penjualan'))
@section('titleContent', __('Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('sale.create') }}" class="btn btn-icon icon-left btn-primary mr-3">
            <i class="far fa-edit"></i>{{ __(' Tambah Penjualan') }}</a>
        <a href="#" onclick="" class="btn btn-icon icon-left btn-danger">
            <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>

                    <th>{{ __('Faktur') }}</th>
                    <th>
                        {{ __('Tanggal & operator') }}
                    </th>
                    <th>{{ __('Pelanggan') }}</th>
                    <th>{{ __('Qty | Barang | Garansi') }}</th>
                    <th>{{ __('Harga') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal  fade" tabindex="-1" role="dialog" id="exampleModal" data-backdrop="false">
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
<script src="{{ asset('assets/pages/transaction/sale/saleIndex.js') }}"></script>
@endsection
