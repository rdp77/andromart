@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Role'))
@section('titleContent', __('Master Role'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Role') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
<form action="" method="POST" class="form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('role.create') }}" class="btn btn-icon icon-left btn-primary">
                        <i class="far fa-edit"></i>{{ __(' Tambah Role') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" width="50%">
                        <tr>
                            <td width="5%">Level</td>
                            <td width="30%">
                                <select class="select2 PaymentMethod">
                                    <option value="">{{ __('- Select -') }}</option>
                                    @foreach ($role as $role)
                                        <option value="">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {{-- <button class="btn btn-primary mr-1" type="button">Tambah Role</button> --}}
                                <a href="{{ route('role.create') }}" class="btn btn-primary mr-1">{{ __(' Tambah Role') }}</a>
                                <button class="btn btn-primary mr-1" type="button">Hapus Role</button>
                                <button class="btn btn-primary mr-1" type="button">Simpan Perubahan</button>
                            </td>
                        </tr>
                    </table>
                    <table class="table-striped table" id="table" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">
                                    {{ __('NO') }}
                                </th>
                                <th class="text-center">{{ __('Menu') }}</th>
                                <th class="text-center">{{ __('Aktif') }}</th>
                                <th class="text-center">{{ __('Tambah') }}</th>
                                <th class="text-center">{{ __('Ubah') }}</th>
                                <th class="text-center">{{ __('Hapus') }}</th>
                                <th class="text-center">{{ __('Cabang') }}</th>
                                {{-- <th>{{ __('Print') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Hak Akses - Setting</td>
                                <td class="text-center">
                                    <div class="form-group">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                      </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
{{-- <script src="{{ asset('assets/pages/master/roleScript.js') }}"></script> --}}
@endsection
