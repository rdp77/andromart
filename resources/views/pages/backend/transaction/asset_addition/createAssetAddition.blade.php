@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Penambahan Asset'))
@section('titleContent', __('Tambah Penambahan Asset'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penambahan Asset') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Penambahan Asset') }}</div>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('asset-addition.store') }}">
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
                                @if ($el->main_id == '13')
                                    <input class="accountData" type="hidden"
                                    data-branch="{{$el->branch_id}}"
                                    data-name="{{$el->code}} - {{$el->name}}"
                                    value="{{$el->id}}">
                                @endif
                            @endforeach

                            <div class="form-group col-md-4 col-xs-12">
                                <div class="d-block">
                                    <label for="income_id"
                                        class="control-label">{{ __('Akun Lawan') }}<code>*</code></label>
                                </div>
                                <select class="select2 cost @error('income_id') is-invalid @enderror"  name="income_id" required>
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
                            <div class="form-group col-md-12">
                                <label for="email"
                                    class="control-label">{{ __('Ambil Dari Master ?') }}</label><code>*</code>
                                <select onchange="changeSelectItems()" name="with_items" id="with_items"
                                    class="form-control">
                                    <option> - Select - </option>
                                    <option value="Y">YA</option>
                                    <option value="N">TIDAK</option>
                                </select>
                            </div>
                        </div>
                        <div class="row hiddenItems" style="display: none">
                            <div class="form-group col-md-12">
                                <label for="email" class="control-label">{{ __('Nama Barang') }}</label><code>*</code>
                                <input name="items" id="items" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row hiddenItemsId" style="display: none">
                            <div class="form-group col-md-12">
                                <label for="email"
                                    class="control-label">{{ __('Itens') }}</label><code>*</code>
                                <select name="items_id" id="items_id" class="form-control select2" >
                                    <option value=""> - Select - </option>
                                    @foreach ($Item as $el)
                                        <option value="{{ $el->id }}"> {{ $el->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="price">{{ __('Harga Asset') }}<code>*</code></label>
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
                            <div class="form-group col-md-6">
                                <label for="description">{{ __('Keterangan') }}</label>
                                <input id="description" type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <div class="row">
                            
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
<script>
    function changeSelectItems(params) {
        var with_items = $('#with_items').val();

        if (with_items == 'Y') {
            $('.hiddenItems').css('display', 'none');
            $('.hiddenItemsId').css('display', 'block');
        } else {
            $('.hiddenItems').css('display', 'block');
            $('.hiddenItemsId').css('display', 'none');
        }
    }
</script>
<script src="{{ asset('assets/pages/transaction/assetAdditionScript.js') }}"></script>
@endsection
