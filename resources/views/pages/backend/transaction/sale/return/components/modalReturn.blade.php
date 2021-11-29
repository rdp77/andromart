<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Detail Barang') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" width="100%">
                        <thead>
                            <tr>
                                <th width="50%">{{ __('Nama') }}</th>
                                <th>{{ __('Detail') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ __('QTY') }}</th>
                                <td id="qty"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Total') }}</th>
                                <td id="total_price"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Pengambil') }}</th>
                                <td id="taker"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Penjual') }}</th>
                                <td id="seller"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Sharing Profit Pengambil') }}</th>
                                <td id="sp_taker"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Sharing Profit Penjual') }}</th>
                                <td id="sp_seller"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Deskripsi') }}</th>
                                <td id="desc"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>