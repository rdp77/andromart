@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Asset'))
@section('titleContent', __('Tambah Master Asset'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Asset') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Asset') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('asset.store') }}">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12 col-xs-12">
                    <label for="email" class="control-label">{{ __('Nama') }}</label><code>*</code>
                    <input id="name" type="text" class="form-control" name="name" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Akun Penyusutan') }}<code>*</code></label>
                    <select name="account_depreciation_id" id="account_depreciation_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($AccountMainDetail as $el)
                        <option value="{{ $el->id }}"> {{ $el->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Akun Akumulasi') }}<code>*</code></label>
                    <select name="account_accumulation_id" id="account_accumulation_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($AccountMainDetail as $el)
                        <option value="{{ $el->id }}"> {{ $el->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 col-xs-12">
                    <label for="email" class="control-label">{{ __('Deskripsi') }}</label><code>*</code>
                    <input id="description" type="text" class="form-control" name="description" required>
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
