@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Barang'))
@section('titleContent', __('Tambah Barang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Barang') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Barang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('item.store') }}">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="category_id">{{ __('Kategori') }}<code>*</code></label>
                    <select name="category_id" id="category_id" class="form-control select2" required autocomplete="category_id">
                        <option value=""> - Select - </option>
                        @foreach ($category as $category)
                        <option value="{{ $category->id }}">{{ $category->code }} - {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="condition">{{ __('Kondisi') }}<code>*</code></label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="condition" value="Baru" class="selectgroup-input" checked="">
                          <span class="selectgroup-button">Baru</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="condition" value="Bekas" class="selectgroup-input">
                          <span class="selectgroup-button">Bekas</span>
                        </label>
                    </div>
                    @error('condition')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <label for="supplier_id">{{ __('Supplier') }}<code>*</code></label>
                    <select name="supplier_id" id="supplier_id" class="form-control select2" required autocomplete="supplier_id">
                        <option value=""> - Select - </option>
                        @foreach ($supplier as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="description">{{ __('Keterangan') }}</label>
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description" value="{{ old('description') }}" autocomplete="description">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="image">{{ __('Gambar') }}</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="">
                        <label class="custom-file-label" for="image">Pilih Gambar</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 col-xs-12">
                    <label for="buy">{{ __('Harga Beli') }}<code>*</code></label>
                    <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp.
                            </div>
                          </div>
                          <input id="buy" type="number" class="form-control currency @error('buy') is-invalid @enderror"
                            name="buy" value="{{ old('buy') }}" required autocomplete="buy">
                          @error('buy')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 col-xs-12">
                    <label for="sell">{{ __('Harga Jual') }}<code>*</code></label>
                    <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp.
                            </div>
                          </div>
                          <input id="sell" type="number" class="form-control currency @error('sell') is-invalid @enderror"
                            name="sell" value="{{ old('sell') }}" required autocomplete="sell">
                          @error('sell')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 col-xs-12">
                    <label for="discount">{{ __('Diskon') }}</label>
                    <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp.
                            </div>
                          </div>
                          <input id="discount" type="number" class="form-control currency @error('discount') is-invalid @enderror"
                            name="discount" value="{{ old('discount') }}" autocomplete="discount">
                          @error('discount')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah Data Master') }}</button>
        </div>
    </form>
</div>
@endsection
