@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ')."$contentType->name")
@section('titleContent', "$contentType->name")
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ $contentType->name }}</div>
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
    <form method="POST" action="{{ route('contentStores', Crypt::encryptString($contentType->id)) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                @if($contentType->column_1 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="title" class="control-label">{{ __('Judul') }}<code>*</code></label>
                    </div>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required autofocus/>
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
                @if($contentType->column_2 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="subtitle" class="control-label">{{ __('Sub Judul') }}<code>*</code></label>
                    </div>
                    <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" required/>
                    @error('subtitle')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
                @if($contentType->column_3 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="description" class="control-label">{{ __('Deskripsi') }}<code>*</code></label>
                    </div>
                    @if($contentType->id == 1 || $contentType->id == 34)
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required autofocus/>
                    @else
                    <textarea class="summernote @error('description') is-invalid @enderror" id="description" name="description"></textarea>
                    @endif
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
                @if($contentType->column_4 == 1)
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
                @endif
                @if($contentType->column_5 == 1)
                <div class="form-group col-md-4 col-10">
                    <div class="d-block">
                        <label for="icon" class="control-label">{{ __('Ikon') }}<code>*</code></label>
                    </div>

                    <select class="form-control selectric" name="icon">
                    <!-- <select name='icon' class="selectpicker form-control" data-live-search="true"> -->
                    @foreach($icon as $row)
                        <!-- <option data-icon="{{ $row->icon }}" value="{{ $row->icon }}"> -->
                        <option value="{{ $row->icon }}" onclick="Icon('{{ $row->icon }}');">
                            {{ $row->icon }}
                        </option>
                    @endforeach
                    </select>
                    <!-- <input id="icon" type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" required autofocus/> -->
                    @error('icon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-1 col-2" style="padding-top: 40px;">
                    <i id="showIcons" class="fas fa-ad" style="font-size: 20px;"></i>
                </div>
                @endif
                @if($contentType->column_6 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="url" class="control-label">{{ __('Url') }}<code>*</code></label>
                    </div>
                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" required/>
                    @error('url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
                @if($contentType->column_7 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="class" class="control-label">{{ __('Class') }}<code>*</code></label>
                    </div>
                    <input id="class" type="text" class="form-control @error('class') is-invalid @enderror" name="class" required autofocus/>
                    @error('class')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
                @if($contentType->column_8 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="position" class="control-label">{{ __('Posisi') }}<code>*</code></label>
                    </div>
                    <select class="form-control @error('position') is-invalid @enderror" name="position" id="position" required>
                        <option value="Left">Kiri</option>
                        <option value="Right">Kanan</option>
                    </select>
                    @error('position')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">Tambah {{ $contentType->name }}</button>
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