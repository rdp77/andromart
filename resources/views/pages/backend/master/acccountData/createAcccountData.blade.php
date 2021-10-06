@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Cabang'))
@section('titleContent', __('Tambah Master Cabang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Cabang') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Cabang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('branch.store') }}">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
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
                <div class="form-group col-md-6 col-xs-12">
                    <label for="title">{{ __('Nama Lain') }}</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ old('title') }}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <label for="area_id">{{ __('Kode Area') }}<code>*</code></label>
                    <select name="area_id" id="area_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($area as $area)
                        <option value="{{ $area->id }}"> {{ $area->code }} - {{ $area->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="code">{{ __('Kode Cabang') }}<code>*</code></label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                        name="code" value="{{ old('code') }}" required>
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="phone" class="control-label">{{ __('Kontak') }}<code>*</code></label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input id="phone" type="text" class="form-control phone-number @error('phone') is-invalid @enderror" name="phone" required>
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="email" class="control-label">{{ __('Email') }}</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-at"></i>
                          </div>
                        </div>
                        <input id="email" type="email" class="form-control email @error('email') is-invalid @enderror" name="email">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <div class="d-block">
                        <label for="address" class="control-label">{{ __('Alamat Cabang') }}<code>*</code></label>
                    </div>
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                        required>
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <div class="d-block">
                        <label for="latitude" class="control-label">{{ __('Koordinat') }}</label>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" id="input-lat" name="latitude" placeholder="Latitude">
                        <input type="text" class="form-control" id="input-lng" name="longitude" placeholder="Longitude">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah Data Master') }}</button>
        </div>
    </form>
</div>
@endsection
