@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Cabang'))
@section('titleContent', __('Edit Master Cabang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Cabang') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Cabang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('branch.update',$branch->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="code">{{ __('Kode Area') }}<code>*</code></label>
                <select name="area_id" id="area_id" class="form-control select2" required autocomplete="area_id">
                    <option value="{{ $branch->area->id }}" disabled> {{ $branch->area->code }} -- {{ $branch->area->name }} </option>
                    @foreach ($area as $area)
                    <option value="{{ $area->id }}"> {{ $area->code }} -- {{ $area->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="code" class="control-label">{{ __('Kode Cabang') }}<code>*</code></label>
                </div>
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                    value="{{ $branch->code }}" required autofocus>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $branch->name }}" required autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label for="address" class="control-label">{{ __('Alamat Cabang') }}<code>*</code></label>
                </div>
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                    value="{{ $branch->address }}" required autofocus>
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
