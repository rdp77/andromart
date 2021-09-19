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
                            <input id="code" type="text" class="form-control" readonly="" value="{{$code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                                name="date">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                            <select class="select2 validation" name="warranty" data-name="Teknisi">
                                <option value="">- Select -</option>
                                @foreach ($warranty as $element)
                                    <option value="{{$element->id}}">{{$element->periode}} {{$element->name}}</option>
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
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="estimateDate">{{ __('Estimasi') }}<code>*</code></label>
                            <input id="estimateDate" type="text" class="form-control datepicker" name="estimateDate">
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
                                    <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                                {{-- <option value="Handphone">Handphone</option>
                                <option value="Laptop">Laptop</option> --}}
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="brand">{{ __('Merk') }}<code>*</code></label>
                            <select class="select2 brand" name="brand">
                                <option value="">- Select -</option>
                                {{-- @foreach ($brand as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach --}}
                            </select>
                            {{-- <input id="brand" type="text" class="form-control" name="brand"> --}}
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="series">{{ __('Seri') }}<code>*</code></label>
                            <select class="select2 series" name="series">
                                <option value="">- Select -</option>
                                {{-- @foreach ($type as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach --}}
                            </select>
                            {{-- <input id="series" type="text" class="form-control" name="series"> --}}
                        </div>
                        
                        @foreach ($brand as $el)
                            <input class="brandData" type="hidden"
                            data-category="{{$el->category_id}}"
                            data-name="{{$el->name}}"
                            value="{{$el->id}}">
                        @endforeach

                        @foreach ($type as $el)
                            <input class="seriesData" type="hidden"
                            data-name="{{$el->name}}"
                            value="{{$el->id}}">
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="complaint">{{ __('Keluhan') }}<code>*</code></label>
                            <input id="complaint" type="text" class="form-control validation" data-name="Komplain" name="complaint">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="equipment">{{ __('Kelengkapan') }}<code>*</code></label>
                            <input id="equipment" type="text" class="form-control validation" data-name="Kelengkapan" name="equipment">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-5 col-lg-5">
                            <label for="noImei">{{ __('No Imei') }}<code>*</code></label>
                            <input id="noImei" type="text" class="form-control" name="noImei">
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="description">{{ __('Keterangan') }}<code>*</code></label>
                            <input id="description" type="text" class="form-control validation" data-name="Deskripsi" name="description">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Ambil Foto') }}<code>*</code></label>
                            <div id="my_camera"></div>
                            <br/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type=button class="btn btn-primary" value="Take Snapshot" onClick="take_snapshot()">
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
                            <input id="customerName" type="text" class="form-control validation" data-name="Nama Customer" name="customerName">
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
                            <input id="customerPhone" type="text" class="form-control validation" data-name="Tlp Customer" name="customerPhone">
                        </div>
                        <div class="form-group col-12 col-md-7 col-lg-7">
                            <label for="customerAdress">{{ __('Alamat') }}<code>*</code></label>
                            <input id="customerAdress" type="text" class="form-control validation" data-name="alamat Customer" name="customerAdress">
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
                    <div class="form-group" style="display: none">
                        <label for="totalDownPayment">{{ __('Down Payment (DP)') }}<code>*</code></label>
                        <input id="totalDownPayment" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalDownPayment" style="text-align: right">
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
                data-price="{{$el->sell}}"
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
                                <input readonly type="text" class="form-control" name="stockDetail[]" value="1" style="text-align: right">
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
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="save()"><i class="far fa-save"></i>
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
              {{-- <p>Modal body text goes here.</p> --}}
            <div id="results"></div>
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
