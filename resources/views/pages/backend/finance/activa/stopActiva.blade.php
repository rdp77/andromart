@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Hentikan Activa / Penyusutan'))
@section('titleContent', __('Hentikan Activa / Penyusutan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Activa / Penyusutan') }}</div>
<div class="breadcrumb-item active">{{ __('Hentikan Activa / Penyusutan') }}</div>
@endsection

@section('content')
@include('layouts.backend.components.notification')


<form method="POST" action="{{ route('activa.stop-store-activa', ['id'=>$data->id]) }}">
    @csrf
    <div class="row">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('code') }}</label><code>*</code>
                                <input value="{{$data->id}}" name="id" type="hidden" class="form-control">
                                <h5>{{ $data->code }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address"
                                    class="control-label">{{ __('Barang / lokasi') }}<code>*</code></label>
                                @if ($data->with_items == 'Y')
                                    <h5>{{ $data->itemsRel->name }} / {{ $data->location }}</h5>
                                @else
                                    <h5>{{ $data->items }} / {{ $data->location }}</h5>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="email" class="control-label">{{ __('Penanggung Jawab') }}</label><code>*</code>
                                <h5>{{ isset($data->UserResponsible->name) == 1 ? $data->UserResponsible->name : 'Tidak Ada Penanggung Jawab' }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Cabang') }}</label><code>*</code>
                                <h5>{{ $data->branch->name }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Deskripsi') }}</label><code>*</code>
                                <h5>{{ $data->description }}</h5>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Tgl Perolehan') }}</label><code>*</code>
                                <h5>{{ date('d F Y', strtotime($data->date_acquisition)) }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Bulan Selesai') }}</label><code>*</code>
                                <h5>{{ date('F Y', strtotime($data->date_finished)) }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Perolehan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->total_acquisition, 0, '.', ',') }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Awal Penyusutan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->total_early_depreciation, 0, '.', ',') }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Total Penyusutan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->accumulation_depreciation, 0, '.', ',') }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Buku / Sisa Peny.') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->remaining_depreciation, 0, '.', ',') }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Penyusutan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->total_depreciation, 0, '.', ',') }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Status') }}</label><code>*</code>
                                <h5>{{ $data->status }}</h5>
                            </div>
                        </div>
                      
                      
                    </div>
                 
                </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Perkiraan Penyusutan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="email" class="control-label">{{ __('Alasan Dihentikan') }}</label><code>*</code>
                            <select name="reason" id="reason" onchange="changeReason()" class="form-control" >
                                <option value="">- Select -</option>
                                <option value="Broken">Rusak</option>
                                <option value="Sell">Di jual</option>
                                <option value="Mutasi">Pindah Cabang</option>
                            </select>
                        </div>
                    </div>
                    <div class="row sell_price" style="display: none">
                        <div class="form-group col-md-12">
                            <label for="email" class="control-label">{{ __('Harga Jual') }}</label><code>*</code>
                            <input id="sell_price" name="sell_price" type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="row branch_id" style="display: none">
                        <div class="form-group col-md-12">
                            <label for="email" class="control-label">{{ __('Cabang') }}</label><code>*</code>
                            <select name="branch_id" id="branch_id" class="form-control select2" >
                                <option value=""> - Select - </option>
                                @foreach ($Branch as $el)
                                    <option value="{{ $el->id }}"> {{ $el->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                    <button class="btn btn-primary mr-1" type="button" onclick="stopStoreActive('{{$data->id}}')">{{ __('pages.edit') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')

<script src="{{ asset('assets/pages/master/activaScript.js') }}"></script>
<script>
    window.onload = appendValue();
</script>
@endsection