@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Pelanggan'))
@section('titleContent', __('Tambah Master Pelanggan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Pelanggan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Pelanggan') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('customer.store') }}">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <label for="branch_id">{{ __('Cabang') }}<code>*</code></label>
                    <select name="branch_id" id="branch_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($branch as $branch)
                        <option value="{{ $branch->id }}"> {{ $branch->code }} - {{ $branch->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" name="name"
                        required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <div class="d-block">
                        <label for="identity" class="control-label">{{ __('NIK') }}<code>*</code></label>
                    </div>
                    <input id="identity" type="text" value="{{ old('identity') }}" class="form-control @error('identity') is-invalid @enderror" name="identity"
                        required>
                    @error('identity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <label for="contact">{{ __('Kontak') }}<code>*</code></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror"
                            name="contact" value="{{ old('contact') }}" required>
                        @error('contact')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="address">{{ __('Alamat') }}<code>*</code></label>
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                        name="address" value="{{ old('address') }}" required>
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
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
