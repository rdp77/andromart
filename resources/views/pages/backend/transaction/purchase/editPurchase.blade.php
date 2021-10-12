@extends('layouts.backend.default')
@section('title', __('pages.title').__('Edit Pembelian'))
@section('titleContent', __('Edit Pembelian'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Pembelian') }}</div>
@endsection

@section('content')
<!-- <form class="form-data"> -->
<form method="POST" action="{{ route('purchase.update', $model->id) }}" class="form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                            <input id="code" type="text" class="form-control" readonly="" value="{{ $model->code }}" name="code">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                            <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y', strtotime($model->date))}}" name="date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="warranty">{{ __('Pembeli') }}<code>*</code></label>
                            <select class="select2 validation" name="buyer" data-name="Buyer">
                                <option value="">- Select -</option>
                                @foreach ($employee as $row)
                                    @if($model->employee_id == $row->id)
                                        <option value="{{$row->id}}" selected>{{$row->name}}</option>
                                    @else
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label class="form-label">Pembayaran</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    @if($model->status == "paid")
                                        <input type="radio" name="pay" value="paid" class="selectgroup-input" checked>
                                    @else
                                        <input type="radio" name="pay" value="paid" class="selectgroup-input">
                                    @endif
                                    <span class="selectgroup-button">Telah Dibayar</span>
                                </label>
                                <label class="selectgroup-item">
                                    @if($model->status == "debt")
                                        <input type="radio" name="pay" value="debt" class="selectgroup-input" checked>
                                    @else
                                        <input type="radio" name="pay" value="debt" class="selectgroup-input">
                                    @endif
                                    <span class="selectgroup-button">Belum Dibayar</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="descriptionPurchase">{{ __('Keterangan') }}<code>*</code></label>
                            <input id="descriptionPurchase" type="text" class="form-control" name="descriptionPurchase">
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
                        <label for="priceTotal">{{ __('Harga Total') }}<code>*</code></label>
                        <input readonly id="priceTotal" onchange="sumTotal()" type="text" value="0" class="form-control cleaveNumeral" name="priceTotal" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan Diskon Yang Dipakai</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="percent" onchange="changeDiscount('percent')" checked
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Persentase (%)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="typeDiscount" value="value" onchange="changeDiscount('value')" 
                                    class="selectgroup-input">
                                <span class="selectgroup-button">Harga (RP)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountPercent">{{ __('Diskon %') }}<code>*</code></label>
                            <input id="totalDiscountPercent" type="text" value="0" class="form-control cleaveNumeral" name="totalDiscountPercent" onkeyup="sumTotal(), sumDiscount()" style="text-align: right">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="totalDiscountValue">{{ __('Diskon') }}<code>*</code></label>
                            <input id="totalDiscountValue" type="text" value="0" class="form-control cleaveNumeral" name="totalDiscountValue" onkeyup="sumTotal()" style="pointer-events: none;background-color:#e9ecef; text-align: right">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discountTotal">{{ __('Jumlah Diskon') }}<code>*</code></label>
                        <input readonly id="discountTotal" onchange="sumTotal()" type="text" value="0" class="form-control cleaveNumeral" name="discountTotal" style="text-align: right">
                    </div>
                    <div class="form-group">
                        <label for="grandTotal">{{ __('Grand Total') }}<code>*</code></label>
                        <input readonly id="grandTotal" onchange="sumTotal()" type="text" value="0" class="form-control cleaveNumeral" name="grandTotal" style="text-align: right">
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-header">
            <h4>Barang</h4>
            <div class="card-header-action">
                <button onclick="addItem()" type="button" class="btn btn-warning">Tambah Barang <i
                        class="fas fa-add"></i></button>
            </div>
        </div>
        <div class="card-body">

            @foreach ($item as $el)
                <input class="itemsData" type="hidden"
                data-price="{{$el->buy}}"
                data-name="{{$el->name}} | {{$el->supplier}}"
                value="{{$el->id}}">
            @endforeach
            @foreach ($branch as $el)
                <input class="branchesData" type="hidden"
                data-name="{{$el->name}}"
                value="{{$el->id}}">
            @endforeach
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cabang / item</th>
                            <th>Harga Beli / QTY</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <!-- <button class="btn btn-primary mr-1" type="button" onclick="save()"><i class="far fa-save"></i>
                {{ __('Simpan Data') }}</button> -->
            <button class="btn btn-primary mr-1" type="submit"><i class="far fa-save"></i>
                {{ __('Ubah Data') }}</button>
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
<script src="{{ asset('assets/pages/transaction/purchaseScript.js') }}"></script>
<script type="text/javascript">
    var arrModels = <?php echo json_encode($models);?>;
    // console.log(arrModels);
    arrModels.forEach(myFunction);
    function myFunction(item, index, arr) {
        var branch_id = 0;
        var item_id = 0;
        var qty = 0;
        var price = 0; 
        Object.entries(arr[index]).forEach(entry2 => {
            var [key2, value2] = entry2;

            if(key2 == 'branch_id') { branch_id = value2 }
            if(key2 == 'item_id') { item_id = value2 }
            if(key2 == 'qty') { qty = value2 }
            if(key2 == 'price') { price = value2 }
        });
        addItems(branch_id, item_id, qty, price);
    }
</script>
<style>
    .modal-backdrop{
        position: relative !important;
    }
</style>
@endsection
