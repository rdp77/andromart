@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Penjualan'))
@section('titleContent', __('Edit Penjualan'))
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
<div class="breadcrumb-item active">{{ __('Edit Penjualan') }}</div>
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
                                <input id="code" type="text" class="form-control" readonly="" value="{{$sale->code}}"
                                    name="code">
                            </div>
                            <div class="form-group">
                                <label for="payment_method" class="control-label">
                                    {{ __('Metode Pembayaran') }}<code>*</code>
                                </label>
                                <select class="select2 PaymentMethod validation" data-name="Metode Pembayaran"
                                    name="PaymentMethod" onchange="paymentMethodChange()">
                                    <option value="">{{ __('- Select -') }}</option>
                                    <option value="Cash" @if($sale->payment_method == 'Cash') selected @endif>{{ __('Cash') }}</option>
                                    <option value="Debit" @if($sale->payment_method == 'Debit') selected @endif>{{ __('Debit') }}</option>
                                    <option value="Transfer" @if($sale->payment_method == 'Transfer') selected @endif>{{ __('Transfer') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sales" class="control-label">{{ __('Penjual') }}<code>*</code></label>
                                <select class="select2 validation" name="sales_id" data-name="Sales">
                                    @foreach ($sales as $sales)
                                    <option value="{{$sales->id}}" @if ($sales->id == $sale->sales_id)
                                        selected=""
                                        @endif>{{$sales->name}}</option>
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
                                id="description" style="height: 50px">{{ $sale->description }}</textarea>
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
                                <label for="customer_name">{{ __('Nama') }}</label>
                                <input id="customer_name" type="text" class="form-control validation" name="customer_name"
                                    data-name="Nama Customer" value="{{$sale->customer_name}}">
                            </div>
                            <div class="form-group">
                                <label for="customer_phone">{{ __('No. Telp.') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input id="customer_phone" type="text" class="form-control" name="customer_phone"
                                        value="{{$sale->customer_phone}}">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="customer_id">{{ __('Member') }}</label>
                                <select class="select2" name="customer_id">
                                    <option value=""> -Select- </option>
                                    @foreach ($customer as $customer)
                                    <option value="{{ $customer->id }}" @if ($sale->customer_id == $customer->id)
                                        selected
                                        @endif>{{ $customer->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="customer_address">{{ __('Alamat') }}</label>
                                <input id="customer_address" type="text" class="form-control validation" data-name="Alamat"
                                    name="customer_address" value="{{$sale->customer_address}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Harga</h4>
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
                            <input readonly id="totalSparePart" onchange="sumTotal()" type="text"
                                value="{{ $sale->item_price}}" class="form-control cleaveNumeral validation"
                                data-name="Barang" name="totalSparePart" style="text-align: right">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan Diskon Yang Dipakai</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="percent" @if ($sale->discount_type ==
                                'percent') checked @endif onchange="changeDiscount('percent'),sumTotal()" checked
                                class="selectgroup-input">
                                <span class="selectgroup-button">Persentase (%)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="value" @if ($sale->discount_type ==
                                'value') checked @endif onchange="changeDiscount('value'),sumTotal()"
                                class="selectgroup-input">
                                <span class="selectgroup-button">Harga (RP)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input id="totalDiscountPercent" @if ($sale->discount_type == 'value')
                            style="pointer-events:none"
                            style="background-color:#e9ecef"
                            @endif
                            type="text" value="{{$sale->discount_percent}}" class="form-control cleaveNumeral"
                            name="totalDiscountPercent"
                            onkeyup="sumTotal(),sumDiscont()" style="text-align: right">
                        </div>
                        <div class="col form-group">
                            <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                            <input id="totalDiscountValue" @if ($sale->discount_type == 'percent')
                            style="pointer-events:none"
                            style="background-color:#e9ecef"
                            @endif
                            type="text" value="{{$sale->discount_price}}" class="form-control cleaveNumeral"
                            name="totalDiscountValue"
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
                            <input id="totalPrice" type="text" value="{{$sale->total_price}}"
                                class="form-control cleaveNumeral" name="totalPrice" onchange="sumTotal()"
                                style="text-align: right">
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
            @foreach ($buyer as $el)
            <input class="buyerData" type="hidden" data-name="{{$el->name}}" value="{{$el->id}}">
            @endforeach
            @foreach ($stock as $el)
            <input class="itemsData" type="hidden" data-stock="{{$el->stock}}"
                data-price="{{$el->item->sell - $el->item->discount}}" data-profit="{{$el->item->buy}}"
                data-name="{{$el->item->name}}" data-supplier="{{$el->item->supplier->name}}" value="{{$el->item->id}}">
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
                    <tbody>
                        @foreach ($sale->SaleDetail as $i => $el)
                        @if ($el->type != 'Jasa')
                        <tr class="dataDetail dataDetail_{{$i}}">
                            <td style="display:none">
                                <input type="hidden" name="idDetailOld[]" value="{{$el->id}}">
                                <input type="text"
                                    class="form-control priceDetailSparePart priceDetailSparePart_{{$i}} cleaveNumeral"
                                    name="priceDetailSparePartOld[]" value="{{$el->total}}">
                                {{-- @if ($el->type == 'SparePart') --}}

                                {{-- @else --}}
                                {{-- value="0" --}}
                                {{-- @endifs --}}
                                <input type="text"
                                    class="form-control priceDetailLoss priceDetailLoss_{{$i}} cleaveNumeral"
                                    name="priceDetailLossOld[]" @if ($el->type == 'Loss')
                                value="{{$el->total_price}}"
                                @else
                                value="0"
                                @endif
                                >
                            </td>
                            <td>
                                <select class="select2 itemsDetail" name="itemsDetailOld[]">
                                    <option value="-" data-index="">{{ __('- Select -') }}</option>
                                    @foreach ($stock as $el0)
                                    <option data-index="{{$i}}" data-price="{{$el0->item->sell}}"
                                        data-stock="{{$el0->stock}}" data-supplier="{{$el0->item->supplier->name}}"
                                        data-profit="{{$el0->item->buy}}" @if ($el0->item->id == $el->item_id)
                                        selected
                                        @endif
                                        value="{{$el0->item->id}}">{{$el0->item->name}}</option>
                                    @endforeach
                                </select>
                                <input type="text" readonly class="form-control  supplier supplier_{{$i}}"
                                    name="supplierDetailOld[]" data-index="{{$i}}"" value="
                                    {{$el->item->supplier->name}}">
                            </td>
                            <td>
                                <input type="text" class="form-control qtyDetail qtyDetail_{{$i}}" name="qtyDetailOld[]"
                                    value="{{$el->qty}}" data-index="{{$i}}" style="text-align: right">
                                <input readonly type="text" class="form-control stockDetail stock_{{$i}}"
                                    data-index="{{$i}}" name="stockDetailOld[]" @foreach ($stock as $el0)
                                    value="{{$el0->stock}}" @endforeach style="text-align: right">
                            </td>
                            <td>
                                <input type="text" class="form-control cleaveNumeral  priceDetail priceDetail_{{$i}}"
                                    name="priceDetailOld[]" data-index="{{$i}}" style="text-align: right"
                                    value="{{$el->price}}">
                                <input readonly type="text"
                                    class="form-control totalPriceDetail cleaveNumeral totalPriceDetail_{{$i}}"
                                    name="totalPriceDetailOld[]" style="text-align: right" value="{{$el->total}}">
                            </td>
                            <td>
                                <select class="select2 buyerDetail" name="buyerDetailOld[]">
                                    <option value="" data-index="">{{ __('- Pengambil Barang -') }}</option>
                                    @foreach ($buyer as $els)
                                    <option value="{{$els->id}}" data-index="{{$i}}" @if ($els->id == $el->buyer_id)
                                        selected=""
                                        @endif>{{$els->name}}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control" name="salesDetail[]" value="Penjual" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="profitSharingBuyerOld[]"
                                    value="{{($el->sharing_profit_buyer/($el->sharing_profit_store+$el->sharing_profit_sales+$el->sharing_profit_buyer)*100)}}">
                                <input type="number" class="form-control" name="profitSharingSalesOld[]"
                                    value="{{($el->sharing_profit_sales/($el->sharing_profit_store+$el->sharing_profit_sales+$el->sharing_profit_buyer)*100)}}">
                            </td>
                            <td>
                                <input hidden type="text"
                                    class="form-control cleaveNumeral profitDetail profitDetail_{{$i}}"
                                    name="profitDetailOld[]" value="{{$el->item->buy}}" style="text-align: right">
                                <input type="text" class="form-control" name="descriptionDetailOld[]"
                                    value="{{$el->description}}">
                            </td>
                            <td style="display: none">
                                <select class="form-control typeDetail typeDetail_{{$i}}" name="typeDetailOld[]">
                                    <option @if ($el->type == 'SparePart') selected @endif data-index="{{$i}}"
                                        value="SparePart">{{ __('SparePart') }}</option>
                                    <option @if ($el->type == 'Loss') selected @endif data-index="{{$i}}"
                                        value="Loss">{{ __('Loss') }}</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger removeDataDetailExisting"
                                    data-id="{{$el->id}}" value="{{$i}}"><i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tbody>
                    </tbody>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dropDeletedExistingData">
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="updateData({{$sale->id}})"><i
                    class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/sale/sale.js') }}"></script>
@endsection
