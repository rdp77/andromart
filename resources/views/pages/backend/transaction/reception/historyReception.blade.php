<div class="card">
    <div class="card-header">
        <h4>Barang</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 20%">Nama</th>
                        <th>qty</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @php dd($models) @endphp
                </tbody>
                <tbody class="dropHereItem" style="border: none !important">
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
        <button class="btn btn-primary mr-1" type="submit"><i class="far fa-save"></i>{{ __('Ubah Data') }}</button>
    </div>
</div>