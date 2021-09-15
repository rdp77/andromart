@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Presentase'))
@section('titleContent', __('Master Presentase'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Presentase') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Presentase') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-body">
        <div class="col-md-4">
            <label for="name" class="control-label col-md-8">{{ __('Nama') }}<code>*</code></label>
            <label for="total" class="control-label col-md-2 text-center">{{ __('Total') }}<code>*</code></label>
            <div class="row">
                @foreach ($presentase as $presentase)
                <form method="POST" action="{{ route('presentase.update',$presentase->id) }}" class="col-md-12">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input id="name" type="text" value="{{ $presentase->name }}" class="form-control col-md-8" name="name" readonly>
                        <input id="total" type="text" value="{{ $presentase->total }}" class="form-control col-md-2 text-center" name="total" required>
                        <button class="btn btn-md btn-outline-primary" type="submit">{{ __('Simpan') }}</button>
                    </div>
                </form>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        {{-- <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
        <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button> --}}
    </div>
</div>
@endsection
