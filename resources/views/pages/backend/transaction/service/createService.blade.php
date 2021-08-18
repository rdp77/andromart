@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Dana Kredit PDL'))
@section('titleContent', __('Tambah Dana Kredit PDL'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Dana Kredit PDL') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Dana Kredit PDL') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" class="form-data" action="{{ route('users.store') }}">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama Sales') }}<code>*</code></label>
                </div>
                <select class="select2" name="salesId">
                  <option value="">- Select -</option>
                  @foreach ($member as $element)
                      <option value="{{$element->id}}">{{$element->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="liquidDate">{{ __('Tanggal Cair') }}<code>*</code></label>
                <input id="liquidDate" type="text" class="form-control datepickerFormatDFY"
                    name="liquidDate"  >
            </div>
            <div class="form-group">
                <label for="total">{{ __('Total Pagu') }}<code>*</code></label>
                <input id="total" type="text" class="form-control numberFormatCleave"
                    name="total"  >
            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="button" onclick="save()">{{ __('Tambah') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/pages/transaction/creditFunds.js') }}"></script>
@endsection