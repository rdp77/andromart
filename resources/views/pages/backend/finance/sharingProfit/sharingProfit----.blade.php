@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Sharing Profit'))
@section('titleContent', __('Sharing Profit'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Sharing Profit') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
<form class="form-data">
    @csrf
    <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-5">
          <h2 class="section-title">Form </h2>
          <div class="card">
                <div class="card-body">
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <div class="d-block">
                            <label for="serviceId" class="control-label">{{ __('Teknisi') }}<code>*</code></label>
                        </div>
                        <select class="select2 technicianId" name="technicianId">
                        <option value="-">- Select -</option>
                        @foreach ($employee as $element)
                            <option value="{{$element->id}}">{{$element->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                        <input id="startDate" type="text" class="form-control datepicker" name="startDate">
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="endDate">{{ __('Tanggal Akhir') }}<code>*</code></label>
                        <input id="endDate" type="text" class="form-control datepicker" name="endDate">
                    </div>

                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="endDate">{{ __('Kas') }}<code>*</code></label>
                        <select name="accountMain" class="select2 accountMain" id="" onchange="paymentMethodChange()">
                            <option value="">- Select -</option>
                            @foreach ($accountMain as $el)
                                <option value="{{$el->main_id}}" data-name="{{$el->name}}">{{$el->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="endDate">{{ __('Kas Data') }}<code>*</code></label>
                        <select name="accountData" class="accountData select2" id="">
                            <option value="">- Select -</option>
                        </select>
                        {{-- <input id="endDate" type="text" class="form-control datepicker" name="endDate"> --}}
                    </div>
                    @foreach ($accountData as $el)
                    <input class="accountDataHidden" type="hidden"
                    data-mainName="{{$el->AccountMain->name}}"
                    data-mainDetailName="{{$el->AccountMainDetail->name}}"
                    data-branch="{{$el->branch_id}}"
                    data-name="{{$el->name}}"
                    data-code="{{$el->code}}"
                    value="{{$el->id}}">
                @endforeach
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <button class="btn btn-primary" type="button" onclick="checkEmploye()"><i class="fas fa-eye"></i> Cari</button>
                    </div>
                </div>
            </div>
        </div>
      <div class="col-7">
          <h2 class="section-title">Total Sharing Profit</h2>
          <div class="card">
              <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Dibayarkan ?</th>
                            </tr>
                        </thead>
                        <tbody class="dropHere" style="border: none !important">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total </th>
                                <th class="dropHereTotal">0</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="dropHereTotalVal"></div>
                    <button type="button" class="btn btn-primary" onclick="saveSharingProfit()"><i class="fas fa-save"></i> Simpan</button>
        
                </div>
              </div>
          </div>
      </div>
    </div>
  </section>
</form>
@endsection
@section('script')
<script src="{{ asset('assets/pages/finance/sharingProfitScript.js') }}"></script>
@endsection
