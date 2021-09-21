@extends('layouts.backend.default')
@section('title', __('pages.title').__('Ubah Penerimaan'))
@section('titleContent', __('Ubah Penerimaan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penerimaan') }}</div>
<div class="breadcrumb-item active">{{ __('Ubah Penerimaan') }}</div>
@endsection

@section('content')
<form method="POST" action="{{ route('reception.update', $id) }}">
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
                            <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                                name="date">
                        </div>
                    </div>
                        @php 
                            if($model->employee_id == null) {
                                $pembeli = "Tanpa Pembeli";
                            } else {
                                $pembeli = $model->employee_id;
                            }
                        @endphp
                        <!-- @if($model->employee_id == null)
                            $pembeli = "Tanpa Pembeli";
                        @else
                            $pembeli = $model->employee_id;
                        @endif -->
                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            <label for="pembeli">{{ __('Pembeli') }}<code>*</code></label>
                            <input id="pembeli" type="text" class="form-control" value="{{ $pembeli }}" readonly>
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
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="totalPrice">{{ __('Total Harga') }}<code>*</code></label>
                            <input id="totalPrice" type="text" class="form-control  cleaveNumeral" value="{{ $model->price }}" readonly>
                        </div>
                        <div class="form-group col-12">
                            <label for="totalDiscount">{{ __('Total Diskon') }}<code>*</code></label>
                            <input id="totalDiscount" type="text" class="form-control  cleaveNumeral" value="{{ $model->discount }}" readonly>
                        </div>
                        @if($model->status == 'dept')
                        <div class="form-group col-12">
                            <label for="status">{{ __('Status') }}<code>*</code></label>
                            <input id="status" type="text" class="form-control" value="Belum Dibayar" readonly>
                        </div>
                        @else
                        <div class="form-group col-12">
                            <label for="status">{{ __('Status') }}<code>*</code></label>
                            <input id="status" type="text" class="form-control" value="Telah Dibayar" readonly>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%">Nama</th>
                            <th>Barang yang belum datang</th>
                            <th>Barang yang telah datang</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($models as $row)
                            <tr>
                                <td><input type="text" class="form-control" value="{{ $row->itemName }}" readonly></td>
                                <td><input type="text" class="form-control cleaveNumeral qtyOld_{{ $i }}" value="{{ $row->qty }}" readonly></td>
                                <td>
                                    <input type="text" class="form-control cleaveNumeral qtyNew_{{ $i }}" name="qtyNew[]" onkeyup="checkQty()" style="text-align: right">
                                    <input type="hidden" name="idDetail[]" value="{{ $i }}">
                                    <input type="hidden" name="idPurchasing[]" value="{{ $row->id }}">
                                    <input type="hidden" name="idItem[]" value="{{ $row->item_id }}">
                                    <input type="hidden" name="idUnit[]" value="{{ $row->unit_id }}">
                                    <input type="hidden" name="idBranch[]" value="{{ $row->branch_id }}">
                                </td>
                            </tr>
                            @php $i++ @endphp
                        @endforeach
                    </tbody>
                    <tbody class="dropHereItem" style="border: none !important">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit"><i class="far fa-save"></i>{{ __('Ubah Data') }}</button>
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
<script src="{{ asset('assets/pages/transaction/receptionScript.js') }}"></script>
<script type="text/javascript">
</script>
<style>
    .modal-backdrop{
        position: relative !important;
    }
</style>
@endsection
