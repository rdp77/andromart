@extends('layouts.backend.default')
@section('title', __('pages.title').__('Tambah Service'))
@section('titleContent', __('Tambah Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Service') }}</div>
@endsection

@section('content')
<form class="form-data">
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
                            <input id="code" type="text" class="form-control" readonly="" value="{{$service->code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control datepicker" readonly="" 
                            value="{{$service->date}}" name="date">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                            <select class="select2 validation" name="warranty" data-name="Teknisi">
                                <option value="">- Select -</option>
                                @foreach ($warranty as $element)
                                    <option @if ($service->warranty_id == $element->id) selected @endif value="{{$element->id}}">{{$element->periode}} {{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <div class="d-block">
                                <label for="technicianId"
                                    class="control-label">{{ __('Teknisi') }}<code>*</code></label>
                            </div>
                            <select class="select2 validation" name="technicianId" data-name="Teknisi">
                                <option value="">- Select -</option>
                                @foreach ($employee as $element)
                                <option @if ($service->technician_id == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="estimateDate">{{ __('Estimasi') }}<code>*</code></label>
                            <input id="estimateDate" type="text" value="{{$service->estimate_date}}" class="form-control datepicker" name="estimateDate">
                        </div>
                    </div>

                    <h6 style="color: #6777ef">Data Barang</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="type">{{ __('Kategori') }}<code>*</code></label>
                            <select class="select2 type" name="type" onchange="category()">
                                <option value="">- Select -</option>
                                @foreach ($category as $element)
                                    <option @if ($service->type == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                                {{-- <option value="Handphone">Handphone</option>
                                <option value="Laptop">Laptop</option> --}}
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="brand">{{ __('Merk') }}<code>*</code></label>
                            <select class="select2 brand" name="brand">
                                <option value="">- Select -</option>
                                @foreach ($brand as $element)
                                    @if ($element->category_id == $service->type)
                                    <option @if ($service->brand == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            {{-- <input id="brand" type="text" class="form-control" name="brand"> --}}
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="series">{{ __('Seri') }}<code>*</code></label>
                            <select class="select2 series" name="series">
                                <option value="">- Select -</option>
                                @foreach ($type as $element)
                                    @if ($element->brand_id == $service->brand)
                                        <option @if ($service->series == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            {{-- <input id="series" type="text" class="form-control" name="series"> --}}
                        </div>
                        <input type="hidden" class="brandHidden" value="{{$service->brand}}">
                        <input type="hidden" class="seriesHidden" value="{{$service->series}}">

                        @foreach ($brand as $el)
                            <input class="brandData" type="hidden"
                            data-category="{{$el->category_id}}"
                            data-name="{{$el->name}}"
                            value="{{$el->id}}">
                        @endforeach

                        @foreach ($type as $el)
                            <input class="seriesData" type="hidden"
                            data-brand="{{$el->brand_id}}"
                            data-name="{{$el->name}}"
                            value="{{$el->id}}">
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="complaint">{{ __('Keluhan') }}<code>*</code></label>
                            <input id="complaint" value="{{$service->complaint}}" type="text" class="form-control validation" data-name="Komplain" name="complaint">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="equipment">{{ __('Kelengkapan') }}<code>*</code></label>
                            <input id="equipment" value="{{$service->equipment}}" type="text" class="form-control validation" data-name="Kelengkapan" name="equipment">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="noImei">{{ __('No Imei') }}<code>*</code></label>
                            <input id="noImei" value="{{$service->no_imei}}" type="text" class="form-control" name="noImei">
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="description">{{ __('Keterangan') }}<code>*</code></label>
                            <input id="description" value="{{$service->description}}" type="text" class="form-control validation" data-name="Deskripsi" name="description">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Ambil Foto') }}<code>*</code></label>
                            <div id="my_camera"></div>
                            <br/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type=button class="btn btn-primary" value="Take Snapshot" 
                                    onClick="take_snapshot()">
                                    <input type="hidden" name="image" class="image-tag">
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Lihat Gambar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 style="color: #6777ef">Data Customer</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="customerName">{{ __('Nama') }}<code>*</code></label>
                            <input id="customerName" value="{{$service->customer_name}}" type="text" class="form-control validation" data-name="Nama Customer" name="customerName">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="series">{{ __('Member') }}<code>*</code></label>
                            <select class="select2" name="customerId">
                                <option value="">- Select -</option>
                                {{-- <option value="Deny">Deny</option>
                                <option value="Rizal">Rizal</option>
                                <option value="Alfian">Alfian</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="customerPhone">{{ __('No Tlp') }}<code>*</code></label>
                            <input id="customerPhone" value="{{$service->customer_phone}}" type="text" class="form-control validation" data-name="Tlp Customer" name="customerPhone">
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="customerAdress">{{ __('Alamat') }}<code>*</code></label>
                            <input id="customerAdress" value="{{$service->customer_address}}" type="text" class="form-control validation" data-name="alamat Customer" name="customerAdress">
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
                                <input type="radio" name="verificationPrice" value="Y" @if ($service->verification_price == 'Y') checked @endif onchange="sumTotal()"
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Ya</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="verificationPrice" value="N" @if ($service->verification_price == 'N') checked @endif onchange="sumTotal()" 
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Tidak</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalService">{{ __('Jasa') }}<code>*</code></label>
                        <input readonly id="totalService" onchange="sumTotal()" type="text" value="{{$service->total_service}}" class="form-control cleaveNumeral" name="totalService" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalSparePart">{{ __('Spare Part') }}<code>*</code></label>
                        <input readonly id="totalSparePart" onchange="sumTotal()" type="text" value="{{$service->total_part}}" class="form-control cleaveNumeral" name="totalSparePart" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalLoss">{{ __('Total Loss') }}<code>*</code></label>
                        <input readonly id="totalLoss" onchange="sumTotal()" type="text" value="{{$service->total_loss}}"
                            class="form-control cleaveNumeral" name="totalLoss" style="text-align: right">
                    </div>
                    <div class="form-group" style="display: none">
                        <label for="totalDownPayment">{{ __('Down Payment (DP)') }}<code>*</code></label>
                        <input id="totalDownPayment" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalDownPayment" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan Diskon Yang Dipakai</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="percent" @if ($service->discount_type == 'percent') checked @endif onchange="changeDiscount('percent'),sumTotal()" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Persentase (%)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="value" @if ($service->discount_type == 'value') checked @endif onchange="changeDiscount('value'),sumTotal()" 
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Harga (RP)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input id="totalDiscountPercent" 
                            @if ($service->discount_type == 'value') 
                                style="pointer-events:none"
                                style="background-color:#e9ecef"
                            @endif 
                            style="text-align: right"
                            type="text" value="{{$service->discount_percent}}" class="form-control cleaveNumeral"
                            name="totalDiscountPercent" onkeyup="sumTotal(),sumDiscont()">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                            <input id="totalDiscountValue" 
                            @if ($service->discount_type == 'percent')
                                style="pointer-events:none"
                                style="background-color:#e9ecef"
                            @endif 
                            style="text-align: right"
                            type="text" value="{{$service->discount_price}}" class="form-control cleaveNumeral"
                            name="totalDiscountValue" onkeyup="sumTotal(),sumDiscontValue()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                        <input id="totalPrice" type="text" value="{{$service->total_price}}" class="form-control cleaveNumeral"
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
                data-price="{{$el->sell}}"
                @foreach ($el->stock as $el1)
                    @if (Auth::user()->employee->branch_id == $el1->branch_id)
                        data-stock="{{$el1->stock}}"
                    @endif
                @endforeach
                data-name="{{$el->name}}"
                value="{{$el->id}}">
            @endforeach

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">Barang / Jasa</th>
                            <th>Harga</th>
                            <th style="width: 9%">Qty</th>
                            <th style="width: 9%">Stock</th>
                            <th>Total</th>
                            <th>Deskripsi</th>
                            <th style="width: 15%">tipe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display:none">
                                <input type="hidden" name="idDetailOld[]" value="{{$service->ServiceDetail[0]->id}}">
                                <input type="text" class="form-control priceDetailSparePart cleaveNumeral"
                                    name="priceDetailSparePartOld[]" value="0">
                                <input type="text" class="form-control priceDetailLoss cleaveNumeral"
                                    name="priceDetailLossOld[]" value="0">
                            </td>
                            <td>
                                <input readonly type="hidden" class="form-control " name="itemsDetailOld[]" value="1">
                                Jasa
                            </td>
                            <td>
                                <input type="text" class="form-control priceServiceDetail cleaveNumeral "
                                    name="priceDetailOld[]" style="text-align: right" value="{{$service->ServiceDetail[0]->price}}">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control" name="qtyDetailOld[]" value="1" style="text-align: right">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control" name="stockDetailOld[]" value="1" style="text-align: right">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control totalPriceServiceDetail cleaveNumeral"
                                    name="totalPriceDetailOld[]" style="text-align: right" value="{{$service->ServiceDetail[0]->total_price}}">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="descriptionDetailOld[]" value="{{$service->ServiceDetail[0]->description}}">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control" name="typeDetailOld[]" value="Jasa">
                            </td>
                            <td>
                                <button href="#" type="button" class="btn btn-default">X</button>
                            </td>
                        </tr>
                        @foreach ($service->ServiceDetail as $i => $el)
                            @if ($el->type != 'Jasa')
                            <tr class="dataDetail dataDetail_{{$i}}">
                                <td style="display:none" >
                                    <input type="hidden" name="idDetailOld[]" value="{{$el->id}}">
                                    <input type="text" class="form-control priceDetailSparePart priceDetailSparePart_{{$i}} cleaveNumeral"
                                        name="priceDetailSparePartOld[]" 
                                        @if ($el->type == 'SparePart')
                                            value="{{$el->total_price}}"
                                        @else
                                            value="0"
                                        @endif
                                    >
                                    <input type="text" class="form-control priceDetailLoss priceDetailLoss_{{$i}} cleaveNumeral"
                                        name="priceDetailLossOld[]" 
                                        @if ($el->type == 'Loss')
                                            value="{{$el->total_price}}"
                                        @else
                                            value="0"
                                        @endif
                                    >
                                </td>
                                <td>
                                    <select class="select2 itemsDetail" name="itemsDetailOld[]">
                                        <option value="-" data-index="">- Select -</option>
                                        @php
                                            $stock = 0;
                                        @endphp
                                        @foreach ($item as $el0)
                                            <option data-index="{{$i}}"  data-price="{{$el0->sell}}" 
                                            @foreach ($el0->stock as $el1)
                                                @if (
                                                Auth::user()->employee->branch_id == $el1->branch_id 
                                                && 
                                                $el0->id 
                                                == $el1->item_id)
                                                    {{$stock+=$el1->stock}}
                                                    data-stock="{{$el1->stock}}"
                                                @else
                                                    {{$stock=0}}
                                                    data-stock="0"s
                                                @endif
                                            @endforeach 
                                            @if ($el0->id == $el->item_id)
                                                selected
                                            @endif
                                            value="{{$el0->id}}">{{$el0->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control priceServiceDetail cleaveNumeral  priceDetail priceDetail_{{$i}}" name="priceDetailOld[]" style="text-align: right" value="{{$el->price}}">
                                </td>
                                <td>
                                    <input readonly type="text" class="form-control qtyDetail qtyDetail_{{$i}}" name="qtyDetailOld[]" value="{{$el->qty}}" style="text-align: right">
                                </td>
                                <td>
                                    <input readonly type="text" class="form-control stockDetail stock_{{$i}}" name="stockDetailOld[]" value="{{$stock}}" style="text-align: right">
                                </td>
                                <td>
                                    <input readonly type="text" class="form-control totalPriceDetail cleaveNumeral totalPriceDetail_{{$i}}" name="totalPriceDetailOld[]" style="text-align: right" value="{{$el->total_price}}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="descriptionDetailOld[]" value="{{$el->description}}">
                                </td>
                                <td>
                                    <select class="form-control typeDetail typeDetail_{{$i}}" name="typeDetailOld[]">
                                        <option @if ($el->type == 'SparePart') selected @endif data-index="{{$i}}" value="SparePart">SparePart</option>
                                        <option @if ($el->type == 'Loss') selected @endif data-index="{{$i}}" value="Loss">Loss</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger removeDataDetailExisting" data-id="{{$el->id}}" value="{{$i}}" >X</button>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dropDeletedExistingData">

        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="updateData({{$service->id}})"><i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
        </div>
    </div>
    <div class="modal fade" tabindex="1" role="dialog" id="exampleModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Gambar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="results"><img src="{{ asset('storage/'.$service->image) }}" alt=""></div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</form>

@endsection


@section('script')


<script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<style>
    .modal-backdrop{
        position: relative !important;
    }
</style>
<script language="JavaScript">
$( document ).ready(function() {
    Webcam.set({
        width: 700,
        height: 420,
        // dest_width:1000,
        // dest_height:1000,
        image_format: 'jpeg',
        jpeg_quality: 100
    });

    Webcam.attach( '#my_camera' );
});
    function take_snapshot() {
                swal('Berhasil Mengambil Foto', {
                    icon: "success",
                });
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);

            document.getElementById('results').innerHTML = '<img name="image" id="sortpicture" class="image" src="'+data_uri+'"/>';
        } );

    }
</script>
@endsection
