@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Pengeluaran'))
@section('titleContent', __('Tambah Pengeluaran'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pengeluaran') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Pengeluaran') }}</div>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('payment.store') }}">
                    @csrf
                    <div class="card-header">
                        <h4>Form Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                                <input id="code" type="text" class="form-control" readonly="" value="{{$code}}" name="code">
                            </div>
                            <div class="form-group col-md-6 col-lg-6">
                                <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                                <input id="date" type="text" class="form-control datepicker" readonly="" name="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="branch_id"
                                        class="control-label">{{ __('Cabang') }}<code>*</code></label>
                                </div>
                                <select onchange="branchChange()" class="select2 branch @error('branch_id') is-invalid @enderror" name="branch_id" required>
                                    <option value="">- Select -</option>
                                    @foreach ($branch as $branch)
                                    <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->name}}</option>
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
                                <select class="select2" name="cash_id" required>
                                    <option value="">- Select -</option>
                                    @foreach ($cash as $el)
                                        @if ($el->main_id == 1)
                                            <option value="{{$el->id}}">{{$el->code}} - {{$el->name}}</option>
                                        @endif
                                    @endforeach 
                                </select>
                            </div>
                            @foreach ($cash as $el)
                                @if ($el->debet_kredit == 'K')
                                    <input class="accountData" type="hidden"
                                    data-branch="{{$el->branch_id}}"
                                    data-name="{{$el->code}} - {{$el->name}}"
                                    value="{{$el->id}}">
                                @endif
                            @endforeach
                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="cost_id"
                                        class="control-label">{{ __('Jenis Biaya') }}<code>*</code></label>
                                </div>
                                <select class="select2 cost @error('cost_id') is-invalid @enderror"  name="cost_id" required>
                                    <option value="">- Select -</option>
                                    @foreach ($cost as $cost)
                                    <option value="{{$cost->id}}">{{$cost->code}} - {{$cost->name}}</option>
                                    @endforeach
                                </select>
                                @error('cost_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-5 col-xs-12">
                                <label for="price">{{ __('Jumlah Pembayaran') }}<code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        Rp.
                                        </div>
                                    </div>
                                    <input id="rupiah" type="text" class="form-control cleaveNumeral @error('price') is-invalid @enderror"
                                        name="price" value="{{ old('price') }}" required style="text-align: right">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-7 col-xs-12">
                                <label for="description">{{ __('Keterangan') }}</label>
                                <input id="description" type="text" class="form-control" name="description">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                        <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah Data Transaksi') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/transaction/paymentScript.js') }}"></script>
@endsection
