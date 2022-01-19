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
          <h2 class="section-title">form </h2>
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
                        <button class="btn btn-primary" type="button" onclick="checkEmploye()"><i class="fas fa-eye"></i> Cari</button>
                    </div>
                </div>
            </div>
        </div>
      <div class="col-7">
          <h2 class="section-title">Total Service</h2>
          <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>total</th>
                        <th>Dibayarkan ?</th>
                    </tr>
                </thead>
                <tbody class="dropHere" style="border: none !important">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">total</td>
                        <td class="dropHereTotal">0</td>
                    </tr>
                </tfoot>
            </table>
            <div class="dropHereTotalVal"></div>
            <button type="button" class="btn btn-primary" onclick="saveSharingProfit()"><i class="fas fa-save"></i> Simpan</button>

        </div>
      </div>
    </div>
  </section>
</form>
@endsection
@section('script')
<script src="{{ asset('assets/pages/finance/sharingProfitScript.js') }}"></script>
@endsection
