@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Service'))
@section('titleContent', __('Edit Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Service') }}</div>
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
                            <input id="code" type="text" class="form-control" readonly="" value="{{ $service->code }}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control datepicker" readonly=""
                            value="{{ $service->date }}" name="date">
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="warranty">{{ __('Garansi') }}<code>*</code></label>
                            <select class="select2" name="warranty">
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
                            <input id="estimateDate" type="text" value="{{ $service->estimate_date }}" class="form-control datepicker" name="estimateDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="estimateDay">{{ __('Analisa') }}<code>*</code></label>
                            <input id="estimateDay" type="text" value="{{$service->estimate_day}}" class="form-control" name="estimateDay">
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
                            <label for="noImei">{{ __('No Imei') }}<code>*</code></label>
                            <input id="noImei" value="{{$service->no_imei}}" type="text" class="form-control" name="noImei">
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Kesepakatan Bersama') }}<code>*</code></label>
                            <input id="description" value="{{$service->description}}" type="text" class="form-control validation" data-name="Deskripsi" name="description">
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
                            <select class="select2 customerId" name="customerId" onchange="customerChange()">
                                <option value="">- Select -</option>
                                @foreach ($customer as $element)
                                <option @if ($service->customer_id == $element->id) selected @endif value="{{$element->id}}"
                                    data-name="{{$element->name}}"
                                    data-address="{{$element->address}}"
                                    data-phone="{{$element->contact}}"
                                    >{{$element->name}}</option>
                                @endforeach
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
                                <input type="checkbox" name="chargerEquipment" @if ($service->ServiceEquipment[0]->status == 'Y') checked @endif  class="chargerEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Charger</span>
                            </label>
                            <div class="chargerEquipmentDescUsed"
                                @if ($service->ServiceEquipment[0]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif ><hr>
                                <input id="chargerEquipmentDesc" value="{{$service->ServiceEquipment[0]->description}}" type="text" class="form-control" name="chargerEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="bateraiEquipment" @if ($service->ServiceEquipment[1]->status == 'Y') checked @endif class="bateraiEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Baterai</span>
                            </label>
                            <div class="bateraiEquipmentDescUsed"
                                @if ($service->ServiceEquipment[1]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                                ><hr>
                                <input id="bateraiEquipmentDesc" type="text" value="{{$service->ServiceEquipment[1]->description}}" class="form-control" name="bateraiEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="hardiskSsdEquipment" @if ($service->ServiceEquipment[2]->status == 'Y') checked @endif class="hardiskSsdEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Hardisk / SSD</span>
                            </label>
                            <div class="hardiskSsdEquipmentDescUsed"
                                @if ($service->ServiceEquipment[2]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                                ><hr>
                                <input id="hardiskSsdEquipmentDesc" type="text" value="{{$service->ServiceEquipment[2]->description}}" class="form-control" name="hardiskSsdEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="RamEquipment" @if ($service->ServiceEquipment[3]->status == 'Y') checked @endif class="RamEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">RAM</span>
                            </label>
                            <div class="RamEquipmentDescUsed"
                            @if ($service->ServiceEquipment[3]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                            ><hr>
                                <input id="RamEquipmentDesc" value="{{$service->ServiceEquipment[3]->description}}" type="text" class="form-control" name="RamEquipmentDesc">
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="kabelEquipment" @if ($service->ServiceEquipment[4]->status == 'Y') checked @endif class="kabelEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Kabel</span>
                            </label>
                            <div class="kabelEquipmentDescUsed"
                            @if ($service->ServiceEquipment[4]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                            ><hr>
                                <input id="kabelEquipmentDesc" value="{{$service->ServiceEquipment[4]->description}}" type="text" class="form-control" name="kabelEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="tasLaptopEquipment" @if ($service->ServiceEquipment[5]->status == 'Y') checked @endif class="tasLaptopEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Tas Laptop</span>
                            </label>
                            <div class="tasLaptopEquipmentDescUsed"
                            @if ($service->ServiceEquipment[5]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                            ><hr>
                                <input id="tasLaptopEquipmentDesc" value="{{$service->ServiceEquipment[5]->description}}" type="text" class="form-control" name="tasLaptopEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="aksesorisEquipment" @if ($service->ServiceEquipment[6]->status == 'Y') checked @endif class="aksesorisEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Aksesoris</span>
                            </label>
                            <div class="aksesorisEquipmentDescUsed"
                            @if ($service->ServiceEquipment[6]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                            ><hr>
                                <input id="aksesorisEquipmentDesc" value="{{$service->ServiceEquipment[6]->description}}" type="text" class="form-control" name="aksesorisEquipmentDesc">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            <label class="custom-switch mt-2" style="margin-left: -30px !important">
                                <input type="checkbox" name="lainnyaEquipment" @if ($service->ServiceEquipment[7]->status == 'Y') checked @endif class="lainnyaEquipment custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Lainnya</span>
                            </label>
                            <div class="lainnyaEquipmentDescUsed"
                            @if ($service->ServiceEquipment[7]->status == 'Y')
                                    style="display: block"
                                @else
                                    style="display: none"
                                @endif
                            ><hr>
                                <input id="lainnyaEquipmentDesc" value="{{$service->ServiceEquipment[7]->description}}" type="text" class="form-control" name="lainnyaEquipmentDesc">
                            </div>
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
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total HPP') }}<code>*</code></label>
                        <input id="totalHppAtas" type="text" readonly value="{{$service->total_hpp}}" class="form-control cleaveNumeral"
                            name="totalHppAtas" style="text-align: right">
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
            <div class="card">
                <div class="card-header">
                    <h4>Kondisi Serah Terima Unit</h4>

                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">LCD</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="LcdCondition" value="Y" @if ($service->ServiceCondition[0]->status == 'Y') checked @endif
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="LcdCondition" value="N" @if ($service->ServiceCondition[0]->status == 'N') checked @endif
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="LcdCondition" value="?" @if ($service->ServiceCondition[0]->status == '?') checked @endif
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Touch Screen</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[8]->status == 'Y') checked @endif type="radio" name="touchScreenCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[8]->status == 'N') checked @endif type="radio" name="touchScreenCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[8]->status == '?') checked @endif type="radio" name="touchScreenCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">WIFI</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[1]->status == 'Y') checked @endif type="radio" name="wifiCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[1]->status == 'N') checked @endif type="radio" name="wifiCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[1]->status == '?') checked @endif type="radio" name="wifiCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Charging</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[5]->status == 'Y') checked @endif type="radio" name="chargingCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[5]->status == 'N') checked @endif type="radio" name="chargingCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[5]->status == '?') checked @endif type="radio" name="chargingCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Camera Depan</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[2]->status == 'Y') checked @endif type="radio" name="cameraDepanCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[2]->status == 'N') checked @endif type="radio" name="cameraDepanCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[2]->status == '?') checked @endif type="radio" name="cameraDepanCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Camera Belakang</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[3]->status == 'Y') checked @endif type="radio" name="cameraBelakangCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[3]->status == 'N') checked @endif type="radio" name="cameraBelakangCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input @if ($service->ServiceCondition[3]->status == '?') checked @endif type="radio" name="cameraBelakangCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vibrator</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[9]->status == 'Y') checked @endif type="radio" name="vibratorCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[9]->status == 'N') checked @endif type="radio" name="vibratorCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[9]->status == '?') checked @endif type="radio" name="vibratorCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Speaker</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[7]->status == 'Y') checked @endif type="radio" name="speakerCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[7]->status == 'N') checked @endif type="radio" name="speakerCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[7]->status == '?') checked @endif type="radio" name="speakerCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mic</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[6]->status == 'Y') checked @endif type="radio" name="micCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[6]->status == 'N') checked @endif type="radio" name="micCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[6]->status == '?') checked @endif type="radio" name="micCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Touchpad</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[15]->status == 'Y') checked @endif type="radio" name="touchpadCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[15]->status == 'N') checked @endif type="radio" name="touchpadCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[15]->status == '?') checked @endif type="radio" name="touchpadCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keyboard</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[14]->status == 'Y') checked @endif type="radio" name="keyboardCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[14]->status == 'N') checked @endif type="radio" name="keyboardCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[14]->status == '?') checked @endif type="radio" name="keyboardCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tombol Tombol</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[13]->status == 'Y') checked @endif type="radio" name="tombolCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[13]->status == 'N') checked @endif type="radio" name="tombolCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[13]->status == '?') checked @endif type="radio" name="tombolCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sinyal</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[12]->status == 'Y') checked @endif type="radio" name="sinyalCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[12]->status == 'N') checked @endif type="radio" name="sinyalCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[12]->status == '?') checked @endif type="radio" name="sinyalCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Usb</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[11]->status == 'Y') checked @endif type="radio" name="usbCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[11]->status == 'N') checked @endif type="radio" name="usbCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[11]->status == '?') checked @endif type="radio" name="usbCondition" value="?"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Soket Audio</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[10]->status == 'Y') checked @endif type="radio" name="soketAudioCondition" value="Y"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[10]->status == 'N') checked @endif type="radio" name="soketAudioCondition" value="N"
                                    class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input  @if ($service->ServiceCondition[10]->status == '?') checked @endif type="radio" name="soketAudioCondition" value="?"
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
                                        @foreach ($item as $el0)
                                            <option data-index="{{$i}}"
                                            data-hpp="{{$el0->buy}}"
                                            data-price="{{$el0->sell}}"
                                            @foreach ($el0->stock as $el1)
                                                @if ((Auth::user()->employee->branch_id == $el1->branch_id))
                                                    data-stock="{{$el1->stock}}"
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
                                    <input type="text" class="form-control cleaveNumeral  priceDetail priceDetail_{{$i}}" name="priceDetailOld[]" data-index="{{$i}}" style="text-align: right" value="{{$el->price}}">
                                    <input type="hidden" class="form-control priceHpp priceHpp_{{$i}}" name="priceHppOld[]" value="{{$el->hpp}}">
                                </td>
                                <td>
                                    <input type="text" class="form-control qtyDetail qtyDetail_{{$i}}" name="qtyDetailOld[]" value="{{$el->qty}}" data-index="{{$i}}" style="text-align: right">

                                </td>
                                <td>
                                    <input readonly type="text" class="form-control stockDetail stock_{{$i}}" name="stockDetailOld[]"
                                    @foreach ($item as $el0)
                                        @foreach ($el0->stock as $el1)
                                            @if ((Auth::user()->employee->branch_id == $el1->branch_id))
                                                value="{{$el1->stock}}"
                                            @endif
                                        @endforeach
                                    @endforeach
                                    style="text-align: right">
                                </td>
                                <td>
                                    <input readonly type="text" class="form-control totalPriceDetail cleaveNumeral totalPriceDetail_{{$i}}" name="totalPriceDetailOld[]" style="text-align: right" value="{{$el->total_price}}">
                                    <input readonly type="hidden" class="form-control totalPriceHpp totalPriceHpp_{{$i}}" name="totalPriceHppOld[]" value="{{$el->total_hpp}}" style="text-align: right">
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
