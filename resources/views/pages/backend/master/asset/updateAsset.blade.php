@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Asset'))
@section('titleContent', __('Edit Master Asset'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Asset') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Asset') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<div class="card">
    <form method="POST" action="{{ route('asset.update', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12 col-xs-12">
                    <label for="email" class="control-label">{{ __('Nama') }}</label><code>*</code>
                    <input id="name" type="text" class="form-control" name="name" value="{{$data->name}}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Akun Penyusutan') }}<code>*</code></label>
                    <select name="account_depreciation_id" id="account_depreciation_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($AccountMainDetail as $el)
                        <option value="{{ $el->id }}" @if ($data->account_depreciation_id == $el->id)
                            selected
                        @endif> {{ $el->code }} - {{ $el->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="address" class="control-label">{{ __('Akun Akumulasi') }}<code>*</code></label>
                    <select name="account_accumulation_id" id="account_accumulation_id" class="form-control select2" required>
                        <option value=""> - Select - </option>
                        @foreach ($AccountMainDetail as $el)
                        <option value="{{ $el->id }}" @if ($data->account_accumulation_id == $el->id)
                            selected
                        @endif> {{ $el->code }} - {{ $el->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 col-xs-12">
                    <label for="email" class="control-label">{{ __('Deskripsi') }}</label><code>*</code>
                    <input id="description" type="text" class="form-control" value="{{$data->description}}" name="description" required>
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
