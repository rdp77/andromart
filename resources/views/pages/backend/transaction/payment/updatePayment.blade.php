@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Edit Pengeluaran'))
@section('titleContent', __('Edit Pengeluaran'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Pengeluaran') }}</div>
    <div class="breadcrumb-item active">{{ __('Edit Pengeluaran') }}</div>
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
                                <input id="code" type="text" class="form-control" readonly=""
                                    value="{{ $payment->code }}" name="code">
                                <input id="id" type="hidden" class="form-control" readonly="" value="{{ $payment->id }}"
                                    name="id">
                            </div>
                            <div class="form-group col-md-6 col-lg-6">
                                <label for="date">{{ __('Tanggal') }}<code>*</code></label>
                                <input id="date" type="text" data-name="Tanggal Harus Di isi"
                                    class="form-control datepicker validation" readonly=""
                                    value="{{ $payment->date }}" name="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="branch_id" class="control-label">{{ __('Cabang') }}<code>*</code></label>
                                </div>
                                <select onchange="branchChange()" data-name="Cabang Harus Di isi"
                                    class="select2 validation branch @error('branch_id') is-invalid @enderror"
                                    name="branch_id" required>
                                    <option value="">- Select -</option>
                                    {{-- {{ $payment->description }} --}}
                                    @foreach ($branch as $branch)

                                        <option @if ($payment->branch_id == $branch->id)
                                            selected=""
                                            @endif value="{{ $branch->id }}">{{ $branch->code }} -
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-8 col-xs-12">
                                <div class="d-block">
                                    <label for="type_id" class="control-label">{{ __('Type') }}<code>*</code></label>
                                </div>
                                <select class="select2 validation type_id" data-name="Tipe Harus Di isi"
                                    onchange="typeChange()" name="type_id" required>
                                    <option value="">- Select -</option>
                                    <option @if ($payment->type == 'Transfer')
                                        selected=""
                                        @endif value="Transfer">Transfer</option>
                                    <option @if ($payment->type == 'Pengeluaran')
                                        selected=""
                                        @endif value="Pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-xs-12">
                                <div class="d-block">
                                    <label for="cash_id" class="control-label">{{ __('Kass') }}<code>*</code></label>
                                </div>
                                <select class="select2 validation" data-name="Kas Harus Di isi" name="cash_id" required>
                                    <option value="">- Select -</option>
                                    @foreach ($cash as $el)
                                        @if ($el->main_id == 1)
                                            <option @if ($payment->cash_id == $el->id)
                                                selected=""
                                                @endif value="{{ $el->id }}">{{ $el->code }} -
                                                {{ $el->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @foreach ($cash as $el)
                                @if ($el->debet_kredit == 'K')
                                    <input class="accountData" @if ($payment->cost_id == $el->id)
                                    data-selected="selected"
                                    @endif type="hidden" data-branch="{{ $el->branch_id }}"
                                    data-name="{{ $el->code }} - {{ $el->name }}"
                                    value="{{ $el->id }}">
                                @endif
                            @endforeach
                            <div class="form-group col-md-6 col-xs-12">
                                <div class="d-block">
                                    <label for="cost_id"
                                        class="control-label">{{ __('Jenis Biaya') }}<code>*</code></label>
                                </div>
                                <select class="select2 validation cost @error('cost_id') is-invalid @enderror"
                                    data-name="Jenis Biasa Harus Di isi" name="cost_id" required>
                                    <option value="">- Select -</option>
                                </select>
                                @error('cost_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row checkTransfer" style="display: none">
                            <div class="form-group col-md-12 col-xs-12">
                                <div class="d-block">
                                    <label for="cash_tranfer_id"
                                        class="control-label">{{ __('Transfer Ke') }}<code>*</code></label>
                                </div>
                                <select class="select2 validation" data-name="Transfer Harus Di isi" name="cash_tranfer_id">
                                    <option value="">- Select -</option>
                                    @foreach ($cash_transfer as $el)
                                        @if ($el->main_id == 1)
                                            <option @if ($payment->transfer_to == $el->id)
                                                selected=""
                                                @endif value="{{ $el->id }}">{{ $el->code }} -
                                                {{ $el->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
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
                                    <input id="rupiah" type="text" data-name="Jumlah Pembayaran Harus Di isi"
                                        value="{{ $payment->price }}"
                                        class="validation form-control cleaveNumeral @error('price') is-invalid @enderror"
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
                                <input id="description" type="text" value="{{ $payment->description }}"
                                    data-name="Keterangan Harus Di isi" class="form-control validation" name="description">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                        <button class="btn btn-primary mr-1" onclick="updateData('{{ $payment->id }}')"
                            type="button">{{ __('Tambah Data Transaksi') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script src="{{ asset('assets/pages/transaction/paymentScript.js') }}"></script>
    <script>
        $(document).ready(function() {
            branchChange();
            typeChange();
        });
    </script>
@endsection
