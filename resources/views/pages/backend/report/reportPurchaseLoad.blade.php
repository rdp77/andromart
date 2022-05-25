<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center" width="13%">Tanggal</th>
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
            <td>{{ date('d F Y', strtotime($value->date)) }}</td>
            <th>{{ $value->code }}</th>
            <td>
                @foreach ($value->purchasingDetail as $as => $pd)
                <b>x{{ $pd->qty_start}}</b> &nbsp;
                {{ $pd->item->brand->name }} {{ $pd->item->name }} <br>
                @endforeach
            </td>
            <td>
                @foreach ($value->purchasingDetail as $qw => $pds)
                {{ $pds->item->supplier->name }} <br>
                @endforeach
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
            <th colspan="4" class="text-left"><h5>Jumlah Transaksi : {{ $tr }}</h5></th>
            <th colspan="3" class="text-right"><h5>Total Pengeluaran : Rp.{{ number_format($sumBayar, 0, '.', ',') }}</h5></th>
        </tr>
    </tfoot>
</table>
