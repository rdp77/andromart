    <table class="table table-striped">
        <thead>
            <tr>
                <th colspan="2"><h5 style="color: #6777ef;">Menunggu Servis : {{ $tmanifest }}</h5></th>
                <th colspan="2"><h5 style="color: #6777ef;">Proses Servis : {{ $tprogress+$tprogress2 }}</h5></th>
                <th colspan="2"><h5 style="color: #6777ef;">Total Transaksi : {{ $tr+$tr2 }}</h5></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th class="text-center">{{ __('Faktur') }}</th>
                <th class="text-center">{{ __('Operator') }}</th>
                <th class="text-center">{{ __('Pelanggan') }}</th>
                <th class="text-center" width="20%">{{ __('Barang') }}</th>
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
            </td>
            <td>
                <table>
                    <tr>
                        <td>Penerima</td>
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
                        <th>{{ $service->Brand->Category->code }} {{ $service->Brand->name }} <br>{{ $service->Type->name }}</th>
                    </tr>
                    <tr>
                        <td>IMEI : <b>{{ $service->no_imei }}</b></td>
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
        @foreach ($service2 as $service2)
        <tbody class="dropHere" style="border: none !important">
            <td>
                <table>
                    <tr>
                        <td>Kode</td>
                        <th>{{ $service2->code }}</th>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <th>{{ \Carbon\Carbon::parse($service2->date)->locale('id')->isoFormat('LL') }}</th>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>Penerima</td>
                        <th>{{ $service2->created_by }}</th>
                    </tr>
                    <tr>
                        <td>Teknisi 1</td>
                        <th>{{ $service2->Employee1->name }}</th>
                    </tr>
                    @if ($service2->technician_replacement_id != null)
                    <tr>
                        <td>Teknisi 2</td>
                        <th>{{ $service2->Employee2->name }}</th>
                    </tr>
                    @endif
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>{{ $service2->customer_name }}</th>
                    </tr>
                    <tr>
                        <th>{{ $service2->customer_phone }}</th>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>{{ $service2->Brand->Category->code }} {{ $service2->Brand->name }} <br>{{ $service2->Type->name }}</th>
                    </tr>
                    <tr>
                        <td>IMEI : <b>{{ $service2->no_imei }}</b></td>
                    </tr>
                </table>
            </td>
            <th>
                {{ $service2->complaint }}
            </th>
            <td class="text-left">
                @if ($service2->work_status == 'Manifest')
                    <div class="badge badge-primary">Manifest</div><br><br>
                @elseif ($service2->work_status == 'Proses')
                    <div class="badge badge-warning">Proses</div><br><br>
                @endif
                @if ($service2->payment_status == 'Lunas')
                    <div class="badge badge-success">Lunas</div>
                @elseif ($service2->payment_status == 'Bayar DP')
                    <div class="badge badge-warning">Bayar DP</div>
                @elseif ($service2->payment_status == null)
                    <div class="badge badge-danger">Belum Bayar</div>
                @endif
            </td>
        </tbody>
        @endforeach
    </table>
