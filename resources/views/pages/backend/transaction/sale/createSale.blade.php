@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Penjualan'))
@section('titleContent', __('Tambah Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('sale.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Penjualan') }}</div>
@endsection

@section('content')
<form method="POST" class="form-data">
    @csrf
    <div class="row">
        <div class="col-md-7 col-sm-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                                <input id="code" type="text" class="form-control" value="{{$code}}" name="code"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="payment_method" class="control-label">
                                    {{ __('Metode Pembayaran') }}<code>*</code>
                                </label>
                                <select class="select2 PaymentMethod validation" data-name="Metode Pembayaran"
                                    name="PaymentMethod" onchange="paymentMethodChange()">
                                    <option value="">{{ __('- Select -') }}</option>
                                    <option value="Cash">{{ __('Cash') }}</option>
                                    <option value="Debit">{{ __('Debit') }}</option>
                                    <option value="Transfer">{{ __('Transfer') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sales" class="control-label">{{ __('Penjual') }}<code>*</code></label>
                                <select class="select2 validation" name="sales_id" data-name="Sales">
                                    <option value="">{{ __('- Select -') }}</option>
                                    @foreach ($sales as $sales)
                                    <option value="{{$sales->id}}">{{$sales->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="account">{{ __('Akun Kas') }}<code>*</code></label>
                                <select class="select2 account validation" data-name="Akun Kas" name="account"
                                    id="account">
                                    <option value="">{{ __('- Select -') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Deskripsi') }}<code>*</code></label>
                            <textarea data-name="Deskripsi" name="description" class="form-control validation"
                                id="description" style="height: 100px"></textarea>
                        </div>
                    </div>
                    <input type="hidden" class="branchId" value="{{Auth::user()->employee->branch_id}}">
                    @foreach ($account as $el)
                    <input class="accountDataHidden" type="hidden" data-mainName="{{$el->AccountMain->name}}"
                        data-mainDetailName="{{$el->AccountMainDetail->name}}" data-branch="{{$el->branch_id}}"
                        data-name="{{$el->name}}" data-code="{{$el->code}}" value="{{$el->id}}">
                    @endforeach
                    <h2 class="section-title">{{ __('Data Customer') }}</h2>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="customerName">{{ __('Nama') }}</label>
                                <input id="customerName" type="text" class="form-control" name="customer_name"
                                    data-name="Nama Customer">
                            </div>
                            <div class="form-group">
                                <label for="customerPhone">{{ __('No. Telp.') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input id="customerPhone" type="text" class="form-control" name="customer_phone"
                                        value="{{ old('customer_phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="customer_id">{{ __('Member') }}</label>
                                <select class="select2 customerId" name="customer_id" onchange="customerChange()">
                                    <option value="">{{ __('- Select -') }}</option>
                                    @foreach ($customer as $customer)
                                    <option value="{{$customer->id}}" data-name="{{$customer->name}}"
                                        data-address="{{$customer->address}}" data-phone="{{$customer->contact}}">
                                        {{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="customerAdress">{{ __('Alamat') }}</label>
                                <input id="customerAdress" type="text" class="form-control" data-name="Alamat"
                                    name="customer_address">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Harga') }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="totalSparePart">{{ __('Barang') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input readonly id="totalSparePart" onchange="sumTotal()" type="text" value="0"
                                class="form-control cleaveNumeral validation" data-name="Barang" name="totalSparePart"
                                style="text-align: right">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('Satuan Diskon Yang Dipakai') }}</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="percent"
                                    onchange="changeDiscount('percent'),sumTotal()" checked class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('Persentase (%)') }}</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="value"
                                    onchange="changeDiscount('value'),sumTotal()" class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('Harga (Rp)') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input id="totalDiscountPercent" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDiscountPercent" onkeyup="sumTotal(),sumDiscont()" style="text-align: right">
                        </div>
                        <div class="col form-group">
                            <label for="totalDiscountValue">{{ __('Diskon Rp') }}<code>*</code></label>
                            <input id="totalDiscountValue" style="pointer-events: none;background-color:#e9ecef"
                                type="text" value="0" class="form-control cleaveNumeral" name="totalDiscountValue"
                                onkeyup="sumTotal(),sumDiscontValue()" style="text-align: right">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="totalPrice" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalPrice" onchange="sumTotal()" style="text-align: right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Data Detail') }}</h4>
            <div class="card-header-action">
                <button onclick="addItem()" type="button" class="btn btn-icon icon-left btn-warning">
                    <i class="fas fa-plus"></i>{{ __(' Tambah Data') }}
                </button>
            </div>
        </div>
        <div class="card-body">
            @foreach ($buyer as $buyer)
            <input class="buyerData" type="hidden" data-name="{{$buyer->name}}" value="{{$buyer->id}}">
            @endforeach
            @foreach ($stock as $el)
            <input class="itemsData" type="hidden" data-stock="{{$el->stock}}"
                data-supplier="{{$el->item->supplier->name}}" data-price="{{$el->item->sell - $el->item->discount}}"
                data-profit="{{$el->item->buy}}" data-name="{{$el->item->name}}" value="{{$el->item->id}}">
            @endforeach
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">{{ __('Barang') }}</th>
                            <th style="width: 9%">{{ __('Qty | Stock') }}</th>
                            <th style="width: 12%">{{ __('Harga | Jumlah') }}</th>
                            <th style="width: 20%">{{ __('Operator') }}</th>
                            <th style="width: 10%">{{ __('Profit Sharing %') }}</th>
                            <th>{{ __('Deskripsi') }}</th>
                            {{-- <th style="width: 15%" hidden>tipe</th> --}}
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="save()">
                <i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    var getPayment = '{{ route('sale.getPaymentMethod') }}';
</script>
<script src="{{ asset('assets/pages/transaction/sale/sale.js') }}"></script>
@endsection