@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Supplier'))
@section('titleContent', __('Tambah Master Supplier'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Supplier') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Supplier') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('supplier.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" name="name"
                    required autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">{{ __('Alamat') }}<code>*</code></label>
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                    name="address" value="{{ old('address') }}" required autocomplete="address">
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="contact">{{ __('Kontak') }}<code>*</code></label>
                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror"
                    name="contact" value="{{ old('contact') }}" required autocomplete="contact">
                @error('contact')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
