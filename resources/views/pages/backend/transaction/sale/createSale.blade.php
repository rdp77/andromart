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
                            <input id="code" type="text" class="form-control" readonly="" value="{{$code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                                name="date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-4 col-xs-12">
                            <div class="d-block">
                                <label for="sales" class="control-label">{{ __('Sales') }}<code>*</code></label>
                            </div>
                            <select class="select2 validation" name="sales_id" data-name="Sales">
                                <option value="">- Select -</option>
                                @foreach ($sales as $sales)
                                <option value="{{$sales->id}}">{{$sales->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-3 col-xs-12">
                            <label for="payment_method" class="control-label">{{ __('Metode Pembayaran')
                                }}<code>*</code></label>
                            <select class="select2 PaymentMethod validation" data-name="Metode Pembayaran Harus Di isi"
                                name="PaymentMethod" onchange="paymentMethodChange()">
                                <option value="">- Select -</option>
                                <option value="Cash">Cash</option>
                                <option value="Debit">Debit</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-5 col-xs-12">
                            <label for="account">{{ __('Akun') }}<code>*</code></label>
                            <select class="select2 account validation" data-name="Akun Harus Di isi" name="account">
                                <option value="">- Select -</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Deskripsi') }}<code>*</code></label>
                            <input id="description" type="text" class="form-control" name="description">
                        </div>
                    </div>
                    <input type="hidden" class="branchId" value="{{Auth::user()->employee->branch_id}}">
                    @foreach ($account as $el)
                    <input class="accountDataHidden" type="hidden" data-mainName="{{$el->AccountMain->name}}"
                        data-mainDetailName="{{$el->AccountMainDetail->name}}" data-branch="{{$el->branch_id}}"
                        data-name="{{$el->name}}" data-code="{{$el->code}}" value="{{$el->id}}">
                    @endforeach

                    <h6 style="color: #6777ef">Data Customer</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="customerName">{{ __('Nama') }}</label>
                            <input id="customerName" type="text" class="form-control" name="customer_name"
                                data-name="Nama Customer">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="customer_id">{{ __('Member') }}</label>
                            <select class="select2 customerId" name="customer_id" onchange="customerChange()">
                                <option value="">- Select -</option>
                                @foreach ($customer as $customer)
                                <option value="{{$customer->id}}" data-name="{{$customer->name}}"
                                    data-address="{{$customer->address}}" data-phone="{{$customer->contact}}">
                                    {{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="customerPhone">{{ __('No. Telp.') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                <input id="customerPhone" type="text" class="form-control" name="customer_phone"
                                    value="{{ old('customer_phone') }}">
                                @error('customer_telephone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="customerAdress">{{ __('Alamat') }}</label>
                            <input id="customerAdress" type="text" class="form-control" data-name="Alamat"
                                name="customer_address">
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
                            class="form-control cleaveNumeral validation" data-name="Barang" name="totalSparePart"
                            style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan Diskon Yang Dipakai</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="percent"
                                    onchange="changeDiscount('percent'),sumTotal()" checked class="selectgroup-input">
                                <span class="selectgroup-button">Persentase (%)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="value"
                                    onchange="changeDiscount('value'),sumTotal()" class="selectgroup-input">
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
                            <input id="totalDiscountValue" style="pointer-events: none;background-color:#e9ecef"
                                type="text" value="0" class="form-control cleaveNumeral" name="totalDiscountValue"
                                onkeyup="sumTotal(),sumDiscontValue()" style="text-align: right">
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
            @foreach ($buyer as $buyer)
            <input class="buyerData" type="hidden" data-name="{{$buyer->name}}" value="{{$buyer->id}}">
            @endforeach

            {{-- @foreach ($item as $el)
            <input class="itemsData" type="hidden" data-price="{{$el->sell - $el->discount}}" data-profit="{{$el->buy}}"
                @foreach ($el->stock as $el1)
            @if (Auth::user()->employee->branch_id == $el1->branch_id)
            data-stock="{{$el1->stock}}"
            @else
            data-stock="0"
            @endif
            @endforeach
            data-name="{{$el->name}}"
            data-supplier="{{$el->supplier->name}}"
            value="{{$el->id}}">
            @endforeach --}}
            @foreach ($stock as $el)
            <input class="itemsData" type="hidden" data-stock="{{$el->stock}}"
                data-price="{{$el->item->sell - $el->item->discount}}" data-profit="{{$el->item->buy}}"
                data-name="{{$el->item->name}}" data-supplier="{{$el->item->supplier->name}}" value="{{$el->item->id}}">
            @endforeach

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">Barang</th>
                            <th style="width: 9%">Qty | Stock</th>
                            <th style="width: 12%">Harga | Jumlah</th>
                            <th style="width: 20%">Operator</th>
                            <th style="width: 10%">Profit Sharing %</th>
                            <th>Deskripsi</th>
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
            <button class="btn btn-primary mr-1" type="button" onclick="save()"><i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="{{ asset('assets/pages/transaction/saleScript.js') }}"></script>
@endsection
