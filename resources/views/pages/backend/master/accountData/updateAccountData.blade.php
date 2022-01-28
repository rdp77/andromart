@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Akun Data'))
@section('titleContent', __('Edit Master Akun Data'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Akun Data') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Akun Data') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<div class="card">
    <form method="POST" action="{{ route('account-data.update',$accountData->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <label for="branch_id">{{ __('Cabang') }}<code>*</code></label>
                    <select name="branch_id" id="branch_id" class="form-control select2" required>
                        @foreach ($branch as $branch)
                        <option value="{{ $branch->id }}" @if ($branch->id == $accountData->branch_id) selected @endif>
                            {{ $branch->code }} - {{ $branch->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="account_detail_id">{{ __('Detail Akun') }}<code>*</code></label>
                    <select name="account_detail_id" id="account_detail_id" class="form-control select2" required>
                        @foreach ($accountMainDetail as $accountMainDetail)
                        <option value="{{ $accountMainDetail->id }}" @if($accountMainDetail->id == $accountData->main_detail_id) selected @endif>
                            {{ $accountMainDetail->code }} - {{ $accountMainDetail->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-xs-12">
                    <label for="name" class="control-label">{{ __('Nama') }}</label><code>*</code>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $accountData->name }}" required>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="email" class="control-label">{{ __('Opening Balance') }}</label><code>*</code>
                    <input id="opening_balance" type="number" class="form-control opening_balance" name="opening_balance" min="0" value="{{ $accountData->opening_balance }}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Debet Kredit') }}<code>*</code></label>
                    <select name="debet_kredit" class="select2" required>
                        <option value="">- Select -</option>
                        <option value="D" @if ($accountData->debet_kredit == 'D') selected @endif>Debet</option>
                        <option value="K" @if ($accountData->debet_kredit == 'K') selected @endif>Kredit</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Status') }}<code>*</code></label>
                    <select name="active" class="select2" required>
                        <option value="">- Select -</option>
                        <option value="Y" @if ($accountData->active == 'Y') selected @endif>Aktif</option>
                        <option value="N" @if ($accountData->active == 'N') selected @endif>Non Aktif</option>
                    </select>
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
