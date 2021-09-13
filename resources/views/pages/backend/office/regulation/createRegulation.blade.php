@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Peraturan'))
@section('titleContent', __('Tambah Peraturan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Peraturan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Peraturan') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('regulation.store') }}" enctype="multipart/form-data" class="form-data">
        @csrf
        <div class="card-body">
            <div class="form-group col-md-6 col-xs-12">
                <div class="d-block">
                    <label for="titles" class="control-label">{{ __('Judul') }}<code>*</code></label>
                </div>
                <input id="titles" type="text" class="form-control @error('titles') is-invalid @enderror" name="titles"
                    required autofocus>
                @error('titles')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <div class="d-block">
                    <label for="branch" class="control-label">{{ __('Cabang') }}<code>*</code></label>
                </div>

                <select class="form-control selectric" name="branch">
                @foreach($branch as $row)
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                @endforeach
                </select>
                @error('branch')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <div class="d-block">
                    <label for="role" class="control-label">{{ __('Untuk Bagian') }}<code>*</code></label>
                </div>

                <select class="form-control selectric" name="role">
                @foreach($role as $row)
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                @endforeach
                </select>
                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12 col-xs-12">
                <label for="description">{{ __('Deskripsi') }}<code>*</code></label>
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                    name="description" autofocus>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <div class="d-block">
                    <label for="subtitle" class="control-label">{{ __('File') }}<code>*</code></label>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="file" name="file[]" multiple>
                  <!-- <input type="file" name="photo" class="custom-file-input"> -->
                  <label class="custom-file-label">Pilih File</label>
                </div>
                @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah Peraturan') }}</button>
        </div>
    </form>
</div>
@endsection
