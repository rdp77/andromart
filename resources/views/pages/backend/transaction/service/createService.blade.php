@extends('layouts.backend.default')
@section('title', __('pages.title').__('Tambah Service'))
@section('titleContent', __('Tambah Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Service') }}</div>
@endsection

@section('content')
<form method="POST" class="form-data" action="{{ route('users.store') }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <h4>Informasi </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                    <input id="code" type="text" class="form-control" readonly="" value="{{$code}}"
                        name="code"  >
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="date">{{ __('Tanggal Cair') }}<code>*</code></label>
                    <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                        name="date"  >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <div class="d-block">
                        <label for="technicianId" class="control-label">{{ __('Nama Teknisi') }}<code>*</code></label>
                    </div>
                    <select class="select2" name="technicianId">
                    <option value="">- Select -</option>
                    @foreach ($member as $element)
                        <option value="{{$element->id}}">{{$element->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="liquidDate">{{ __('Tanggal Cair') }}<code>*</code></label>
                    <input id="liquidDate" type="text" class="form-control datepickerFormatDFY"
                        name="liquidDate"  >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="total">{{ __('Total Pagu') }}<code>*</code></label>
                    <input id="total" type="text" class="form-control numberFormatCleave"
                        name="total"  >
                </div>
                <div class="form-group">
                    <label for="total">{{ __('Total Pagu') }}<code>*</code></label>
                    <input id="total" type="text" class="form-control numberFormatCleave"
                        name="total"  >
                </div>
                <div class="form-group">
                    <label for="total">{{ __('Total Pagu') }}<code>*</code></label>
                    <input id="total" type="text" class="form-control numberFormatCleave"
                        name="total"  >
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Data Detail</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                  <tbody>
                   <tr>
                    <th>Barang / Jasa</th>
                    <th>Harga</th>
                    <th>qty</th>
                    <th>Total</th>
                    <th>Deskripsi</th>
                    <th>tipe</th>
                    <th>Action</th>
                  </tr>
                  <tr>
                    <td>Jasa Service</td>
                    <td>300.000</td>
                    <td>1</td>
                    <td>300.000</td>
                    <td>Pemasangan dan penyolderan</td>
                    <td>Jasa</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>LCD 15 inch</td>
                    <td>700.000</td>
                    <td>1</td>
                    <td>700.000</td>
                    <td>LCD baru ini boss</td>
                    <td>Spare Part</td>
                    <td><a href="#" class="btn btn-danger">X</a></td>
                  </tr>
                  <tr>
                    <td>LCD 15 inch</td>
                    <td>700.000</td>
                    <td>1</td>
                    <td>700.000</td>
                    <td>Ga sengojo keplindes</td>
                    <td>Loss</td>
                    <td><a href="#" class="btn btn-danger">X</a></td>
                  </tr>
                </tbody></table>
              </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="save()"><i class="far fa-save"></i> {{ __('Simpan Data') }}</button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
@endsection