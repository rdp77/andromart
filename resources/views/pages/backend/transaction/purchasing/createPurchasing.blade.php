@extends('layouts.backend.default')
@section('title', __('pages.title').__('Tambah Purchasing'))
@section('titleContent', __('Tambah Purchasing'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Purchasing') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Purchasing') }}</div>
@endsection

@section('content')
<form method="POST" class="form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi</h4>
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
                            <label for="discount">{{ __('Diskon') }}<code>*</code></label>
                            <input id="discount" type="text" class="form-control" name="discount">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <div class="d-block">
                                <label for="technicianId"
                                    class="control-label">{{ __('Supplier') }}<code>*</code></label>
                            </div>
                            <select class="select2" name="technicianId">
                                <option value="">- Select -</option>
                                @foreach ($employee as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="status">{{ __('Status') }}<code>*</code></label>
                            <input id="status" type="text" class="form-control" name="status">
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
                    <!-- <div class="form-group">
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
                    </div> -->
                    <div class="form-group">
                        <label for="totalPurchasing">{{ __('Harga Total') }}<code>*</code></label>
                        <input readonly id="totalPurchasing" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalPurchasing" style="text-align: right">
                    </div>
                    <!-- <div class="form-group">
                        <label for="totalSparePart">{{ __('Diskon') }}<code>*</code></label>
                        <input readonly id="totalSparePart" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalSparePart" style="text-align: right">
                    </div> -->
                    <div class="form-group">
                        <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                        <input id="totalDiscountPercent" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalDiscountPercent" onkeyup="sumTotal(),sumDiscont()" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalLoss">{{ __('Grand Total') }}<code>*</code></label>
                        <input readonly id="totalLoss" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalLoss" style="text-align: right">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Item</h4>
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
                                <input type="text" class="form-control pricePurchasingDetail cleaveNumeral"
                                    name="priceDetail[]" style="text-align: right" value="0">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control" name="qtyDetail[]" value="1" style="text-align: right">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control totalPricePurchasingDetail cleaveNumeral"
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
<script src="{{ asset('assets/pages/transaction/PurchasingScript.js') }}"></script>
@endsection