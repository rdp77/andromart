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
@php use Illuminate\Support\Facades\Crypt; @endphp
<div class="card">
    <form action="{{ route('contents.update', Crypt::encryptString($content->id)) }}" method="POST" class="form-data" enctype="multipart/form-data">
                @csrf
                @method('PUT')
        <div class="card-body">
            <div class="row">
                @if($contentType->column_1 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="title" class="control-label">{{ __('Judul') }}<code>*</code></label>
                    </div>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $content->title }}" required autofocus/>
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
                    <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{ $content->subtitle }}" required autofocus/>
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
                    @if($contentType->id == 1)
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $content->description }}" required autofocus/>
                    @else
                    <textarea class="summernote @error('description') is-invalid @enderror" id="description" name="description">{{ $content->description }}</textarea>
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
                      <!-- <img class="img-fluid" src="{{ asset($content->image) }}"> -->
                      <input type="file" class="custom-file-input" id="image" name="image">
                      <input type="hidden" class="custom-file-input" id="image" name="imageBefore" value="{{ $content->image }}">
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
                <div class="form-group col-md-5 col-10">
                    <div class="d-block">
                        <label for="icon" class="control-label">{{ __('Ikon') }}<code>*</code></label>
                    </div>
                    <select class="form-control selectric" name="icon">
                    <!-- <select name='icon' class="selectpicker form-control" data-live-search="true"> -->
                    @foreach($icon as $row)
                        <!-- <option data-icon="{{ $row->icon }}" value="{{ $row->icon }}"> -->
                        @if($content->icon == $row->icon)
                        <option value="{{ $row->icon }}" selected onclick="Icon('{{ $row->icon }}');">{{ $row->icon }}</option>
                        @else
                        <option value="{{ $row->icon }}" onclick="Icon('{{ $row->icon }}');">{{ $row->icon }}</option>
                        @endif
                    @endforeach
                    </select>
                    <!-- <input id="icon" type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"  value="{{ $content->icon }}" required autofocus/> -->
                    @error('icon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-1 col-2" style="padding-top: 40px;">
                    <i id="showIcons" class="{{ $content->icon }}" style="font-size: 20px;"></i>
                </div>
                @endif
                @if($contentType->column_6 == 1)
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="url" class="control-label">{{ __('Url') }}<code>*</code></label>
                    </div>
                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url"  value="{{ $content->url }}" required autofocus/>
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
                    <input id="class" type="text" class="form-control @error('class') is-invalid @enderror" name="class" value="{{ $content->class }}" required autofocus/>
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
                        <option value="Left" <?php if($content->position == "Left"){ echo "selected"; } ?>>Kiri</option>
                        <option value="Right" <?php if($content->position == "Right"){ echo "selected"; } ?>>Kanan</option>
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
            <button class="btn btn-primary mr-1" type="submit">Ubah {{ $contentType->name }}</button>
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