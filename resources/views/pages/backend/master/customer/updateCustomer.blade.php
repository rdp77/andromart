@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Pelanggan'))
@section('titleContent', __('Edit Master Pelanggan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Pelanggan') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Pelanggan') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('customer.update',$customer->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <label for="branch_id">{{ __('Cabang') }}<code>*</code></label>
                    <select name="branch_id" id="branch_id" class="form-control select2" required>
                        <option value="{{ $customer->branch->id }}"> {{ $customer->branch->code }} - {{ $customer->branch->name }} </option>
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
                    <input id="name" type="text" value="{{ $customer->name }}" class="form-control @error('name') is-invalid @enderror" name="name"
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
                    <input id="identity" type="text" value="{{ $customer->identity }}" class="form-control @error('identity') is-invalid @enderror" name="identity"
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
                            name="contact" value="{{ $customer->contact }}" required>
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
                        name="address" value="{{ $customer->address }}" required>
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
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
