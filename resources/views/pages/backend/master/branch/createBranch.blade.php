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
            <div class="form-group">
                <label for="area_id">{{ __('Kode Area') }}<code>*</code></label>
                <select name="area_id" id="area_id" class="form-control select2" required autocomplete="area_id">
                    @foreach ($area as $area)
                    <option value="{{ $area->id }}"> {{ $area->code }} -- {{ $area->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="code">{{ __('Kode Cabang') }}<code>*</code></label>
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
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="address" class="control-label">{{ __('Alamat Cabang') }}<code>*</code></label>
                </div>
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                    required autofocus>
                @error('address')
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
