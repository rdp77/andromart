@extends('layouts.backend.default')
@section('title', __('pages.title').__('Update Form Service'))
@section('titleContent', __('Update Form Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Update Form Service') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
@csrf
<section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-5">
          <h2 class="section-title">form </h2>
          <div class="card">
                <div class="card-body">
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <div class="d-block">
                            <label for="serviceId" class="control-label">{{ __('Service Code') }}<code>*</code></label>
                        </div>
                        <select class="select2 serviceId" name="serviceId" onchange="choseService()">
                        <option value="">- Select -</option>
                        @foreach ($data as $element)
                            <option value="{{$element->id}}">[{{$element->code}}] {{$element->customer_name}} - {{$element->Brand->name}} {{$element->Type->name}} <span><strong>( {{$element->work_status}} )</span></strong></option>
                        @endforeach
                        </select>
                    </div>
                    <div class="hiddenFormUpdate" style="display: none">
                        <br>
                        <h6 style="color: #6777ef">Update Status Pengerjaan</h6>
                        <br>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <div class="d-block">
                                <label for="status" class="control-label">{{ __('Status') }}<code>*</code></label>
                            </div>
                            <select class="select2 status" name="status" onchange="changeStatusService()">
                                <option selected value="">- Select -</option>
                                <option value="Proses">Proses</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Diambil">Sudah Diambil</option>
                                {{-- <option value="Batal">Batal</option> --}}
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-12 technicianFields" style="display: none">
                            <div class="d-block">
                                <label for="technicianId" class="control-label">{{ __('Teknisi') }}<code>*</code></label>
                            </div>
                            <select class="select2 technicianId" name="technicianId" >
                            <option value="">- Select -</option>
                            @foreach ($employee as $element)
                                <option value="{{$element->id}}">{{$element->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <label for="description">{{ __('Deskripsi') }}<code>*</code></label>
                            <input id="description" type="text" class="form-control description"
                                name="description"  >
                        </div>
                        <button class="btn btn-primary ml-3" type="button" onclick="updateStatusService()"><i class="far fa-save"></i> {{ __('Update Status') }}</button>
                    </div>
                </div>
            </div>
        </div>
      <div class="col-7">
          <h2 class="section-title">Tracking Service</h2>
          <div class="activities">
            
          </div>
      </div>
    </div>
  </section>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
@endsection