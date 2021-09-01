@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Dana Kredit PDL'))
@section('titleContent', __('Edit Dana Kredit PDL'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Dana Kredit PDL') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Dana Kredit PDL') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" class="form-data" action="{{ route('users.store') }}">
        @csrf
        @method('PUT')
        {{ method_field('PUT') }} 

        <div class="card-body">

            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama Sales') }}<code>*</code></label>
                </div>
                <select class="select2" name="salesId">
                  <option value="">- Select -</option>
                  @foreach ($member as $element)
                          <option @if ($element->id == $CreditFunds->sales_id) selected="" @endif value="{{$element->id}}">{{$element->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="liquidDate">{{ __('Tanggal Cair') }}<code>*</code></label>
                <input id="liquidDate" type="text" class="form-control datepickerFormatDFY"
                    name="liquidDate"  value="{{date('d-F-Y',strtotime($CreditFunds->liquid_date))}}">
            </div>
            <div class="form-group">
                <label for="total">{{ __('Total Pagu') }}<code>*</code></label>
                <input id="total" type="text" class="form-control numberFormatCleave"
                    name="total"  value="{{$CreditFunds->total}}">
            </div>

            <div class="card-footer text-right">
                <input type="hidden" name="id" value="{{$CreditFunds->id}}">
                <button class="btn btn-primary mr-1" type="button" onclick="updateData({{$CreditFunds->id}})">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/pages/transaction/creditFunds.js') }}"></script>
@endsection