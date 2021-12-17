@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Ganti Password'))
@section('titleContent', __('Ganti Password'))
@section('breadcrumb', __('Dashboard'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Ganti Password') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('changePassword') }}">
        @csrf
        @method('post')
        <div class="card-body">
            @if (Session::has('type1'))
            <div class="alert alert-danger alert-has-icon">
                <div class="alert-icon"><i class="fas fa-times"></i></div>
                <div class="alert-body">
                    <div class="alert-title">{{ __('Error') }}</div>
                    {{ Session::get('status') }}
                </div>
            </div>
            @endif
            @if (Session::has('type2'))
            <div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">{{ __('Success') }}</div>
                    {{ Session::get('status') }}
                </div>
            </div>
            {{-- @else --}}
            @endif
            <div class="row">
                <div class="form-group col-md-3">
                    <label>{{ __('Username') }}</label><code>*</code>
                    <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                        value="{{ Auth::user()->username }}" name="username" autofocus disabled>
                    @error('username')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>{{ __('Password lama') }}</label><code>*</code>
                    <input id="oldPassword" type="password" class="form-control @error('oldPassword') is-invalid @enderror"
                        name="oldPassword" required>
                    @error('oldPassword')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>{{ __('Password Baru') }}</label><code>*</code>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('Ganti Password') }}</button>
        </div>
    </form>
</div>
@endsection
