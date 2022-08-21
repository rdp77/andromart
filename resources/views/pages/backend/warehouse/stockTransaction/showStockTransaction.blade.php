@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Lihat Stock Transaksi'))
@section('titleContent', __('Lihat Stock Transaksi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Lihat Stock Transaksi') }}</div>
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
                        {{-- <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="type">{{ __('Kategori') }}<code>*</code></label>
                            <select class="select2 type validation" name="type" onchange="category()" data-name="Kategori">
                                <option value="">- Select -</option>
                                 @foreach ($category as $element)
                                    <option @if ($data->type == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="brand">{{ __('Merk') }}<code>*</code></label>
                            <select class="select2 brand validation" name="brand" data-name="Merk">
                                <option value="">- Select -</option>
                                @foreach ($brand as $element)
                                    @if ($element->category_id == $data->type)
                                        <option @if ($data->brand == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="itemId">{{ __('Nama Item') }}<code>*</code></label>
                            <select class="select2 item validation" onchange="checkStock()" disabled name="item" data-name="Item">
                                <option value="">- Select -</option>
                                  @foreach ($item as $element)
                                    <option @if ($data->item_id == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                  @endforeach
                                {{-- @foreach ($type as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach --}}
                            </select>
                            {{-- <input id="series" type="text" class="form-control" name="series"> --}}
                        </div>

                     

                    </div>
                    {{-- <div class="row">
                       
                    </div> --}}
                    <div class="row">
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="type">{{ __('Tipe') }}<code>*</code></label>
                            <select class="select2 type validation" disabled name="type" data-name="Tipe">
                                <option value="In" @if ($data->type == 'In') selected @endif>In (Masuk)</option>
                                <option value="Out" @if ($data->type == 'Out') selected @endif>Out (Keluar)</option>
                                <option value="Mutation" @if ($data->type == 'Mutation') selected @endif>Mutation (Pindah Cabang) </option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control" disabled value="{{date('d F Y',strtotime($data->date))}}"
                                name="date">
                        </div>
                        <div class="form-group col-12 col-md-2 col-lg-2">
                            <label>{{ __('Stock') }}<code>*</code></label>
                            <input type="text" class="form-control stockSaatIni" readonly value="-">
                        </div>
                        <div class="form-group col-12 col-md-2 col-lg-2">
                            <label for="qty">{{ __('Qty') }}<code>*</code></label>
                            <input id="qty" type="text" class="form-control"
                                 value="{{$data->qty}}" disabled>
                        </div>
                    </div>
                    <div class="row hiddenReason">
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="reason">{{ __('Alasan') }}<code>*</code></label>
                            <select class="select2 reason" disabled name="reason">
                                <option value="" selected>{{$data->reason}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row hiddenBranch" @if ($data->type != 'Mutation') style="display:none" @endif>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="origin">{{ __('Cabang Asal') }}<code>*</code></label>
                            <select class="form-control origin" disabled name="origin" readonly style="pointer-events: none;">
                                <option value="">- Select -</option>
                                @foreach ($branch as $element)
                                    <option value="{{$element->id}}"
                                    @if ($data->branch_id == $element->id) selected @endif>{{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="destination">{{ __('Cabang Tujuan') }}<code>*</code></label>
                            <select class="select2 destination" disabled name="destination">
                                <option value="">- Select -</option>
                                @foreach ($branch as $element)
                                    <option @if ($data->branch_destination_id == $element->id) selected @endif value="{{$element->id}}">{{$element->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-8">
                            <label for="type">{{ __('Keterangan') }}<code>*</code></label>
                            <textarea name="description" disabled class="form-control validation"id="description" data-name="Keterangan">{{$data->description}}</textarea>
                        </div>
                       
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label for="price">{{ __('Harga') }}<code>*</code></label>
                            <input id="price" type="text" readonly class="form-control price validation"
                                name="price" data-name="price" value="-">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label for="total">{{ __('Total') }}<code>*</code></label>
                            <input id="total" type="text" readonly class="form-control total validation"
                                name="total" data-name="total" value="{{$data->total}}">
                        </div>
                        
                    </div>
                </div>
              
            </div>


</form>
@endsection

@section('script')
<script src="{{ asset('assets/pages/warehouse/stockTransactionScript.js') }}"></script>
@endsection
