@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Service'))
@section('titleContent', __('Tambah Service'))
@section('breadcrumb', __('Transaksi'))
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
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                            <input id="code" type="text" class="form-control" readonly="" value="{{$code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control datepicker" readonly="" name="date">
                        </div>
                     
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
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
              
                    </div>
                  
                    {{-- <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Estimasi Analisa') }}<code>*</code></label>
                            <input type="text" class="form-control" data-name="Deskripsi">
                        </div>
                    </div> --}}

                    <h6 style="color: #6777ef">Data Barang</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="type">{{ __('Kategori') }}<code>*</code></label>
                            <select class="select2 type validation" data-name="Kategori" name="type" onchange="category()">
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
                            <select class="brand form-control validation" data-name="Merk" id="brandService" name="brand">
                                <option value="">- Select -</option>
                                {{-- @foreach ($brand as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach --}}
                            </select>
                            {{-- <input id="brand" type="text" class="form-control" name="brand"> --}}
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="series">{{ __('Tipe') }}<code>*</code></label>
                            <select class="series form-control validation" data-name="Tipe" id="seriesService" name="series">
                                <option value="">- Select -</option>
                                {{-- @foreach ($type as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach --}}
                            </select>
                            {{-- <input id="series" type="text" class="form-control" name="series"> --}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="items">{{ __('Barang') }}<code>*</code></label>
                            <select class="items form-control validation" data-name="Tipe" id="itemsService" name="items">
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
                            data-brand="{{$el->brand_id}}"
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
                            <input id="complaint" type="text" class="form-control validation" data-name="Komplain" name="complaint">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="noImei">{{ __('No Imei') }}<code>*</code></label>
                            <input id="noImei" type="text" class="form-control" name="noImei">
                        </div>
                        {{-- <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="equipment">{{ __('Kelengkapan') }}<code>*</code></label>
                            <input id="equipment" type="text" class="form-control validation" data-name="Kelengkapan" name="equipment">
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Kesepakatan Bersama') }}<code>*</code></label>
                            <input id="description" type="text" class="form-control validation" data-name="Deskripsi" name="description">
                        </div>
                    </div>

                    <h6 style="color: #6777ef">Data Pembeli</h6>
                    <br>
                    <div class="row">
                      
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="series">{{ __('Crew') }}<code>*</code></label>
                            <select class="select2 customerId" name="customerId" onchange="customerChange()">
                                <option value="">- Select -</option>
                                @foreach ($employee as $element)
                                <option value="{{$element->id}}"
                                    >{{$element->name}}</option>
                                @endforeach
                                {{-- <option value="Deny">Deny</option>
                                <option value="Rizal">Rizal</option>
                                <option value="Alfian">Alfian</option> --}}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Ambil Foto</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
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
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Kelengkapan Unit</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="chargerEquipment" class="chargerEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Charger</span>
                            </label>
                            <div class="chargerEquipmentDescUsed" style="display: none"><hr>
                                <input id="chargerEquipmentDesc" type="text" class="form-control" name="chargerEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="bateraiEquipment" class="bateraiEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Baterai</span>
                            </label>
                            <div class="bateraiEquipmentDescUsed" style="display: none"><hr>
                                <input id="bateraiEquipmentDesc" type="text" class="form-control" name="bateraiEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="hardiskSsdEquipment" class="hardiskSsdEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Hardisk / SSD</span>
                            </label>
                            <div class="hardiskSsdEquipmentDescUsed" style="display: none"><hr>
                                <input id="hardiskSsdEquipmentDesc" type="text" class="form-control" name="hardiskSsdEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="RamEquipment" class="RamEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">RAM</span>
                            </label>
                            <div class="RamEquipmentDescUsed" style="display: none"><hr>
                                <input id="RamEquipmentDesc" type="text" class="form-control" name="RamEquipmentDesc">
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="kabelEquipment" class="kabelEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Kabel</span>
                            </label>
                            <div class="kabelEquipmentDescUsed" style="display: none"><hr>
                                <input id="kabelEquipmentDesc" type="text" class="form-control" name="kabelEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="tasLaptopEquipment" class="tasLaptopEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Tas Laptop</span>
                            </label>
                            <div class="tasLaptopEquipmentDescUsed" style="display: none"><hr>
                                <input id="tasLaptopEquipmentDesc" type="text" class="form-control" name="tasLaptopEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="aksesorisEquipment" class="aksesorisEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Aksesoris</span>
                            </label>
                            <div class="aksesorisEquipmentDescUsed" style="display: none"><hr>
                                <input id="aksesorisEquipmentDesc" type="text" class="form-control" name="aksesorisEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="lainnyaEquipment" class="lainnyaEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Lainnya</span>
                            </label>
                            <div class="lainnyaEquipmentDescUsed" style="display: none"><hr>
                                <input id="lainnyaEquipmentDesc" type="text" class="form-control" name="lainnyaEquipmentDesc">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Sharing Profit</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="presentaseTechnician1">{{ __('Presentase Teknisi 1') }}<code>*</code></label>
                            <input id="presentaseTechnician1" type="text" value="0" class="form-control cleaveNumeral"
                                name="presentaseTechnician1" style="text-align: right">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <lab,el for="presentaseTechnician2">{{ __('Presentase Teknisi 2') }}<code>*</code></label>
                            <input id="presentaseTechnician2" type="text" value="0" class="form-control cleaveNumeral"
                            name="presentaseTechnician2" style="text-align: right">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <lab,el for="presentaseStore">{{ __('Presentase Toko') }}<code>*</code></label>
                            <input id="presentaseStore" type="text" value="0" class="form-control cleaveNumeral"
                            name="presentaseStore" style="text-align: right">
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
                        <label for="totalPriceBuy">{{ __('Harga Beli') }}<code>*</code></label>
                        <input readonly id="totalPriceBuy" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral" name="totalPriceBuy" style="text-align: right">
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
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total HPP') }}<code>*</code></label>
                        <input id="totalHppAtas" type="text" readonly value="0" class="form-control cleaveNumeral"
                            name="totalHppAtas" style="text-align: right">
                    </div>
                    <div class="form-group" style="display: none">
                        <label for="totalDownPayment">{{ __('Down Payment (DP)') }}<code>*</code></label>
                        <input id="totalDownPayment" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalDownPayment" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                        <input id="totalPrice" type="text" value="0" class="form-control cleaveNumeral"
                            name="totalPrice" onchange="sumTotal()" style="text-align: right">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Kondisi Serah Terima Unit</h4>

                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">LCD</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="LcdCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="LcdCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="LcdCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Touch Screen</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="touchScreenCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="touchScreenCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="touchScreenCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">WIFI</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="wifiCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="wifiCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="wifiCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Charging</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="chargingCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="chargingCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="chargingCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Camera Depan</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="cameraDepanCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="cameraDepanCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="cameraDepanCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Camera Belakang</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="cameraBelakangCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="cameraBelakangCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="cameraBelakangCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vibrator</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="vibratorCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="vibratorCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="vibratorCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Speaker</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="speakerCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="speakerCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="speakerCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mic</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="micCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="micCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="micCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Touchpad</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="touchpadCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="touchpadCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="touchpadCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keyboard</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="keyboardCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="keyboardCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="keyboardCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tombol Tombol</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="tombolCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="tombolCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="tombolCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sinyal</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="sinyalCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="sinyalCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="sinyalCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Usb</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="usbCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="usbCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="usbCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Soket Audio</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="soketAudioCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="soketAudioCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="soketAudioCondition" value="?" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
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
                data-hpp="{{$el->buy}}"
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
                                <input type="hidden" class="form-control priceHpp" name="priceHpp[]" value="0">
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
                                <input readonly type="hidden" class="form-control totalPriceHpp" name="totalPriceHpp[]" value="0" style="text-align: right">
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
            <button class="btn btn-primary mr-1 tombolSave" type="button" onclick="save()"><i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
            <button class="btn btn-warning mr-1 tombolPrint" style="display: none" type="button" onclick="print('{{URL::to('/')}}')"><i class="fas fa-print"></i>
                    {{ __('Cetak Data') }}</button>
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


<script src="{{ asset('assets/pages/transaction/serviceItemsScript.js') }}"></script>
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
