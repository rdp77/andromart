@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Return Penjualan'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('sale-return.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('titleContent', __('Tambah Return Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Return Penjualan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Return Penjualan') }}</div>
@endsection

@section('content')
<h2 class="section-title" id="saleDate">{{ \Carbon\Carbon::now()->format('d F Y') }}</h2>
<p class="section-lead">{{ __('Tanggal nota penjualan dikeluarkan.') }}</p>
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama Barang') }}<code>*</code></label>
                </div>
                <select class="select2" name="item" id="item">
                    <option value="">{{ __('- Select -') }}</option>
                    @foreach ($item as $i)
                    <option value="{{ $i->id }}">{{ $i->Item->name.__(' - ').$i->Sale->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Kuantitas') }}</label>
                        </div>
                        <input type="text" class="form-control" id="qty" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>{{ __('Harga Barang') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" class="form-control cleaveNumeral" id="price" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>{{ __('Total Harga Barang') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" class="form-control cleaveNumeral" id="total" readonly>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>{{ __('Operator') }}</label>
                        <input type="text" class="form-control" id="operator" readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" onclick="save()" type="button">{{ __('Return') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    var getdata = '{{ route('sale.return.data') }}';
    var url = '{{ route('sale-return.store') }}';
    var index = '{{ route('sale-return.index') }}';
</script>
<script src="{{ asset('assets/pages/transaction/sale-return.js') }}"></script>
@endsection