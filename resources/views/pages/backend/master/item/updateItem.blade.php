@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Barang'))
@section('titleContent', __('Edit Master Barang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Barang') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Barang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('item.update',$item->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-12 col-md-4 col-lg-4">
                    <label for="type">{{ __('Kategori') }}<code>*</code></label>
                    <select class="select2 type" name="type" onchange="category()">
                        {{-- <option value="">- Select -</option> --}}
                        <option value="{{ $item->brand->category->id }}"> {{ $item->brand->category->name }} </option>
                        @foreach ($category as $element)
                        <option value="{{$element->id}}" @if ($element->id == $item->brand->category->id) selected @endif>{{$element->name}}</option>
                        {{-- <option value="{{$element->id}}">{{$element->name}}</option> --}}
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-4 col-lg-4">
                    <label for="brand">{{ __('Merk') }}<code>*</code></label>
                    <select class="select2 brand" name="brand" required>
                        <option value="{{ $item->brand->id }}">{{ $item->brand->name }}</option>
                    </select>
                </div>
                @foreach ($brand as $el)
                    <input class="brandData" type="hidden"
                        data-category="{{$el->category_id}}"
                        data-name="{{$el->name}}"
                        value="{{$el->id}}">
                @endforeach
                <div class="form-group col-12 col-md-4 col-lg-4">
                    <label for="unit_id">{{ __('Satuan') }}<code>*</code></label>
                    <select class="select2" name="unit_id" required>
                        {{-- <option value="{{$item->stock->unit->id}}">{{$item->stock->unit->code}} - {{$item->stock->unit->name}}</option> --}}
                        @foreach ($unit as $unit)
                            <option value="{{$unit->id}}">{{$unit->code}} - {{$unit->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $item->name }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="condition">{{ __('Kondisi') }}<code>*</code></label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="condition" value="Baru" class="selectgroup-input" @if ($item->condition == 'Baru') checked="" @endif >
                          <span class="selectgroup-button">Baru</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="condition" value="Bekas" class="selectgroup-input" @if ($item->condition == 'Bekas') checked="" @endif >
                          <span class="selectgroup-button">Bekas</span>
                        </label>
                    </div>
                    @error('condition')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-12 col-md-4 col-lg-4">
                    <label for="warranty_id">{{ __('Garansi') }}<code>*</code></label>
                    <select class="select2" name="warranty_id" required>
                        <option value="{{$item->warranty->id}}">{{$item->warranty->periode}} {{$item->warranty->name}}</option>
                        @foreach ($warranty as $warranty)
                            <option value="{{$warranty->id}}">{{$warranty->periode}} {{$warranty->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 col-xs-12">
                    <label for="supplier_id">{{ __('Supplier') }}<code>*</code></label>
                    <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                        <option value="{{ $item->supplier->id }}">{{ $item->supplier->name }}</option>
                        @foreach ($supplier as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="description">{{ __('Keterangan') }}</label>
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description" value="{{ $item->description }}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                {{-- <div class="form-group col-md-2 col-xs-12">
                    <label for="image">{{ __('Gambar') }}</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Pilih Gambar</label>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="form-group col-12 col-md-12 col-lg-12">
                    <label for="image">{{ __('Ambil Foto') }}<code>*</code></label>
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
            <div class="row">
                <div class="form-group col-md-3 col-xs-12">
                    <label for="buy">{{ __('Harga Beli') }}<code>*</code></label>
                    <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp.
                            </div>
                          </div>
                          <input id="buy" type="text" class="form-control cleaveNumeral @error('buy') is-invalid @enderror"
                            name="buy" value="{{ $item->buy }}" required style="text-align: right">
                          @error('buy')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 col-xs-12">
                    <label for="sell">{{ __('Harga Jual') }}<code>*</code></label>
                    <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp.
                            </div>
                          </div>
                          <input id="sell" type="text" class="form-control cleaveNumeral @error('sell') is-invalid @enderror"
                            name="sell" value="{{ $item->sell }}" required style="text-align: right">
                          @error('sell')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 col-xs-12">
                    <label for="discount">{{ __('Diskon') }}</label>
                    <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp.
                            </div>
                          </div>
                          <input id="discount" type="text" class="form-control cleaveNumeral @error('discount') is-invalid @enderror"
                            name="discount" value="{{ $item->discount }}" style="text-align: right">
                          @error('discount')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
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
</div>
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
