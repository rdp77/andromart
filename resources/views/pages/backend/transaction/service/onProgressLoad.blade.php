    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="2"><h5 style="color: #6777ef;">Menunggu Servis : {{ $tmanifest }}</h5></th>
                <th colspan="1"><h5 style="color: #6777ef;">Proses Servis : {{ $tprogress }}</h5></th>
                <th colspan="2"><h5 style="color: #6777ef;">Total Transaksi : {{ $tr }}</h5></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th class="text-center">{{ __('Faktur') }}</th>
                <th class="text-center">{{ __('Pelanggan') }}</th>
                <th class="text-center">{{ __('Barang') }}</th>
                <th class="text-center" width="25%">{{ __('Keluhan') }}</th>
                <th class="text-center">{{ __('Status') }}</th>
            </tr>
        </thead>
        @foreach ($service as $service)
        <tbody class="dropHere" style="border: none !important">
            <td>
                <table>
                    <tr>
                        <td>Kode</td>
                        <th>{{ $service->code }}</th>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <th>{{ \Carbon\Carbon::parse($service->date)->locale('id')->isoFormat('LL') }}</th>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>Operator</td>
                        <th>{{ $service->created_by }}</th>
                    </tr>
                    <tr>
                        <td>Teknisi 1</td>
                        <th>{{ $service->Employee1->name }}</th>
                    </tr>
                    @if ($service->technician_replacement_id != null)
                    <tr>
                        <td>Teknisi 2</td>
                        <th>{{ $service->Employee2->name }}</th>
                    </tr>
                    @endif
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>{{ $service->customer_name }}</th>
                    </tr>
                    <tr>
                        <th>{{ $service->customer_phone }}</th>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>Kategori</td>
                        <th>{{ $service->Brand->Category->name }}</th>
                        <td>Merk</td>
                        <th>{{ $service->Brand->name }}</th>
                    </tr>
                    <tr>
                        <td>Seri</td>
                        <th>{{ $service->Type->name }}</th>
                        <td>IMEI</td>
                        <th>{{ $service->no_imei }}</th>
                    </tr>
                </table>
            </td>
            <th>
                {{ $service->complaint }}
            </th>
            <td class="text-left">
                @if ($service->work_status == 'Manifest')
                    <div class="badge badge-primary">Manifest</div><br><br>
                @elseif ($service->work_status == 'Proses')
                    <div class="badge badge-warning">Proses</div><br><br>
                @endif
                @if ($service->payment_status == 'Lunas')
                    <div class="badge badge-success">Lunas</div>
                @elseif ($service->payment_status == 'Bayar DP')
                    <div class="badge badge-warning">Bayar DP</div>
                @elseif ($service->payment_status == null)
                    <div class="badge badge-danger">Belum Bayar</div>
                @endif
            </td>
        </tbody>
        @endforeach
    </table>
