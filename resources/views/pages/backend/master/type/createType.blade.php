@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Tipe'))
@section('titleContent', __('Tambah Master Tipe'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Tipe') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Tipe') }}</div>
@endsection

@section('content')
{{-- @if (count($errors) > 0) --}}
<div class="alert alert-danger alert-has-icon">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <div class="alert-title">{{ __('Error') }}</div>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
</div>
{{-- @endif --}}
<div class="card">
    <form method="POST" action="{{ route('type.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group col-md-3 col-xs-12">
                <label for="brand_id">{{ __('Merk') }}<code>*</code></label>
                <select name="brand_id" id="brand_id" class="form-control select2" required>
                    <option value=""> - Select - </option>
                    @foreach ($brand as $brand)
                    <option value="{{ $brand->id }}"> {{ $brand->category->code }} - {{ $brand->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    required>
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