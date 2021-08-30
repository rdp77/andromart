@extends('layouts.backend.default')
@section('title', __('pages.title').__('Tambah Penjualan'))
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
        <div class="col-md-6">
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
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <div class="d-block">
                                <label for="sales"
                                    class="control-label">{{ __('Sales') }}<code>*</code></label>
                            </div>
                            <select class="select2" name="sales">
                                <option value="">- Select -</option>
                                @foreach ($employee as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                            <select class="select2" name="warranty_id">
                                <option value="">- Select -</option>
                                <option value="1">1 Minggu</option>
                                <option value="2">2 Minggu</option>
                                <option value="3">1 Bulan</option>
                                <option value="4">3 Bulan</option>
                            </select>
                        </div>
                    </div>

                    <h6 style="color: #6777ef">Data Customer</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="customer_name">{{ __('Nama') }}<code>*</code></label>
                            <input id="customer_name" type="text" class="form-control" name="customer_name">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="series">{{ __('Member') }}<code>*</code></label>
                            <select class="select2" name="customer_id">
                                <option value="">- Select -</option>
                                <option value="1">Deny</option>
                                <option value="2">Rizal</option>
                                <option value="3">Alfian</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="customer_phone">{{ __('No Tlp') }}<code>*</code></label>
                            <input id="customer_phone" type="text" class="form-control" name="customer_phone">
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="customer_address">{{ __('Alamat') }}<code>*</code></label>
                            <input id="customer_address" type="text" class="form-control" name="customer_address">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Harga</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="totalService">{{ __('Jasa') }}<code>*</code></label>
                        <input readonly id="totalService" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalService" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalSparePart">{{ __('Spare Part') }}<code>*</code></label>
                        <input readonly id="totalSparePart" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalSparePart" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalLoss">{{ __('Total Loss') }}<code>*</code></label>
                        <input readonly id="totalLoss" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalLoss" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalDownPayment">{{ __('Down Payment (DP)') }}<code>*</code></label>
                        <input id="totalDownPayment" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalDownPayment" onkeyup="sumTotal()" style="text-align: right">
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input id="totalDiscountPercent" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDiscountPercent" onkeyup="sumTotal(),sumDiscont()" style="text-align: right">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                            <input id="totalDiscountValue" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDiscountValue" onkeyup="sumTotal(),sumDiscont()" style="text-align: right">
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
            <input class="itemsData" type="hidden" data-price="{{$el->sell}}" data-name="{{$el->name}}"
                value="{{$el->id}}">
            @endforeach

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">Barang / Jasa</th>
                            <th>Harga</th>
                            <th style="width: 9%">qty</th>
                            <th>Total</th>
                            <th>Deskripsi</th>
                            <th style="width: 15%">tipe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display:none">
                                <input type="text" class="form-control priceDetailSparePart cleaveNumeral"
                                    name="priceDetailSparePart[]" value="0">
                                <input type="text" class="form-control priceDetailLoss cleaveNumeral"
                                    name="priceDetailLoss[]" value="0">
                            </td>
                            <td>
                                <input readonly type="hidden" class="form-control " name="itemsDetail[]" value="1">
                                Jasa
                            </td>
                            <td>
                                <input type="text" class="form-control priceServiceDetail cleaveNumeral"
                                    name="priceDetail[]" style="text-align: right" value="0">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control" name="qtyDetail[]" value="1" style="text-align: right">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control totalPriceServiceDetail cleaveNumeral"
                                    name="totalPriceDetail[]" style="text-align: right" value="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="descriptionDetail[]">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control" name="typeDetail[]" value="Jasa">
                            </td>
                            <td><button href="#" type="button" class="btn btn-default">X</button></td>
                        </tr>
                    </tbody>
                    <tbody class="dropHereItem" style="border: none !important">
                        {{-- <tr>
                    <td>LCD 15 inch</td>
                    <td>700.000</td>
                    <td>1</td>
                    <td>700.000</td>
                    <td>LCD baru ini boss</td>
                    <td>Spare Part</td>
                    <td><a href="#" class="btn btn-danger">X</a></td>
                  </tr>
                  <tr>
                    <td>LCD 15 inch</td>
                    <td>700.000</td>
                    <td>1</td>
                    <td>700.000</td>
                    <td>Ga sengojo keplindes</td>
                    <td>Loss</td>
                    <td><a href="#" class="btn btn-danger">X</a></td>
                  </tr> --}}
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
