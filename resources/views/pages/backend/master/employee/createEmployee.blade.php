@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Master Karyawan'))
@section('titleContent', __('Tambah Master Karyawan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Karyawan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Master Karyawan') }}</div>
@endsection

@section('content')
<form method="POST" action="{{ route('employee.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Form Pengguna</h4>
                </div>
                <div class="card-body">
                        <div class="form-group col-md-8">
                            <label for="username">{{ __('Username') }}<code>*</code></label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ old('username') }}" required autocomplete="username">
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label for="password">{{ __('Password') }}<code>* Ganti password anda pada halaman profil</code></label>
                            <input id="password" type="text" class="form-control @error('password') is-invalid @enderror"
                                name="password" value="andromart" autocomplete="password" placeholder="andromart" readonly>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    {{-- <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">{{ __('Password') }}<code>*</code></label>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="control-label">{{ __('Ulangi Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                            autocomplete="new-password">
                    </div> --}}

                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4>Form Data Karyawan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="branch_id">{{ __('Cabang') }}<code>*</code></label>
                            <select name="branch_id" id="branch_id" class="form-control select2" required autocomplete="branch_id">
                                <option value=""> - Select - </option>
                                @foreach ($branch as $branch)
                                <option value="{{ $branch->id }}"> {{ $branch->code }} - {{ $branch->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="level">{{ __('Pekerjaan') }}<code>*</code></label>
                            <select name="level" id="level" class="form-control select2" required autocomplete="level">
                                <option value=""> - Select - </option>
                                <option value="Owner"> Owner </option>
                                <option value="Admin"> Admin / Kasir </option>
                                <option value="Teknisi">  Teknisi </option>
                                <option value="Sales">  Sales / Support </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="identity">{{ __('NIK') }}<code>*</code></label>
                            <input id="identity" type="text" class="form-control @error('identity') is-invalid @enderror"
                                name="identity" value="{{ old('identity') }}" required autocomplete="identity">
                            @error('identity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-7">
                            <div class="d-block">
                                <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                            </div>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                required autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="birthday">{{ __('Tanggal Lahir') }}<code>*</code></label>
                            <input id="birthday" type="text" class="form-control datepicker" name="birthday">
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="gender">{{ __('Jenis Kelamin') }}<code>*</code></label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="gender" value="L" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-male"></i></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="gender" value="P" class="selectgroup-input">
                                    <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-female"></i></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 col-xs-12">
                            <label for="contact">{{ __('Kontak') }}<code>*</code></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </div>
                                </div>
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror"
                                    name="contact" value="{{ old('contact') }}" required autocomplete="contact">
                                @error('contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-7 col-xs-12">
                            <label for="address">{{ __('Alamat') }}<code>*</code></label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" value="{{ old('address') }}" required autocomplete="address">
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
                    <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah Data Master') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
