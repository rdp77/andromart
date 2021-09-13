@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | User Profile'))
@section('titleContent', __('User Profile'))
@section('breadcrumb', __('Dashboard'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('User Profile') }}</div>
@endsection

@section('content')
  <div class="section-body">
    <h2 class="section-title">Hi, {{ $user->username }}</h2>
    <p class="section-lead">
      This page describe about yourself.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Posts</div>
                <div class="profile-widget-item-value">187</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Followers</div>
                <div class="profile-widget-item-value">6,8K</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Following</div>
                <div class="profile-widget-item-value">2,1K</div>
              </div>
            </div>
          </div>

          <div class="profile-widget-description">
            <div class="profile-widget-name"> {{ $user->name }}
                <div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div> {{ $user->employee->level }}</div>
                </div>
          </div>
          <div class="card-footer text-center">
            <div class="font-weight-bold mb-2">Follow {{ $user->name }} On</div>
            <a href="#" class="btn btn-lg">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="btn btn-lg">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-lg">
              <i class="fab fa-github"></i>
            </a>
            <a href="#" class="btn btn-lg">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="card-header">
              <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-4 col-12">
                    <label for="identity">{{ __('NIK') }}<code>*</code></label>
                    <input type="text" class="form-control" value="{{ $user->employee->identity }}" name="identity">
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    <input type="text" class="form-control" value="{{ $user->employee->name }}" name="name">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-4 col-12">
                    <label for="birthday">{{ __('Tanggal Lahir') }}<code>*</code></label>
                    <input id="birthday" type="text" class="form-control datepicker" name="birthday" value="{{ $user->employee->birthday }}">
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label for="gender">{{ __('Jenis Kelamin') }}<code>*</code></label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="gender" value="L" class="selectgroup-input" @if ($user->employee->gender == 'L') checked="" @endif>
                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-male"></i></span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="gender" value="P" class="selectgroup-input" @if ($user->employee->gender == 'P') checked="" @endif>
                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-female"></i></span>
                            </label>
                        </div>
                  </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-5 col-12">
                        <label for="contact">{{ __('Kontak') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </div>
                            <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror"
                                name="contact" value="0{{ $user->employee->contact }}" required autocomplete="contact">
                            @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-7 col-12">
                        <label for="address">{{ __('Alamat') }}<code>*</code></label>
                        <input type="text" class="form-control" value="{{ $user->employee->address }}" name="address">
                        <div class="invalid-feedback">
                          Please fill in the first name
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
