@extends('layouts.backend.default')
@section('title', __('pages.title').__('Tambah Service'))
@section('titleContent', __('Tambah Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Service') }}</div>
@endsection

@section('content')
<form method="POST" class="form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Data</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                            <input id="code" type="text" class="form-control" readonly="" value="{{$code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                                name="date">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                            <select class="select2" name="warranty">
                                <option value="">- Select -</option>
                                <option value="1">1 Minggu</option>
                                <option value="2">1 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="4">2 Minggu</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12 col-md-4 col-lg-4">
                                <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                                <input id="code" type="text" class="form-control" readonly="" value="{{$code}}"
                                    name="code">
                            </div>
                            <div class="form-group col-12 col-md-4 col-lg-4">
                                <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                                <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                                    name="date">
                            </div>
                            <div class="form-group col-12 col-md-4 col-lg-4">
                                <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                                <select class="select2" name="warranty">
                                    <option value="">- Select -</option>
                                    <option value="1">1 Minggu</option>
                                    <option value="2">1 Bulan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <div class="d-block">
                                    <label for="technicianId"
                                        class="control-label">{{ __('Teknisi') }}<code>*</code></label>
                                </div>
                                <select class="select2" name="technicianId">
                                    <option value="">- Select -</option>
                                    @foreach ($employee as $element)
                                    <option value="{{$element->id}}">{{$element->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="estimateDate">{{ __('Estimasi') }}<code>*</code></label>
                                <input id="estimateDate" type="text" class="form-control datepickerFormatDFY"
                                    name="estimateDate">
                            </div>
                        </div>

                        <h6 style="color: #6777ef">Data Barang</h6>
                        <br>
                        <div class="row">
                            <div class="form-group col-12 col-md-4 col-lg-4">
                                <label for="brand">{{ __('Merk') }}<code>*</code></label>
                                <input id="brand" type="text" class="form-control" name="brand">
                            </div>
                            <div class="form-group col-12 col-md-4 col-lg-4">
                                <label for="series">{{ __('Seri') }}<code>*</code></label>
                                <input id="series" type="text" class="form-control" name="series">
                            </div>
                            <div class="form-group col-12 col-md-4 col-lg-4">
                                <label for="type">{{ __('tipe') }}<code>*</code></label>
                                <select class="select2" name="type">
                                    <option value="">- Select -</option>
                                    <option value="Handphone">Handphone</option>
                                    <option value="Laptop">Laptop</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="complaint">{{ __('Keluhan') }}<code>*</code></label>
                                <input id="complaint" type="text" class="form-control" name="complaint">
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="equipment">{{ __('Kelengkapan') }}<code>*</code></label>
                                <input id="equipment" type="text" class="form-control" name="equipment">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="noImei">{{ __('No Imei') }}<code>*</code></label>
                            <input id="noImei" type="text" class="form-control" name="noImei">
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="description">{{ __('Keterangan') }}<code>*</code></label>
                            <input id="description" type="text" class="form-control" name="description">
                        </div>

                        <h6 style="color: #6777ef">Data Customer</h6>
                        <br>
                        <div class="row">
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="customerName">{{ __('Nama') }}<code>*</code></label>
                                <input id="customerName" type="text" class="form-control" name="customerName">
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="series">{{ __('Member') }}<code>*</code></label>
                                <select class="select2" name="customerId">
                                    <option value="">- Select -</option>
                                    <option value="Deny">Deny</option>
                                    <option value="Rizal">Rizal</option>
                                    <option value="Alfian">Alfian</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-5 col-lg-5">
                                <label for="customerPhone">{{ __('No Tlp') }}<code>*</code></label>
                                <input id="customerPhone" type="text" class="form-control" name="customerPhone">
                            </div>
                            <div class="form-group col-12 col-md-7 col-lg-7">
                                <label for="customerAdress">{{ __('Alamat') }}<code>*</code></label>
                                <input id="customerAdress" type="text" class="form-control" name="customerAdress">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Harga</h4>

                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Harga Perlu Dikonfirmasi Terlebih Dahulu</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="verificationPrice" value="Y" onchange="sumTotal()"
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">Ya</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="verificationPrice" value="N" onchange="sumTotal()" checked
                                        class="selectgroup-input">
                                    <span class="selectgroup-button">Tidak</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="totalService">{{ __('Jasa') }}<code>*</code></label>
                            <input readonly id="totalService" onchange="sumTotal()" type="text" value="0"
                                class="form-control" name="totalService">
                        </div>
                        <div class="form-group">
                            <label for="totalSparePart">{{ __('Spare Part') }}<code>*</code></label>
                            <input readonly id="totalSparePart" onchange="sumTotal()" type="text" value="0"
                                class="form-control" name="totalSparePart">
                        </div>
                        <div class="form-group">
                            <label for="totalLoss">{{ __('Total Loss') }}<code>*</code></label>
                            <input readonly id="totalLoss" onchange="sumTotal()" type="text" value="0"
                                class="form-control" name="totalLoss">
                        </div>
                        <div class="form-group">
                            <label for="totalDownPayment">{{ __('Down Payment (DP)') }}<code>*</code></label>
                            <input id="totalDownPayment" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDownPayment" onkeyup="sumTotal()">
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                                <input id="totalDiscountPercent" type="text" value="0" class="form-control"
                                    name="totalDiscountPercent" onkeyup="sumTotal(),sumDiscont()">
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                                <input id="totalDiscountValue" type="text" value="0" class="form-control"
                                    name="totalDiscountValue" onkeyup="sumTotal(),sumDiscont()">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                            <input id="totalPrice" type="text" value="0" class="form-control" name="totalPrice"
                                onchange="sumTotal()">
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
                    @foreach ($items as $el)
                    <input class="itemsData" type="hidden" data-price="{{$el->sell}}" data-name="{{$el->name}}"
                        value="{{$el->id}}">
                    @endforeach

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Barang / Jasa</th>
                                    <th>Harga</th>
                                    <th style="width: 10%">qty</th>
                                    <th>Total</th>
                                    <th>Deskripsi</th>
                                    <th>tipe</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="display:none">
                                        <input type="text" class="form-control priceDetailSparePart"
                                            name="priceDetailSparePart[]" value="0">
                                        <input type="text" class="form-control priceDetailLoss" name="priceDetailLoss[]"
                                            value="0">
                                    </td>
                                    <td>
                                        <input readonly type="hidden" class="form-control " name="itemsDetail[]"
                                            value="1">
                                        Jasa
                                    </td>
                                    <td>
                                        <input type="text" class="form-control priceServiceDetail" name="priceDetail[]">
                                    </td>
                                    <td>
                                        <input readonly type="text" class="form-control" name="qtyDetail[]" value="1">
                                    </td>
                                    <td>
                                        <input readonly type="text" class="form-control totalPriceServiceDetail"
                                            name="totalPriceDetail[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="descriptionDetail[]">
                                    </td>
                                    <td>
                                        <input readonly type="text" class="form-control" name="typeDetail[]"
                                            value="Jasa">
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
<script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
@endsection