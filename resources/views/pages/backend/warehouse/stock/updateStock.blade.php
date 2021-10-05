@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Stock'))
@section('titleContent', __('Edit Stock'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Stock') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Stock') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('stock.update',$stock->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-3 col-xs-12">
                    <label for="branch_id">{{ __('Cabang') }}</label>
                    <select class="select2" name="branch_id" disabled>
                        @foreach ($branch as $branch)
                        <option value="{{ $branch->id }}"
                            @if ($branch->id == $stock->branch_id)
                                selected=""
                            @endif>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="item">{{ __('Item') }}</label>
                    <input id="item" type="text" class="form-control" name="item" value="{{ $stock->item->name }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2 col-xs-6">
                    <label for="min_stock" class="control-label">{{ __('Stok Min.') }}</label>
                    <input id="min_stock" type="number" class="form-control text-right" name="min_stock" value="{{ $stock->min_stock }}">
                </div>
                <div class="form-group col-md-2 col-xs-6">
                    <label for="unit_id">{{ __('Satuan') }}</label><code>*</code>
                    <select class="select2" name="unit_id">
                        @foreach ($unit as $unit)
                        <option value="{{ $unit->id }}"
                            @if ($unit->id == $stock->unit_id)
                                selected=""
                            @endif>{{ $unit->code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <label for="description" class="control-label">{{ __('Description') }}</label>
                <input id="description" type="text" class="form-control" name="description" value="{{ $stock->description }}">
            </div>
        </div>
        <div class="card-footer text-right">
            <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
