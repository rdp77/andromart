<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Faktur</th>
            <th class="text-center">Barang</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">Pembayaran</th>
            <th class="text-center">Operator</th>
            <th class="text-center">Jumlah</th>
        </tr>
    </thead>
    @foreach($data as $key => $value)
    <tbody class="dropHere" style="border: none !important">
        <tr>
            <td>{{ $value->date }}</td>
            <th>{{ $value->code }}</th>
            <td>
                <table>
                    <tbody>
                        @foreach ($value->purchasingDetail as $as => $pd)
                        <tr>
                            <td>x{{ $pd->qty}}</td>
                            <th>{{ $pd->item->name }}</th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        @foreach ($value->purchasingDetail as $qw => $pds)
                            <tr>
                                <td>{{ $pds->item->supplier->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <th>
                @if ($value->status = 'paid')
                    LUNAS
                @else
                    HUTANG
                @endif
            </th>
            <td>{{ $value->employee->name }}</td>
            <th class="text-right">Rp. {{ number_format($value->price, 0, '.', ',') }}</th>
        </tr>
    </tbody>
    @endforeach
    <tfoot>
        <tr style="color: #6777ef">
            <th colspan="4"><h5>Jumlah Transaksi : {{ $tr }}</h5></th>
            <th colspan="3"><h5>Total Pengeluaran : Rp.{{ number_format($sumBayar, 0, '.', ',') }}</h5></th>
        </tr>
    </tfoot>
</table>
