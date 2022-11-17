@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Pendapatan'))
@section('titleContent', __('Edit Pendapatan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pendapatan') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Pendapatan') }}</div>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" class="form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Form Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                                <input id="code" type="text" class="form-control" disabled readonly="" value="{{$income->code}}" name="code">
                                <input id="id" type="hidden" class="form-control" readonly="" value="{{$income->id}}" name="id">
                            </div>
                            <div class="form-group col-md-6 col-lg-6">
                                <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                                <input id="date" type="text" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($income->date)->locale('id')->isoFormat('LL') }}" readonly="" name="date" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="branch_id"
                                        class="control-label">{{ __('Cabang') }}<code>*</code></label>
                                </div>
                                <select onchange="branchChange()" class="select2 branch @error('branch_id') is-invalid @enderror" disabled name="branch_id" required>
                                    <option value="">- Select -</option>
                                    @foreach ($branch as $branch)
                                    <option @if ($branch->id == $income->branch_id)
                                        selected=""
                                    @endif value="{{$branch->id}}">{{$branch->code}} - {{$branch->name}}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="cash_id"
                                        class="control-label">{{ __('Kass') }}<code>*</code></label>
                                </div>
                                <select class="select2" name="cash_id" disabled required>
                                    <option value="">- Select -</option>
                                    @foreach ($cash as $el)
                                        @if ($el->main_id == 1)
                                            <option value="{{$el->id}}" @if ($el->id == $income->cash_id)
                                                selected=""
                                            @endif>{{$el->code}} - {{$el->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @foreach ($cash as $el)
                                @if ($el->debet_kredit == 'D')
                                    <input class="accountData" type="hidden"
                                    data-branch="{{$el->branch_id}}"
                                    data-name="{{$el->code}} - {{$el->name}}"
                                    value="{{$el->id}}">
                                @endif
                            @endforeach
                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="income_id"
                                        class="control-label">{{ __('Jenis Pendapatan') }}<code>*</code></label>
                                </div>
                                <select class="select2 cost @error('income_id') is-invalid @enderror"  name="income_id" disabled required>
                                    @foreach ($cost as $el)
                                    <option @if ($el->id == $income->income_id)
                                        selected=""
                                    @endif value="{{$el->id}}">{{$el->code}} - {{$el->name}}</option>
                                    @endforeach
                                    <option value="">- Select -</option>

                                </select>
                                @error('income_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-6 col-xs-12">
                                <label for="price">{{ __('Jumlah Pendapatan') }}<code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        Rp.
                                        </div>
                                    </div>
                                    <input id="rupiah" type="text" disabled value="{{$income->price}}"  class="form-control cleaveNumeral @error('price') is-invalid @enderror"
                                        name="price" value="{{ old('price') }}" required style="text-align: right">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="description">{{ __('Keterangan') }}</label>
                                <input id="description" disabled value="{{$income->description}}" type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/incomeScript.js') }}"></script>
<script>
    $(document).ready(function() {
        // branchChange();
        // typeChange();
    });
</script>
@endsection
