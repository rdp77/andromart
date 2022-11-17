@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Pembayaran Service'))
@section('titleContent', __('Tambah Pembayaran Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Pembayaran Service') }}</div>
@endsection

@section('content')
@csrf
<form class="form-data">
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
                            <input id="code" type="text" class="form-control code" readonly="" value="{{$service->code}}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <div class="d-block">
                                <label for="serviceId"
                                    class="control-label">{{ __('Service Faktur') }}<code>*</code></label>
                            </div>
                            <input type="text" readonly class="form-control" value="{{$service->code}}">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control datepicker validation date" data-name="Tanggal Harus Di isi" disabled value="{{\Carbon\Carbon::parse($service->date)->locale('id')->isoFormat('LL')}}" name="date">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="type">{{ __('Tipe') }}<code>*</code></label>
                            <select class="select2 type validation" disabled data-name="Tipe Harus Di isi" name="type">
                                <option value="">- Select -</option>
                                <option @if ($service->type == 'Lunas')
                                    selected
                                @endif value="Lunas">Lunas</option>
                                <option @if ($service->type == 'DownPayment')
                                    selected
                                @endif value="DownPayment">Down Payment</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="type">{{ __('Pembayaran') }}<code>*</code></label>
                            <select class="select2 PaymentMethod validation" disabled data-name="Metode Pembayaran Harus Di isi"  name="paymentMethod" disabled>
                                <option @if ($service->payment_method == 'Cash') selected  @endif  value="Cash">Cash</option>
                                <option @if ($service->payment_method == 'Debit') selected  @endif value="Debit">Debit</option>
                                <option @if ($service->payment_method == 'Transfer') selected  @endif value="Transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="type">{{ __('Akun') }}<code>*</code></label>
                            <select class="select2 account validation" disabled data-name="Akun Harus Di isi"  name="account">
                                <option value="">- Select -</option>
                                @foreach ($account as $el)
                                    <option value="{{$el->id}}" @if ($el->id == $service->account)
                                        selected
                                    @endif>{{$el->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="display: none">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="type">{{ __('Keterangan') }}<code>*</code></label>
                            <textarea name="description" class="form-control" value="-" data-name="Deskripsi Harus Di isi"  id="description"></textarea>
                        </div>
                    </div>
                    <input type="hidden" class="branchId" value="{{Auth::user()->employee->branch_id}}">
                    {{-- <input type="hidden" class="branchId" value="{{}}"> --}}
                    {{-- <input type="hidden" class="branchId" value="{{}}"> --}}
                  
                    {{-- <h6 style="color: #6777ef">Data Service</h6>
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12">

                        </div>

                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Harga</h4>

                </div>
                <input id="totalPriceHidden" type="hidden" value="{{$service->total}}" class="form-control cleaveNumeral totalPriceHidden"
                name="totalPriceHidden" style="text-align: right" >

                <input id="checkDpData" type="hidden" class="form-control checkDpData"
                name="checkDpData" style="text-align: right" >

                <div class="card-body">
                    <div class="form-group">
                        <label for="totalService">{{ __('Jasa') }}<code>*</code></label>
                        <input readonly id="totalService" onchange="sumTotal()" type="text" 
                        @if ($service->type == 'DownPayment')
                        value="0"
                        @else
                        value="{{$service->Service->total_service}}"
                        @endif
                            class="form-control cleaveNumeral totalService" name="totalService" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="totalSparePart">{{ __('Spare Part') }}<code>*</code></label>
                        <input readonly id="totalSparePart" onchange="sumTotal()" type="text" 
                        @if ($service->type == 'DownPayment')
                        value="0"
                        @else
                        value="{{$service->Service->total_part}}"
                        @endif
                            class="form-control cleaveNumeral totalSparePart" name="totalSparePart" style="text-align: right">
                    </div>
                    <div class="form-group" style="display: none">
                        <label for="totalLoss" >{{ __('Total Loss') }}<code>*</code></label>
                        <input readonly id="totalLoss" onchange="sumTotal()" type="text" value="0"
                            class="form-control cleaveNumeral totalLoss" name="totalLoss" style="text-align: right">
                    </div>
                    <div class="form-group DownPaymentHidden"  style="display: none">
                        <label for="totalDownPayment">{{ __('Down Payment') }}<code>*</code></label>
                        <input readonly id="totalDownPayment" onchange="sumTotal()" type="text" @if ($service->type == 'DownPayment')
                        value="{{$service->Service->total_downpayment}}"
                        @else
                        value="0"
                        @endif
                            class="form-control cleaveNumeral totalDownPayment" name="totalDownPayment" style="text-align: right">
                    </div>
                    {{-- <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input readonly id="totalDiscountPercent" type="text" value="0" class="form-control totalDiscountPercent cleaveNumeral"
                                name="totalDiscountPercent" onkeyup="sumTotal()" style="text-align: right">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                            <input readonly id="totalDiscountValue" type="text" value="0" class="form-control cleaveNumeral"
                                name="totalDiscountValue" onkeyup="sumTotal()" style="text-align: right">
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="totalPayment">{{ __('Total Bayar') }}<code>*</code></label>
                        <input id="totalPayment" type="text"   
                        @if ($service->type == 'DownPayment')
                        value="{{$service->total}}"
                        @else
                        value="{{$service->total}}"
                        @endif 
                        class="form-control cleaveNumeral totalPayment"
                            name="totalPayment" style="text-align: right" onkeyup="sumTotal()">
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                        <input readonly id="totalPrice" type="text" class="form-control cleaveNumeral totalPrice"
                        @if ($service->type == 'DownPayment')
                        value="{{$service->total}}"
                        @else
                        value="{{$service->total}}"
                        @endif 
                            name="totalPrice" onchange="sumTotal()" style="text-align: right">

                        <input id="totalHpp" type="text" style="display: none" class="totalHpp form-control"
                        name="totalHpp" style="text-align: right">

                        <input id="totalDiskonService" type="text" style="display: none" value="0" class="totalDiskonService form-control"
                        name="totalDiskonService" style="text-align: right">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Data Detail</h4>
            <div class="card-header-action">
            </div>
        </div>
        <div class="card-body">
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
                        </tr>
                    </thead>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="{{ asset('assets/pages/transaction/servicePaymentScript.js') }}"></script>
@endsection
