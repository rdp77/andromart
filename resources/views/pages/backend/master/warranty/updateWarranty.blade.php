@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Garansi'))
@section('titleContent', __('Edit Master Garansi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Garansi') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Garansi') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('warranty.update',$warranty->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group col-md-2 col-xs-12">
                <div class="d-block">
                    <label for="periode" class="control-label">{{ __('Periode') }}<code>*</code></label>
                </div>
                <input id="periode" type="number" class="form-control @error('periode') is-invalid @enderror" name="periode"
                    value="{{ $warranty->periode }}" required autofocus>
                @error('periode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <select name="name" id="name" class="form-control select2" required>
                    <option value="Hari" @if ($warranty->name == 'Hari') selected @endif> Hari </option>
                    <option value="Minggu" @if ($warranty->name == 'Minggu') selected @endif> Minggu </option>
                    <option value="Bulan" @if ($warranty->name == 'Bulan') selected @endif> Bulan </option>
                    <option value="Tahun" @if ($warranty->name == 'Tahun') selected @endif> Tahun </option>
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
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
