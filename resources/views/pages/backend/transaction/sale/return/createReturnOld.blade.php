@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Return Penjualan'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('sale-return.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('titleContent', __('Tambah Return Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Return Penjualan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Return Penjualan') }}</div>
@endsection

@section('content')
{{-- <h2 class="section-title" id="saleDate">{{ \Carbon\Carbon::now()->format('d F Y') }}</h2> --}}
{{-- <p class="section-lead">{{ __('Tanggal nota penjualan dikeluarkan.') }}</p> --}}
<form id="stored">
    {{-- <a data-target="#dataSave" data-toggle="modal" data-backdrop="static" data-keyboard="false">
        Launch demo modal
    </a> --}}
    <div class="row">
        <div class="col-md-7 col-sm-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label class="control-label">
                                {{ __('Kode Faktur')}}<code>*</code>
                            </label>
                            <input class="form-control" type="text" value="{{ $code }}" readonly="">
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label class="control-label">
                                {{ __('Faktur Penjualan')}}<code>*</code>
                            </label>
                            <select class="select2" name="saleId" id="saleId" onchange="itemId('{{ csrf_token() }}','{{ route('sale.return.loadDataItem') }}', '#itemOld')">
                                <option value="">{{ __('- Select -') }}</option>
                                @foreach ($sale as $i)
                                <option value="{{ $i->id }}">
                                    {{ $i->code }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8 col-xs-12" id="itemOldDiv">
                            <label for="itemOld">{{ __('Barang') }}</label><code>*</code>
                            <select class="select2" name="itemOld" id="itemOld" onchange="itemAll('{{ csrf_token() }}','{{ route('sale.return.loadDataItemAll') }}', '#qtyForm')">
                                <option value="">{{ __('- Select -') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-xs-12" id="qtyForm">
                            <label for="">{{ __('Qty') }}</label><code>*</code>
                            <input class="form-control" type="text" value="1" readonly="">
                        </div>
                    </div>

                    {{-- @foreach ($item as $item)
                        <input type="hidden" class="itemData">
                    @endforeach --}}

                    <div class="row">
                        <div class="form-group col-md-8 col-xs-12">
                            <label for="description">{{ __('Keluhan') }}</label><code>*</code>
                            <input type="text" class="form-control" name="description" id="description">
                            {{-- <textarea data-name="Deskripsi" name="description" class="form-control" id="description"
                                style="height: 50px"></textarea> --}}
                        </div>
                        <div class="form-group col-md-4 col-xs-12" id="tindakanSelect">
                            <label for="type">{{ __('Tindakan') }}</label><code>*</code>
                            <select name="type" id="type" class="select2" onchange="tindakan()">
                                <option value="" selected>{{ __('- Select -') }}</option>
                                <option value="1">{{ __('Ganti uang') }}</option>
                                <option value="2">{{ __('Ganti barang serupa') }}</option>
                                <option value="3">{{ __('Tukar tambah') }}</option>
                                <option value="4">{{ __('Servis') }}</option>
                            </select>
                        </div>
                    </div>
                    <h6 style="color: #6777ef;">{{ __('Data Customer') }}</h6>
                    <div id="customerData"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail Harga') }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Harga Barang Lama') }}</label>
                        <div class="input-group" id="hargaBarangLamaId">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="item_price_old" type="text" value="" class="form-control" style="text-align: right" readonly>
                        </div>
                        {{-- <div class="input-group d-none" id="dv">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" id="discount_value" class="form-control" style="text-align: right"
                                readonly>
                        </div>
                        <div class="input-group d-none" id="dp">
                            <input type="text" id="discount_percent" class="form-control" style="text-align: right"
                                readonly>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('%') }}
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="form-group">
                        <label>{{ __('Harga Barang Baru') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="item_price" type="text" value="0" class="form-control" style="text-align: right" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Total Harga') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input id="total" type="text" value="0" class="form-control" style="text-align: right" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ $actionDetail }}
    <button class="btn btn-primary mr-1 tombolSave" type="button" onclick="save()" id="buttonSubmit" style="float: left; display: none;">
        <i class="far fa-save"></i>
        {{ __('Simpan Data') }}
    </button>
    <div class="card card-primary" id="dataDetailStyle">
        <div class="card-header" id="card-header-id">
            <h4>{{ __('Data Detail') }}</h4>
            <div class="card-header-action">
                <button onclick="addItemReturnSale()" type="button" class="btn btn-icon icon-left btn-warning">
                    <i class="fas fa-plus"></i>{{ __(' Tambah Datas') }}
                </button>
            </div>
        </div>
        <div class="card-body" id="card-body-id">
            {{-- @foreach ($buyer as $buyer)
            <input class="buyerData" type="hidden" data-name="{{$buyer->name}}" value="{{$buyer->id}}">
            @endforeach --}}
            @foreach ($stock as $el)
            <input class="itemsData" type="hidden" data-stock="{{$el->stock}}"
                data-supplier="{{$el->item->supplier->name}}" data-price="{{$el->item->sell - $el->item->discount}}"
                data-profit="{{$el->item->buy}}" data-name="{{$el->item->name}}" value="{{$el->item->id}}">
            @endforeach
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">{{ __('Barang') }}</th>
                            <th style="width: 9%">{{ __('Qty | Stock') }}</th>
                            <th style="width: 12%">{{ __('Harga | Jumlah') }}</th>
                            {{-- <th style="width: 10%">{{ __('Profit Sharing %') }}</th> --}}
                            <th>{{ __('Deskripsi') }}</th>
                            <th style="width: 15%">{{ __('Tipe') }}</th>
                            {{-- <th style="width: 15%" hidden>tipe</th> --}}
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1 tombolSave" type="button" onclick="save()">
                <i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button>
            <div class="row">
                <button class="btn btn-warning mr-1 tombolPrintKecil" style="display:none" type="button" onclick="printKecil('{{URL::to('/')}}')">
                    <i class="fas fa-print"></i>
                    {{ __('Nota Kecil') }}</button>
                <button class="btn btn-warning mr-1 tombolPrintBesar" style="display:none" type="button" onclick="printBesar('{{URL::to('/')}}')">
                    <i class="fas fa-print"></i>
                    {{ __('Nota Besar') }}</button>
            </div>
        </div>
    </div>


    {{-- <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Data Return Detail') }}</h4>
            <div class="card-header-action">
                <button onclick="add()" type="button" class="btn btn-icon icon-left btn-warning">
                    <i class="fas fa-plus"></i>{{ __(' Tambah Datas') }}
                </button>
            </div>
        </div>
        <div id="datas">

        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('Nama Barang') }}</th>
                            <th>{{ __('Perlakuan') }}</th>
                            <th>{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody id="itemData">
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="button" onclick="save()">
                    <i class="far fa-save"></i>
                    {{ __('Simpan Data') }}</button>
            </div>
        </div>
    </div> --}}
</form>
@endsection
@section('modal')
@include('pages.backend.transaction.sale.return.components.modalReturn')
@include('pages.backend.transaction.sale.return.components.successModalReturn')
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/sale/return/saleReturn.js') }}"></script>
<script type="text/javascript">
    var loading = `-- sedang memuat data --`;
    var getdata = '{{ route('sale.return.data') }}';
    var url = '{{ route('sale-return.store') }}';
    var index = '{{ route('sale-return.index') }}';
    var service = '{{ route('service.index') }}';
    var returnURL = '{{ route('sale.return.type') }}';
    var buy = '{{ route('purchase.create') }}';
    var addURL = '{{ route('sale.return.add') }}';
    var getDetailURL = '{{ route('sale.return.detail') }}';

    function itemId(token, url, target) {
      var saleId = document.getElementById("saleId").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          saleId,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
    }
    function itemAll(token, url, target) {
      var itemOld = document.getElementById("itemOld").value;
      $(target).html(loading);
      $.post(url, {
          _token: token,
          item: itemOld,
      },
      function (data) {
          console.log(data);
          $(target).html(data);
      });
    }
    function tindakan() {
        var selected = document.getElementById("type").selectedIndex;
        var itemOld = document.getElementById("itemOld").value;
        // alert(selected);
        if(selected == 1) {
            // document.getElementById("dataDetailStyle").style.visibility = "hidden";
            // document.getElementById("buttonSubmit").style.visibility = "visible";
            document.getElementById("dataDetailStyle").style.display = "none";
            document.getElementById("buttonSubmit").style.display = "block";
        } else {
            document.getElementById("dataDetailStyle").style.display = "block";
            document.getElementById("buttonSubmit").style.display = "none";
        }
        // else {
        //     document.getElementById("dataDetailStyle").style.visibility = "visible";
        // }
    }
    function addItemReturnSale() {
        var index = $('.priceDetail').length;
        var dataDetail = $('.dataDetail').length;
        $('.dropHereItem').append(
            '<tr class="dataDetail dataDetail_'+(dataDetail+1)+'">'+
                '<td style="display:none">'+
                    '<input type="text" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="priceDetailSparePart[]" value="0">'+
                    '<input type="text" class="form-control priceDetailLoss priceDetailLoss_'+(index+1)+'" name="priceDetailLoss[]" value="0">'+
                '</td>'+
                '<td>'+
                    '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                        '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
                        dataItems+
                    '</select>' +
                    '<input type="text" class="form-control supplier supplier_'+(index+1)+'" name="supplierDetail[]" data-index="'+(index+1)+'" readonly>'+
                '</td>'+
                '<td>' +
                    '<input type="text" class="form-control qtyDetail qtyDetail_' + (index + 1) + '" name="qtyDetail[]" data-index="' + (index + 1) + '" value="1" style="text-align: right">' +
                    '<input type="text" class="form-control stock stock_'+(index+1)+'" readonly name="stockDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
                '</td>'+
                '<td>' +
                    '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
                    '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">'+
                '</td>'+
                // '<td>'+
                //     '<select class="select2 buyerDetail" name="buyerDetail[]">'+
                //         '<option value="" data-index="'+(index+1)+'">- Select Buyer -</option>'+
                //         dataBuyer+
                //     '</select>' +
                //     '<input type="text" class="form-control" name="salesDetail[]" value="Sales" readonly>'+
                // '</td>'+
                // '<td>'+
                //     '<input type="number" class="form-control" name="profitSharingBuyer[]" value="0">'+
                //     '<input type="number" class="form-control" name="profitSharingSales[]" value="0">'+
                // '</td>'+
                '<td>'+
                    // '<input type="text" class="form-control cleaveNumeral profitDetail profitDetail_'+(index+1)+'" name="profitDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right" hidden>'+
                    '<input type="text" class="form-control" name="descriptionDetail[]">' +
                '</td>'+
                '<td>'+
                    '<select class="select2 typeDetail typeDetail_'+(index+1)+'" name="typeDetail[]">'+
                        '<option selected data-index="'+(index+1)+'" value="SparePart">Ganti Barang</option>'+
                        '<option data-index="'+(index+1)+'" value="Loss">Barang Loss</option>'+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
                '</td>'+
            '</tr>'
        );
    }
</script>
@endsection
