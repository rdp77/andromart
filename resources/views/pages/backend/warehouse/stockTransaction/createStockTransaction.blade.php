@extends('layouts.backend.default')
@section('title', __('pages.title').__('Tambah Stock Transaksi'))
@section('titleContent', __('Tambah Stock Transaksi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Stock Transaksi') }}</div>
@endsection

@section('content')
<form method="POST" class="form-data">
    @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Form Data</h4>
                </div>
                <div class="card-body">
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
                            <label for="itemId">{{ __('Nama Item') }}<code>*</code></label>
                            <select class="select2 item" name="item">
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

                        @foreach ($item as $el)
                            <input class="itemData" type="hidden"
                            data-brand="{{$el->brand_id}}"
                            data-name="{{$el->name}}"
                            data-supplier="{{$el->supplier->name}}"
                            value="{{$el->id}}">
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control datepicker"
                                name="date">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="type">{{ __('Tipe') }}<code>*</code></label>
                            <select class="select2 type" name="type">
                                <option value="">- Select -</option>
                                <option value="In">In (Masuk)</option>
                                <option value="Out">Out (Keluar)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="reason">{{ __('alasan') }}<code>*</code></label>
                            <select class="select2 reason" name="reason">
                                <option value="">- Select -</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="qty">{{ __('qty') }}<code>*</code></label>
                            <input id="qty" type="text" class="form-control qty"
                                name="qty">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-12">
                            <label for="type">{{ __('Keterangan') }}<code>*</code></label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>
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
<script src="{{ asset('assets/pages/warehouse/stockTransactionScript.js') }}"></script>
@endsection