@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Area'))
@section('titleContent', __('Tambah Master Area'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Area') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Area') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('area.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="code">{{ __('Kode Area') }}<code>*</code></label>
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                    name="code" value="{{ old('code') }}" required autocomplete="code">
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
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
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
