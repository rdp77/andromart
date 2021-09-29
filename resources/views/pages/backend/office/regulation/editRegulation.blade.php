@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Peraturan'))
@section('titleContent', __('Edit Peraturan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Peraturan') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Peraturan') }}</div>
@endsection
@push('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endpush
@section('content')
<div class="card">
    <form method="POST" action="{{ route('regulation.update', $model->id) }}" enctype="multipart/form-data" class="form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group col-md-6 col-xs-12">
                <div class="d-block">
                    <label for="titles" class="control-label">{{ __('Judul') }}<code>*</code></label>
                </div>
                <input id="titles" type="text" class="form-control @error('titles') is-invalid @enderror" name="titles" value="{{ $model->title }}"
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
                    @if($row->id == $model->branch_id)
                    <option value="{{ $row->id }}" selected>
                        {{ $row->name }}
                    </option>
                    @else
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                    @endif
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
                    @if($row->id == $model->role_id)
                    <option value="{{ $row->id }}" selected>
                        {{ $row->name }}
                    </option>
                    @else
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                    @endif
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
                <textarea class="summernote @error('description') is-invalid @enderror" id="description" name="description">{{ $model->description }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <div class="d-block">
                    <label for="subtitle" class="control-label">{{ __('Tambah File') }}<code>*</code></label>
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
            <div class="row">
                @foreach($models as $row)
                    @php $ext = substr($row->file,-3); @endphp
                    @if($ext == 'jpg' || $ext == 'png' || $ext == 'peg')
                        <div class="col-2">
                            <center><a href="{{ asset($row->file) }}" target="_blank"><img alt="image" src="{{ asset($row->file) }}" style="width: 100px; height: 100px; object-fit: cover;"></a>
                            <br />
                            <a href="/office/regulation/delete-detail/{{ $model->id }}/{{ $row->id }}" class="btn btn-danger mr-1">Delete</a></center>
                        </div>
                    @else
                        <div class="col-2">
                            <center><a href="{{ asset($row->file) }}" target="_blank"><i class="fas fa-file-alt" style="font-size: 100px;"></i></a>
                            <br />
                            <a href="/office/regulation/delete-detail/{{ $model->id }}/{{ $row->id }}" class="btn btn-danger mr-1">Delete</a></center>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('Edit Peraturan') }}</button>
        </div>
    </form>
</div>
@endsection
