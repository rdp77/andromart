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
{{-- <h2 class="section-title" id="saleDate">{{ \Carbon\Carbon::now()->format('d F Y') }}</h2> --}}
{{-- <p class="section-lead">{{ __('Tanggal nota penjualan dikeluarkan.') }}</p> --}}
<form id="stored">
    {{-- <a data-target="#dataSave" data-toggle="modal" data-backdrop="static" data-keyboard="false">
        Launch demo modal
    </a> --}}
    <div class="row">
        <div class="col-md-7 col-sm-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label class="control-label">
                                {{ __('Kode Faktur')}}<code>*</code>
                            </label>
                            <input class="form-control" type="text" value="{{ $code }}" readonly="">
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label class="control-label">
                                {{ __('Faktur Penjualan')}}<code>*</code>
                            </label>
                            {{-- <select class="select2" name="item" id="item"> --}}
                            <select class="select2" name="saleId" id="saleId" onchange="saleId()">
                                <option value="">{{ __('- Select -') }}</option>
                                {{-- @foreach ($item as $i)
                                <option value="{{ $i->id.__(',').$i->Item->id }}">
                                    {{ $i->Item->name.__(' - ').$i->Sale->code }}
                                </option>
                                @endforeach --}}
                                @foreach ($sale as $i)
                                <option value="{{ $i->id }}">
                                    {{ $i->code }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8 col-xs-12" id="itemOld">
                            <label for="itemOld">{{ __('Barang') }}</label><code>*</code>
                            <select class="select2" name="itemOld" id="itemOld">
                                <option value="">{{ __('- Select -') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="">{{ __('Qty') }}</label><code>*</code>
                            <input class="form-control" type="text" value="1" readonly="">
                        </div>
                    </div>

                    {{-- @foreach ($item as $item)
                        <input type="hidden" class="itemData">
                    @endforeach --}}

                    <div class="row">
                        <div class="form-group col-md-8 col-xs-12">
                            <label for="description">{{ __('Keluhan') }}</label><code>*</code>
                            <input type="text" class="form-control" name="description" id="description">
                            {{-- <textarea data-name="Deskripsi" name="description" class="form-control" id="description"
                                style="height: 50px"></textarea> --}}
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="type">{{ __('Tindakan') }}</label><code>*</code>
                            <select name="type" id="type" class="select2">
                                <option value="">{{ __('- Select -') }}</option>
                                <option value="">{{ __('Ganti uang') }}</option>
                                <option value="">{{ __('Ganti barang serupa') }}</option>
                                <option value="">{{ __('Tukar tambah') }}</option>
                                <option value="">{{ __('Servis') }}</option>
                            </select>
                        </div>
                    </div>
                    <h6 style="color: #6777ef;">{{ __('Data Customer') }}</h6>
                    <div id="customerData"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail Harga') }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Harga Barang Lama') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="item_price_old" type="text" value="0" class="form-control" style="text-align: right" readonly>
                        </div>
                        {{-- <div class="input-group d-none" id="dv">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" id="discount_value" class="form-control" style="text-align: right"
                                readonly>
                        </div>
                        <div class="input-group d-none" id="dp">
                            <input type="text" id="discount_percent" class="form-control" style="text-align: right"
                                readonly>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('%') }}
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="form-group">
                        <label>{{ __('Harga Barang Baru') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="item_price" type="text" value="0" class="form-control" style="text-align: right" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Total Harga') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="total" type="text" value="0" class="form-control" style="text-align: right" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Data Return Detail') }}</h4>
            <div class="card-header-action">
                <button onclick="add()" type="button" class="btn btn-icon icon-left btn-warning">
                    <i class="fas fa-plus"></i>{{ __(' Tambah Data') }}
                </button>
            </div>
        </div>
        <div id="datas">

        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('Nama Barang') }}</th>
                            <th>{{ __('Perlakuan') }}</th>
                            <th>{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody id="itemData">
                    </tbody>
                </table>
            </div>
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
@include('pages.backend.transaction.sale.return.components.successModalReturn')
@endsection
@section('script')
<script>
    var getdata = '{{ route('sale.return.data') }}';
    var url = '{{ route('sale-return.store') }}';
    var index = '{{ route('sale-return.index') }}';
    var service = '{{ route('service.index') }}';
    var returnURL = '{{ route('sale.return.type') }}';
    var buy = '{{ route('purchase.create') }}';
    var addURL = '{{ route('sale.return.add') }}';
    var getDetailURL = '{{ route('sale.return.detail') }}';
</script>
<script src="{{ asset('assets/pages/transaction/sale/return/saleReturn.js') }}"></script>
@endsection
