<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="return">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Barang masih ada garansi, pilih metode return!') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Pilihan Return') }}<code>*</code></label>
                        </div>
                        <select class="select2" name="type" id="type">
                            <option value="">{{ __('- Pilih Metode Return -') }}</option>
                            <option value="1">{{ __('Service Barang') }}</option>
                            <option value="2">{{ __('Ganti Baru') }}</option>
                            {{-- <option value="3">{{ __('Tukar Tambah') }}</option> --}}
                            <option value="3">{{ __('Ganti Uang') }}</option>
                            <option value="4">{{ __('Ganti Atribut') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-primary" onclick="returnType()">{{ __('Pilih') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>