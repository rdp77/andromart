<div class="modal fade" tabindex="-1" role="dialog" id="dataSave">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Data Berhasil Disimpan') }}</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('Nama') }}</th>
                                <th>{{ __('Keterangan') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ __('QTY') }}</th>
                                <td>
                                    <a href="{{ route('sale-return.index') }}" target="_blank"
                                        class="btn btn-primary btn-block">
                                        {{ __('Ke Menu Pembelian') }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Total') }}</th>
                                <td class="text-center">
                                    <span style="font-size: 35px; color: #388E3C;" class="fas fa-check-circle">
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Pengambil') }}</th>
                                <td class="text-center">
                                    <span style="font-size: 35px; color: #388E3C;" class="fas fa-check-circle">
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <a href="{{ route('sale-return.index') }}" class="btn btn-primary">{{ __('OK') }}</a>
            </div>
        </div>
    </div>
</div>