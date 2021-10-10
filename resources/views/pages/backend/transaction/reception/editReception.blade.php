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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Nama</th>
                                    <th>Barang yang belum datang</th>
                                    <th>Barang yang telah datang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach($models as $row)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $row->itemName }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control qtyOld_{{ $i }}" value="{{ $row->qty }}" name="qtyOld[]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control cleaveNumeral qtyNew_{{ $i }}" name="qtyNew[]" style="text-align: right" value="0" onkeyup="checkQty({{ $i }})">
                                        </td>
                                        <td>
                                            @if($row->edit != 1)
                                                <button type="button" class="btn btn-danger" value="{{ $i }}" onclick="deleted({{$row->id}})">X</button>
                                            @endif
                                            <!-- onkeyup="checkQty()" -->
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
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>History Pengeditan</h4>
                </div>
            </div>
        </div>
        @foreach($history as $row)
        <!-- <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Tanggal</h4>
                </div>
                <div class="card-body">
                    <h6>{{ $row->tanggal }}</h6>
                </div>
            </div>
        </div> -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ date('d F Y H:i:s', strtotime($row->date)) }}</h4>
                    @if($row->image != null)
                        <a href="{{ $row->image }}" target="_blank">
                            <img src="{{ asset($row->image) }}" style="width: 200px; height: 10; object-fit: contain;" />
                        </a>
                    @else
                    
                    @endif
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Nama</th>
                                    <th>Jumlah Barang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $i = 0; 
                                    $historyDetail = $row->history_detail;
                                @endphp
                                @foreach($historyDetail as $rows)
                                    <tr>
                                        <td width="60%">
                                            <input type="text" class="form-control" value="{{ $rows->name }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control cleaveNumeral qtyEdit_{{ $rows->id }}" name="qtyEdit[]" style="text-align: right" value="{{ $rows->qty }}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="idEdit[]" value="{{ $rows->id }}">
                                            <!-- <a href="/transaction/purchasing/reception/updated/1/2/8">Test</a> -->
                                            <button type="button" class="btn btn-warning" value="{{ $i }}" onclick="edited('{{ csrf_token() }}', '{{ $rows->purchasing_detail_id }}', '{{$rows->id}}')">Ubah</button>
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
            </div>
        </div>
        @endforeach
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
