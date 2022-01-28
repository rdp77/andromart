@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Akun Data'))
@section('titleContent', __('Tambah Master Akun Data'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Akun Data') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Akun Data') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('account-data.store') }}">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <label for="area_id">{{ __('Cabang') }}<code>*</code></label>
                    <select name="branch_id" id="branch_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($Branch as $el)
                        <option value="{{ $el->id }}"> {{ $el->code }} - {{ $el->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="area_id">{{ __('Detail Akun') }}<code>*</code></label>
                    <select name="account_detail_id" id="account_detail_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($AccountMainDetail as $el)
                        <option value="{{ $el->id }}"> {{ $el->code }} - {{ $el->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <label for="email" class="control-label">{{ __('Nama') }}</label><code>*</code>
                    <input id="name" type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="email" class="control-label">{{ __('Opening Balance') }}</label><code>*</code>
                    <input id="opening_balance" type="number" class="form-control opening_balance" name="opening_balance" min="0" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Debet Kredit') }}<code>*</code></label>
                    <select name="debet_kredit" class="select2" required>
                        <option value="">- Select -</option>
                        <option value="D">Debet</option>
                        <option value="K">Kredit</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Status') }}<code>*</code></label>
                    <select name="active" class="select2" required>
                        <option value="">- Select -</option>
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
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
