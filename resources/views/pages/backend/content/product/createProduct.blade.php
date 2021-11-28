@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ')."Tambah Product")
@section('titleContent', "Tambah Product")
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">Tambah Product</div>
@endsection
@push('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <!-- new css -->
    <link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" rel="stylesheet" />
@endpush
@section('content')
<div class="card">
    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}"/>
        <div class="card-body">
            <div class="row">
                <input type="hidden" name="type_products_id" value="{{ $id }}"/>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Name') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus/>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="subtitle" class="control-label">{{ __('Gambar') }}<code>*</code></label>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="image" name="image" required>
                      <!-- <input type="file" name="photo" class="custom-file-input"> -->
                      <label class="custom-file-label">Pilih Gambar</label>
                    </div>
                    @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="prize" class="control-label">{{ __('Harga') }}<code>*</code></label>
                    </div>
                    <input id="prize" type="number" class="form-control @error('prize') is-invalid @enderror" name="prize" required autofocus/>
                    @error('prize')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="discount" class="control-label">{{ __('Diskon') }}<code>*</code></label>
                    </div>
                    <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" autofocus/>
                    @error('discount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-12 col-xs-12">
                    <label class="form-label">Apa ini termasuk produk hot item?</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="hot_item" value="1"
                                class="selectgroup-input">
                            <span class="selectgroup-button"><i class="fas fa-check"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="hot_item" value="0" checked
                                class="selectgroup-input">
                            <span class="selectgroup-button"><i class="fas fa-times"></i></span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="description" class="control-label">{{ __('Deskripsi') }}<code>*</code></label>
                    </div>
                    <textarea class="summernote @error('description') is-invalid @enderror" id="description" name="description"></textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="detail" class="control-label">{{ __('Detail') }}<code>*</code></label>
                    </div>
                    <textarea class="summernote @error('detail') is-invalid @enderror" id="detail" name="detail"></textarea>
                    @error('detail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4>Link Onlineshop</h4>
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="tokopedia" class="control-label">{{ __('Tokopedia') }}<code>*</code></label>
                    </div>
                    <input id="tokopedia" type="text" class="form-control @error('tokopedia') is-invalid @enderror" name="tokopedia" autofocus/>
                    @error('tokopedia')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="shopee" class="control-label">{{ __('Shopee') }}<code>*</code></label>
                    </div>
                    <input id="shopee" type="text" class="form-control @error('shopee') is-invalid @enderror" name="shopee" autofocus/>
                    @error('shopee')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="lazada" class="control-label">{{ __('Lazada') }}<code>*</code></label>
                    </div>
                    <input id="lazada" type="text" class="form-control @error('lazada') is-invalid @enderror" name="lazada" autofocus/>
                    @error('lazada')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="bukalapak" class="control-label">{{ __('Bukalapak') }}<code>*</code></label>
                    </div>
                    <input id="bukalapak" type="text" class="form-control @error('bukalapak') is-invalid @enderror" name="bukalapak" autofocus/>
                    @error('bukalapak')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="olx" class="control-label">{{ __('Olx') }}<code>*</code></label>
                    </div>
                    <input id="olx" type="text" class="form-control @error('olx') is-invalid @enderror" name="olx" autofocus/>
                    @error('olx')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="blibli" class="control-label">{{ __('Bli-bli') }}<code>*</code></label>
                    </div>
                    <input id="blibli" type="text" class="form-control @error('blibli') is-invalid @enderror" name="blibli" autofocus/>
                    @error('blibli')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="jd" class="control-label">{{ __('JD.Id') }}<code>*</code></label>
                    </div>
                    <input id="jd" type="text" class="form-control @error('jd') is-invalid @enderror" name="jd" autofocus/>
                    @error('jd')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="bhinneka" class="control-label">{{ __('Bhinneka') }}<code>*</code></label>
                    </div>
                    <input id="bhinneka" type="text" class="form-control @error('bhinneka') is-invalid @enderror" name="bhinneka" autofocus/>
                    @error('bhinneka')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">Tambah Product</button>
        </div>
    </form>
</div>
@endsection
@push('custom-js')
<script type="text/javascript">
    function Icon(icons) {
        var element = document.getElementById("showIcons");
        element.className = icons;
    }
</script>
@endpush