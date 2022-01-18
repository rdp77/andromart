<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="13%">Tanggal</th>
            <th width="12%">Faktur</th>
            <th width="25%">Customer</th>
            <th width="20%">Barang</th>
            <th width="18%">Status</th>
            <th width="12%">Jumlah</th>
        </tr>
    </thead>
    @foreach($data as $key => $value)
    <tbody class="dropHere" style="border: none !important">
        <tr role="row" class="odd">
            <td>{{ \Carbon\Carbon::parse($value->date)->locale('id')->isoFormat('LL') }}</td>
            <th>{{ $value->code }}</th>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <th>
                                {{ $value->customer_name}}<br>
                                {{ $value->customer_phone}}<br>
                                {{ $value->customer_address}}
                            </th>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <b>{{ $value->Brand->name }} {{ $value->Type->name }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>No. IMEI : <b>{{ $value->no_imei}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td>Pekerjaan : <b>{{ $value->work_status }}</b></td>
                        </tr>
                        <tr>
                            <td>Pembayaran : <b>{{ $value->payment_status}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            {{-- <th>{{ $value->payment_status }}</th> --}}
            <th class="text-right">Rp. {{ number_format($value->total_price, 0, ".", ",") }}</th>
        </tr>
    </tbody>
    @endforeach
    <tfoot>
        <tr style="color: #6777ef;">
            <th colspan="2"><h5>Jumlah Transaksi : {{ $tr }}</h5></th>
            <th colspan="2"><h5>Pendapatan Kotor : Rp. {{ number_format($sumKotor, 0, ".", ",") }}</h5></th>
            <th colspan="2"><h5>Pendapatan Bersih : Rp. {{ number_format($sumBersih, 0, ".", ",") }}</h5></th>
        </tr>
    </tfoot>
</table>
