@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Garansi'))
@section('titleContent', __('Tambah Master Garansi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Garansi') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Garansi') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('warranty.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group col-md-2 col-xs-12">
                <label for="periode">{{ __('Periode') }}<code>*</code></label>
                <input id="periode" type="number" class="form-control @error('periode') is-invalid @enderror"
                    name="periode" value="{{ old('periode') }}" required placeholder="1 - 31" max="31" min="1" autofocus>
                @error('periode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-3 col-xs-12">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <select name="name" id="name" class="form-control select2" required>
                    <option value=""> - Select - </option>
                    <option value="Hari"> Hari </option>
                    <option value="Minggu"> Minggu </option>
                    <option value="Bulan"> Bulan </option>
                    <option value="Tahun"> Tahun </option>
                </select>
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
