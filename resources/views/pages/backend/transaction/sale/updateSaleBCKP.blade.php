@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Penjualan'))
@section('titleContent', __('Tambah Penjualan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Penjualan') }}</div>
@endsection

@section('content')
<form method="POST" class="form-data">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4>Form Data</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                            <input id="code" type="text" class="form-control" readonly="" value="{{$sale->code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control" readonly="" value="{{ \Carbon\Carbon::parse($sale->date)->locale('id')->isoFormat('LL') }}"
                                name="date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <div class="d-block">
                                <label for="sales"
                                    class="control-label">{{ __('Sales') }}<code>*</code></label>
                            </div>
                            <select class="select2 validation" name="sales_id" data-name="Sales">
                                <option value="{{$sale->sales->id}}">{{$sale->sales->name}}</option>
                                @foreach ($sales as $sales)
                                <option value="{{$sales->id}}">{{$sales->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                            <select class="select2 validation" name="warranty" data-name="Masa Garansi">
                                <option value="{{$sale->warranty->id}}">{{$sale->warranty->periode}} {{$sale->warranty->name}}</option>
                                @foreach ($warranty as $warranty)
                                <option value="{{ $warranty->id }}">{{ $warranty->periode }} {{ $warranty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h6 style="color: #6777ef">Data Customer</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="customer_name">{{ __('Nama') }}<code>*</code></label>
                            <input id="customer_name" type="text" class="form-control validation" name="customer_name"
                            data-name="Nama Customer" value="{{$sale->customer_name}}">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="series">{{ __('Member') }}<code>*</code></label>
                            <select class="select2" name="customer_id">
                                <option value="{{ $sale->customer->id }}">{{ $sale->customer->name }}</option>
                                @foreach ($customer as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="customer_phone">{{ __('No. Telp.') }}<code>*</code></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </div>
                                </div>
                                <input id="customer_phone" type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                    name="customer_phone" value="{{$sale->customer_phone}}">
                                @error('customer_telephone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="customer_address">{{ __('Alamat') }}<code>*</code></label>
                            <input id="customer_address" type="text" class="form-control validation" data-name="Alamat"
                            name="customer_address" value="{{$sale->customer_address}}">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Harga</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="totalSparePart">{{ __('Barang') }}<code>*</code></label>
                        <input readonly id="totalSparePart" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalSparePart" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan Diskon Yang Dipakai</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="percent" onchange="changeDiscount('percent'),sumTotal()" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Persentase (%)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="value" onchange="changeDiscount('value'),sumTotal()"
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Harga (RP)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input id="totalDiscountPercent" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDiscountPercent" onkeyup="sumTotal(),sumDiscont()" style="text-align: right">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                            <input id="totalDiscountValue" style="pointer-events: none;background-color:#e9ecef" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDiscountValue" onkeyup="sumTotal(),sumDiscontValue()" style="text-align: right">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                        <input id="totalPrice" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalPrice" onchange="sumTotal()" style="text-align: right">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Data Detail</h4>
            <div class="card-header-action">
                <button onclick="addItem()" type="button" class="btn btn-warning">Tambah data <i
                        class="fas fa-add"></i></button>
            </div>
        </div>
        <div class="card-body">

            @foreach ($item as $el)
                <input class="itemsData" type="hidden"
                data-price="{{$el->sell - $el->discount}}"
                @foreach ($el->stock as $el1)
                    @if (Auth::user()->employee->branch_id == $el1->branch_id)
                        data-stock="{{$el1->stock}}"
                    @else
                        data-stock="0"
                    @endif
                @endforeach
                data-name="{{$el->name}}"
                value="{{$el->id}}">
            @endforeach

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">Barang</th>
                            <th>Harga</th>
                            <th style="width: 9%">Qty</th>
                            <th style="width: 9%">Stok</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th style="width: 10%" hidden>P.S. Sales %</th>
                            <th style="width: 15%" hidden>tipe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="dropHereItem" style="border: none !important">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="updateData({{$sale->id}})"><i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="{{ asset('assets/pages/transaction/saleScript.js') }}"></script>
@endsection
