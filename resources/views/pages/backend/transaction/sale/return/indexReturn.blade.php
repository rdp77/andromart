@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Return Penjualan'))
@section('titleContent', __('Return Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Return Penjualan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('sale-return.create') }}" class="btn btn-icon icon-left btn-primary mr-2">
            <i class="far fa-edit"></i>{{ __(' Tambah Return Penjualan') }}</a>
        <a href="#" onclick="" class="btn btn-icon icon-left btn-danger">
            <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>
                        {{ __('No Faktur') }}
                    </th>
                    <th>
                        {{ __('Nama Barang') }}
                    </th>
                    <th>
                        {{ __('Tipe') }}
                    </th>
                    <th>{{ __('Keterangan') }}</th>
                    {{-- <th>{{ __('Aksi') }}</th> --}}
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    var index = '{{ route('sale-return.index') }}';    
</script>
<script src="{{ asset('assets/pages/transaction/saleReturnIndex.js') }}"></script>
@endsection