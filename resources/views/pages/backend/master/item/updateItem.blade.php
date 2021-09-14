@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Master Barang'))
@section('titleContent', __('Edit Master Barang'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Barang') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Master Barang') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('item.update',$item->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <div class="d-block">
                        <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                    </div>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $item->name }}" required autofocus>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="category_id">{{ __('Kategori') }}<code>*</code></label>
                    <select name="category_id" id="category_id" class="form-control select2" required autocomplete="category_id">
                        <option value="{{ $item->category->id }}">{{ $item->category->code }} - {{ $item->category->name }}</option>
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
                            <input type="radio" name="condition" value="Baru" class="selectgroup-input" @if ($item->condition == 'Baru') checked="" @endif >
                          <span class="selectgroup-button">Baru</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="condition" value="Bekas" class="selectgroup-input" @if ($item->condition == 'Bekas') checked="" @endif >
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
                <div class="form-group col-md-2 col-xs-12">
                    <label for="supplier_id">{{ __('Supplier') }}<code>*</code></label>
                    <select name="supplier_id" id="supplier_id" class="form-control select2" required autocomplete="supplier_id">
                        <option value="{{ $item->supplier->id }}">{{ $item->supplier->name }}</option>
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
                {{-- <div class="form-group col-md-2">
                    <label for="branch_id">{{ __('Cabang') }}<code>*</code></label>
                    <div class="selectgroup selectgroup-pills">
                        @foreach($branch as $branch)
                        <label class="selectgroup-item">
                          <input type="checkbox" name="branch_id[]" value="{{ $branch->id }}" class="selectgroup-input" checked="">
                          <span class="selectgroup-button">{{ $branch->code }}</span>
                        </label>
                        @endforeach
                    </div>
                </div> --}}
                <div class="form-group col-md-4 col-xs-12">
                    <label for="description">{{ __('Keterangan') }}</label>
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description" value="{{ $item->description }}" autocomplete="description">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-2 col-xs-12">
                    <label for="image">{{ __('Gambar') }}</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
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
                            name="buy" value="{{ $item->buy }}" required autocomplete="buy">
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
                            name="sell" value="{{ $item->sell }}" required autocomplete="sell">
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
                            name="discount" value="{{ $item->discount }}" autocomplete="discount">
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
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
