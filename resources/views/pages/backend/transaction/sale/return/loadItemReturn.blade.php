{{-- <div class="form-group col-md-12 col-xs-12"> --}}
    <label for="itemOld">{{ __('Barang') }}</label><code>*</code>
    <select class="select2 form-control" name="itemOld" id="itemOld">
        <option value="">{{ __('- Select -') }}</option>
        @foreach($query->SaleDetail as $key => $value)
        <option value="{{ $value->item_id }}">{{ $value->item->brand->name }} {{ $value->item->name }}</option>
        @endforeach
    </select>
{{-- </div> --}}
