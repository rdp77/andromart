@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ')."Tambah Type Product")
@section('titleContent', "Tambah Type Product")
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">Tambah Type Product</div>
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
    <form method="POST" action="{{ route('type-product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
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
                        <label for="description" class="control-label">{{ __('Deskripsi') }}<code>*</code></label>
                    </div>
                    <textarea class="summernote @error('description') is-invalid @enderror" id="description" name="description"></textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">Tambah Type Product</button>
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