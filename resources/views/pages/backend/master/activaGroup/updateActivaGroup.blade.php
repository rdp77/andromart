@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Golongan Akun'))
@section('titleContent', __('Edit Master Golongan Akun'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Golongan Akun') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Golongan Akun') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<div class="card">
    <form method="POST" action="{{ route('activa-group.update', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12 col-xs-12">
                    <label for="email" class="control-label">{{ __('Nama') }}</label><code>*</code>
                    <input id="name" type="text" value="{{$data->name}}" class="form-control" name="name" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="email" class="control-label">{{ __('Estimasi Umur (TH)') }}</label><code>*</code>
                    <input id="estimate_age" type="number" class="form-control" name="estimate_age" required onkeyup="calc()" placeholder="0" value="{{$data->estimate_age}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="email" class="control-label">{{ __('Persentase Penyusutan') }}</label><code>*</code>
                    <input id="depreciation_rate" type="text" class="form-control" name="depreciation_rate" readonly placeholder="100.00" value="{{$data->depreciation_rate}}">
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
@section('script')
<script src="{{ asset('assets/pages/master/activaGroupScript.js') }}"></script>
@endsection