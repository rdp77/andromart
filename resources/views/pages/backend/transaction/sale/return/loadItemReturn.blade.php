<!-- <div class="form-group col-md-8 col-xs-12"> -->
    <label for="itemOld">{{ __('Barang') }}</label><code>*</code>
    <select class="form-control" name="itemOld" id="itemOld">
        <option value="">{{ __('- Select -') }}</option>
        @foreach($query->SaleDetail as $key => $value)
            <option value="{{ $value->item_id }}">{{ $value->item->name }}</option>
        @endforeach
    </select>
<!-- </div> -->