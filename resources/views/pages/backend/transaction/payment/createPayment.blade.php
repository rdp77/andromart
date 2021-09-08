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
                            <div class="form-group col-md-3">
                                <label for="code">{{ __('Kode Faktur') }}<code>*</code></label>
                                <input id="code" type="text" class="form-control" readonly="" value="{{$code}}" name="code">
                            </div>
                            <div class="form-group col-md-3 col-lg-3">
                                <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                                <input id="date" type="text" class="form-control" readonly="" value="{{date('d F Y')}}"
                                    name="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 col-xs-12">
                                <div class="d-block">
                                    <label for="branch_id"
                                        class="control-label">{{ __('Cabang') }}<code>*</code></label>
                                </div>
                                <select class="select2 @error('branch_id') is-invalid @enderror" name="branch_id" required>
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
                            <div class="form-group col-md-3 col-xs-12">
                                <div class="d-block">
                                    <label for="cash_id"
                                        class="control-label">{{ __('Kass') }}<code>*</code></label>
                                </div>
                                <select class="select2 @error('cash_id') is-invalid @enderror" name="cash_id" required>
                                    <option value="">- Select -</option>
                                    @foreach ($cash as $cash)
                                    <option value="{{$cash->id}}">{{$cash->code}} - {{$cash->name}}</option>
                                    @endforeach
                                </select>
                                @error('cash_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 col-xs-12">
                                <label for="balance">{{ __('Saldo Kas') }}<code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        Rp.
                                        </div>
                                    </div>
                                    <input id="rupiah" type="text" class="form-control currency"
                                        name="balance" value="" readonly autocomplete="balance">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 col-xs-12">
                                <div class="d-block">
                                    <label for="cost_id"
                                        class="control-label">{{ __('Jenis Biaya') }}<code>*</code></label>
                                </div>
                                <select class="select2 @error('cost_id') is-invalid @enderror" name="cost_id" required>
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
                            <div class="form-group col-md-3 col-xs-12">
                                <label for="price">{{ __('Jumlah Pembayaran') }}<code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        Rp.
                                        </div>
                                    </div>
                                    <input id="rupiah" type="text" class="form-control currency @error('price') is-invalid @enderror"
                                        name="price" value="{{ old('price') }}" required autocomplete="price">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
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
