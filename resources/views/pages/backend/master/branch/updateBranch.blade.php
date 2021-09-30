@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Cabang'))
@section('titleContent', __('Edit Master Cabang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Cabang') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Cabang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('branch.update',$branch->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $branch->name }}" required autofocus>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="title">{{ __('Nama Lain') }}</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ $branch->title }}">
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
                        <option value="{{ $branch->area->id }}"> {{ $branch->area->code }} - {{ $branch->area->name }} </option>
                        @foreach ($area as $area)
                        <option value="{{ $area->id }}"> {{ $area->code }} - {{ $area->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="code">{{ __('Kode Cabang') }}<code>*</code></label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                        name="code" value="{{ $branch->code }}" required>
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
                        <input id="phone" type="text" class="form-control phone-number @error('phone') is-invalid @enderror" name="phone"
                            value="{{ $branch->phone }}" required>
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
                        <input id="email" type="email" class="form-control email @error('email') is-invalid @enderror" name="email"
                            value="{{ $branch->email }}">
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
                        value="{{ $branch->address }}" required>
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
                        <input type="text" class="form-control" id="input-lat" name="latitude" value="{{ $branch->latitude }}"
                        @if ($branch->latitude == null)
                            placeholder ="Latitude"
                        @endif >
                        <input type="text" class="form-control" id="input-lng" name="longitude" value="{{ $branch->longitude }}"
                        @if ($branch->longitude == null)
                            placeholder ="Longitude"
                        @endif >
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
