@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Brand'))
@section('titleContent', __('Tambah Master Brand'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Brand') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Brand') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('brand.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group col-md-4 col-xs-12">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    required autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah Data Master') }}</button>
        </div>
    </form>
</div>
@endsection
