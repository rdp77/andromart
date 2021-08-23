@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Supplier'))
@section('titleContent', __('Edit Master Supplier'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Supplier') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Supplier') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('supplier.update',$supplier->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $supplier->name }}" required autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="address" class="control-label">{{ __('Alamat') }}<code>*</code></label>
                </div>
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                    value="{{ $supplier->address }}" required autofocus>
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="contact" class="control-label">{{ __('Kontak') }}<code>*</code></label>
                </div>
                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact"
                    value="{{ $supplier->contact }}" required autofocus>
                @error('contact')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
