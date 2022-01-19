@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Karyawan'))
@section('titleContent', __('Karyawan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Karyawan') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('employee.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Pengguna') }}</a>
    </div>
    <div class="row">
        @foreach ($employee as $index => $employee)
        <div class="col-lg-4">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                  <img alt="image" src="{{ $employee->getAvatar() }}" class="rounded-circle profile-widget-picture" style="height:100px">
                  <div class="profile-widget-items">
                    <div class="profile-widget-item">
                      {{-- <div class="profile-widget-item-label">Posts</div>
                      <div class="profile-widget-item-value">187</div> --}}
                      <div class="profile-widget-item-value">
                        @if ($employee->status == 'aktif')
                        <div class="badge badge-success">
                            Aktif
                        </div>
                        @else
                        <div class="badge badge-secondary">
                            Non Aktif
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                <div class="profile-widget-description">
                    <div class="profile-widget-name">
                        <i class="fa fa-user-astronaut"></i> &nbsp;&nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{ $employee->user->role->name }} {{ $employee->level }} - {{ $employee->branch->name }}
                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-user"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{ $employee->name }}
                        </div>
                    </div>

                    <div class="profile-widget-name">
                        <i class="fa fa-address-card"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{ $employee->identity }}
                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-restroom"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            @if ($employee->gender == 'L')
                                Pria
                            @elseif ($employee->gender == 'P')
                                Wanita
                            @endif
                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-birthday-cake"></i> &nbsp;&nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{ \Carbon\Carbon::parse($employee->birthday)->locale('id')->isoFormat('LL') }}
                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-mobile-alt"></i> &nbsp;&nbsp;&nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            0{{ $employee->contact }}
                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-home"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{ $employee->address }}
                        </div>
                    </div>
                    <div class="profile-widget-name text-right">
                        {{-- <a onclick="del({{$employee->id}})" class="btn btn-outline-danger btn-md" style="cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </a>
                        <span>&emsp;</span> --}}
                        <a href="{{ route('employee.edit', $employee->id)}}" class="btn btn-outline-primary btn-md">
                            <i class="fas fa-user-edit"></i>
                        </a>
                    </div>

                    {{-- <div class="profile-widget-name text-right">
                        <a href="{{ route('employee.edit', $employee->id)}}" class="btn btn-outline-primary btn-md">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div> --}}
                </div>

                <div class="card-footer">
                    <div class="profile-widget-name">
                        <i class="fa fa-times"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{$totalServiceCancel[$index]}}
                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-check"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{$totalServiceDone[$index]}}

                        </div>
                    </div>
                    <div class="profile-widget-name">
                        <i class="fa fa-list"></i> &nbsp;
                        <div class="text-muted d-inline font-weight-normal">
                            {{$totalServiceProgress[$index]}}

                        </div>
                    </div>
                </div>

            </div>

        </div>
        @endforeach
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/master/employeeScript.js') }}"></script>
@endsection
