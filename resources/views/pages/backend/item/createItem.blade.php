@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Barang'))
@section('titleContent', __('Tambah Barang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Barang') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Barang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('item.store') }}">
        @csrf
        <div class="card-body">
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
            </div>
            <div class="form-group">
                <label for="type">{{ __('Type') }}<code>*</code></label>
                <input id="type" type="text" class="form-control @error('type') is-invalid @enderror"
                    name="type" value="{{ old('type') }}" required autocomplete="type">
                @error('type')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="merk">{{ __('Merk') }}<code>*</code></label>
                <input id="merk" type="text" class="form-control @error('merk') is-invalid @enderror"
                    name="merk" value="{{ old('merk') }}" required autocomplete="merk">
                @error('merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">{{ __('Harga') }}<code>*</code></label>
                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror"
                    name="price" value="{{ old('price') }}" required autocomplete="price">
                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="total">{{ __('Total') }}<code>*</code></label>
                <input id="total" type="number" class="form-control @error('total') is-invalid @enderror"
                    name="total" value="{{ old('total') }}" required autocomplete="total">
                @error('total')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="info">{{ __('Info') }}<code>*</code></label>
                <input id="info" type="text" class="form-control @error('info') is-invalid @enderror"
                    name="info" value="{{ old('info') }}" required autocomplete="info">
                @error('info')
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