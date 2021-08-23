@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Kategori'))
@section('titleContent', __('Edit Master Kategori'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Kategori') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Kategori') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('category.update',$category->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="code" class="control-label">{{ __('Kode') }}<code>*</code></label>
                </div>
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                    value="{{ $category->code }}" required autofocus>
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
                    value="{{ $category->name }}" required autofocus>
                @error('name')
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
