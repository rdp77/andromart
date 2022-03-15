@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Detail Penjualan'))
@section('titleContent', __('Detail Penjualan'))
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
<div class="breadcrumb-item active">{{ __('Detail Penjualan') }}</div>
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
                                <label for="code">{{ __('Kode Faktur') }}</label>
                                <input id="code" type="text" class="form-control" readonly="" value="{{$sale->code}}"
                                    name="code">
                            </div>
                            <div class="form-group">
                                <label for="payment_method">{{ __('Metode Pembayaran') }}</label>
                                <input class="form-control" readonly="" value="{{$sale->payment_method}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sales" class="control-label">{{ __('Penjual') }}</label>
                                <input class="form-control" readonly="" value="{{$sale->sales->name}}">
                            </div>
                            <div class="form-group">
                                <label for="account">{{ __('Akun Kas') }}</label>
                                <input class="form-control" readonly="" value="{{$sale->accountData->code}} - {{$sale->accountData->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Deskripsi') }}</label>
                            <textarea data-name="Deskripsi" name="description" readonly="" class="form-control validation"
                                id="description" style="height: 50px">{{ $sale->description }}</textarea>
                        </div>
                    </div>
                    <h2 class="section-title">{{ __('Data Customer') }}</h2>
                    <div class="row">
                            <div class="form-group col-md-6 col-xs-6">
                                <label for="customer_name">{{ __('Nama') }}</label>
                                <input id="customer_name" type="text" class="form-control validation" readonly="" name="customer_name" value="{{$sale->customer_name}}">
                            </div>
                            <div class="form-group col-md-6 col-xs-6">
                                <label for="customer_phone">{{ __('No. Telp.') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input id="customer_phone" type="text" class="form-control" readonly="" name="customer_phone" value="{{$sale->customer_phone}}">
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="customer_address">{{ __('Alamat') }}</label>
                                <input id="customer_address" type="text" class="form-control" readonly="" name="customer_address" value="{{$sale->customer_address}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12">
            <div class="card card-primary">
                <div class="card-body">
                    <h2 class="section-title">{{ __('Harga') }}</h2>
                    <div class="form-group">
                        <label for="totalSparePart">{{ __('Barang') }}</label>
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
                                <input type="radio" name="typeDiscount" disabled value="percent" @if ($sale->discount_type ==
                                'percent') checked @endif onchange="changeDiscount('percent'),sumTotal()" checked
                                class="selectgroup-input">
                                <span class="selectgroup-button">Persentase (%)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" disabled value="value" @if ($sale->discount_type ==
                                'value') checked @endif onchange="changeDiscount('value'),sumTotal()"
                                class="selectgroup-input">
                                <span class="selectgroup-button">Harga (RP)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}</label>
                            <input id="totalDiscountPercent" @if ($sale->discount_type == 'value')
                            style="pointer-events:none"
                            style="background-color:#e9ecef"
                            @endif
                            type="text" value="{{$sale->discount_percent}}" class="form-control cleaveNumeral"
                            name="totalDiscountPercent"
                            onkeyup="sumTotal(),sumDiscont()" style="text-align: right" readonly="">
                        </div>
                        <div class="col form-group">
                            <label for="totalDiscountValue">{{ __('Diskon') }}</label>
                            <input id="totalDiscountValue" @if ($sale->discount_type == 'percent')
                            style="pointer-events:none"
                            style="background-color:#e9ecef"
                            @endif
                            type="text" value="{{$sale->discount_price}}" class="form-control cleaveNumeral"
                            name="totalDiscountValue"
                            onkeyup="sumTotal(),sumDiscontValue()" style="text-align: right" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total Harga') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="totalPrice" type="text" value="{{$sale->total_price}}"
                                class="form-control cleaveNumeral" name="totalPrice" onchange="sumTotal()"
                                style="text-align: right" readonly="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h2 class="section-title">{{ __('Detail Barang') }}</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 25%">{{ __('Barang') }}</th>
                            <th class="text-center" style="width: 13%">{{ __('Qty * Harga') }}</th>
                            <th class="text-center" style="width: 11%">{{ __('Jumlah') }}</th>
                            <th class="text-center" style="width: 18%">{{ __('Pengambil') }}</th>
                            <th class="text-center" style="width: 11%">{{ __('P.S Pengambil') }}</th>
                            <th class="text-center" style="width: 11%">{{ __('P.S Penjual') }}</th>
                            <th class="text-center">{{ __('Deskripsi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->SaleDetail as $i => $sd)
                        <tr>
                            <td>
                                <input type="text" class="form-control" value="{{ $sd->item->brand->name }} {{$sd->item->name}}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-right" value="{{$sd->qty}} * {{ number_format($sd->price,0,".",",") }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-right" value="{{ number_format($sd->total,0,".",",") }}" readonly>
                            </td>
                            <td>
                                <input type="text" @if ($sd->buyer_id != null && $sd->sharing_profit_buyer > 0)
                                    class="form-control"  value="{{ $sd->buyer->name }}"
                                    @else class="form-control text-center"  value=" - "
                                @endif readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-right" @if ($sd->buyer_id != null && $sd->sharing_profit_buyer > 0)
                                    value="{{ number_format($sd->sharing_profit_buyer,0,".",",") }}"
                                    @else value=" 0 "
                                @endif readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-right" @if ($sd->sharing_profit_sales > 0)
                                value="{{ number_format($sd->sharing_profit_sales,0,".",",") }}"
                                @else value=" 0 "
                            @endif readonly>
                            </td>
                            <td>
                                {{ $sd->description }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@endsection
