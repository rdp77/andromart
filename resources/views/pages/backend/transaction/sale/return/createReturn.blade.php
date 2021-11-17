@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Return Penjualan'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('sale-return.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('titleContent', __('Tambah Return Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Return Penjualan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Return Penjualan') }}</div>
@endsection

@section('content')
<h2 class="section-title" id="saleDate">{{ \Carbon\Carbon::now()->format('d F Y') }}</h2>
<p class="section-lead">{{ __('Tanggal nota penjualan dikeluarkan.') }}</p>
<form id="stored">
    <div class="row">
        <div class="col-md-7 col-sm-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">
                            {{ __('Kode Faktur') }}
                        </label>
                        <input type="text" class="form-control" id="faktur" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            {{ __('Nama Barang')}}<code>*</code>
                        </label>
                        <select class="select2" name="item" id="item">
                            <option value="">{{ __('- Select -') }}</option>
                            @foreach ($item as $i)
                            <option value="{{ $i->id.__(',').$i->Item->id }}">
                                {{ $i->Item->name.__(' - ').$i->Sale->code }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('Pengambil Barang') }}
                                </label>
                                <input type="text" class="form-control" id="taker" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('Penjual') }}
                                </label>
                                <input type="text" class="form-control" id="seller" readonly>
                            </div>
                        </div>
                    </div>
                    <h2 class="section-title">{{ __('Data Customer') }}</h2>
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail') }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Diskon') }}</label>
                        <div class="input-group d-none">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" id="discount_value" value="0" class="form-control"
                                style="text-align: right" readonly>
                        </div>
                        <div class="input-group d-none">
                            <input type="text" id="discount_percent" class="form-control" value="0"
                                style="text-align: right" readonly>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('%') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Harga Barang') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" class="form-control" value="0" id="price" style="text-align: right"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Total Harga Barang') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="total" type="text" value="0" class="form-control" style="text-align: right"
                                readonly>
                        </div>
                    </div>
                    <h2 class="section-title">{{ __('Sharing Profit') }}</h2>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>{{ __('Pengambil') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="0" id="sp_taker"
                                        style="text-align: right" readonly>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            {{ __('%') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>{{ __('Penjual') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="0" id="sp_seller"
                                        style="text-align: right" readonly>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            {{ __('%') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Data Return') }}</h4>
            <div class="card-header-action">
                <button onclick="addItem()" type="button" class="btn btn-icon icon-left btn-warning">
                    <i class="fas fa-plus"></i>{{ __(' Tambah Data') }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="button" onclick="save()">
                    <i class="far fa-save"></i>
                    {{ __('Simpan Data') }}</button>
            </div>
        </div>
</form>
@endsection
@section('modal')
@include('pages.backend.transaction.sale.return.components.modalReturn')
@endsection
@section('script')
<script>
    var getdata = '{{ route('sale.return.data') }}';
    var url = '{{ route('sale-return.store') }}';
    var index = '{{ route('sale-return.index') }}';
    var service = '{{ route('service.index') }}';
    var returnURL = '{{ route('sale.return.type') }}';
    var buy = '{{ route('purchase.create') }}';
</script>
<script src="{{ asset('assets/pages/transaction/sale/return/saleReturn.js') }}"></script>
@endsection