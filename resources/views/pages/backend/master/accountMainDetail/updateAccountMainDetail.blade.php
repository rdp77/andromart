@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Akun Detail'))
@section('titleContent', __('Edit Master Akun Detail'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Akun Detail') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Akun Detail') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('account-main-detail.update',$detail->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-3 col-xs-12">
                    <label for="main_id">{{ __('Kode') }}<code>*</code></label>
                    <select class="form-control select2" name="main_id" id="main_id" required>
                        <option value=""> - Select - </option>
                        @foreach ($main as $main)
                        <option value="{{ $main->id}}" @if ($detail->main_id == $main->id) selected @endif> {{ $main->code }} - {{ $main->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2 col-xs-12">
                    <label for="code">{{ __('Kode') }}<code>*</code></label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                        name="code" value="{{ $detail->code }}" required>
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $detail->name }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
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
