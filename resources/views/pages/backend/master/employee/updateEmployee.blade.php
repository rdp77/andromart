@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Karyawan'))
@section('titleContent', __('Edit Master Karyawan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Karyawan') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Karyawan') }}</div>
@endsection

@section('content')
<form method="POST" action="{{ route('employee.update', $employee->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form method="POST" action="{{ route('employee.update', $employee->id) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="card-header">
                    <h4>Edit Profile</h4>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="branch_id">{{ __('Cabang') }}<code>*</code></label>
                            <select name="branch_id" id="branch_id" class="form-control select2" required>
                                <option value="{{ $employee->branch->id }}"> {{ $employee->branch->code }} - {{ $employee->branch->name }} </option>
                                @foreach ($branch as $branch)
                                <option value="{{ $branch->id }}"> {{ $branch->code }} - {{ $branch->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="role_id">{{ __('Pekerjaan') }}<code>*</code></label>
                            <select name="role_id" id="role_id" class="form-control select2" required>
                                <option value="{{ $employee->user->role->id }}"> {{ $employee->user->role->name }} </option>
                                @foreach ($role as $role)
                                <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1 col-xs-12">
                            <label for="level">{{ __('Level') }}<code>*</code></label>
                            <input id="level" type="text" class="form-control @error('level') is-invalid @enderror" name="level" value="{{ $employee->level }}" required>
                            @error('level')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="form-group col-md-3 col-xs-12">
                            <label for="status">{{ __('Status') }}<code>*</code></label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="aktif" class="selectgroup-input" @if ($employee->status == 'aktif') checked @endif>
                                    <span class="selectgroup-button">Aktif</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="nonaktif" class="selectgroup-input" @if ($employee->status == 'nonaktif') checked @endif>
                                    <span class="selectgroup-button">Non Aktif</span>
                                </label>
                            </div>
                        </div>
                      </div>
                    <div class="row">
                      <div class="form-group col-md-4 col-12">
                        <label for="identity">{{ __('NIK') }}<code>*</code></label>
                        <input type="text" class="form-control @error('identity') is-invalid @enderror" value="{{ $employee->identity }}" name="identity" required>
                        @error('identity')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                      <div class="form-group col-md-6 col-12">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                        <input type="text" class="form-control" value="{{ $employee->name }}" name="name" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-4 col-12">
                        <label for="birthday">{{ __('Tanggal Lahir') }}<code>*</code></label>
                        <input id="birthday" type="text" class="form-control datepicker" name="birthday"
                          value="{{ \Carbon\Carbon::parse($employee->birthday)->locale('id')->isoFormat('LL') }}">
                      </div>
                      <div class="form-group col-md-4 col-12">
                        <label for="gender">{{ __('Jenis Kelamin') }}<code>*</code></label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="gender" value="L" class="selectgroup-input" @if ($employee->gender ==
                            'L') checked="" @endif>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-male"></i></span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="gender" value="P" class="selectgroup-input" @if ($employee->gender ==
                            'P') checked="" @endif>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-female"></i></span>
                          </label>
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-xs-12">
                        <label for="avatar">{{ __('Avatar') }}</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="avatar" name="avatar">
                          <label class="custom-file-label" for="avatar">Pilih Gambar</label>
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
                          <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact"
                            value="0{{ $employee->contact }}" required>
                          @error('contact')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group col-md-7 col-12">
                        <label for="address">{{ __('Alamat') }}<code>*</code></label>
                        <input type="text" class="form-control" value="{{ $employee->address }}" name="address" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12 col-12">
                        <label for="limit">{{ __('LIMITASI') }}<code></code></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-phone"></i>
                            </div>
                          </div>
                          <input id="limit" type="text" class="form-control @error('limit') is-invalid @enderror" name="limit"
                            value="{{ $employee->limit }}" required>
                          @error('limit')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
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
</form>
@endsection
