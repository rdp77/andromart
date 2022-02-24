<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center" width="15%">Tanggal</th>
            <th class="text-center" width="12%">Faktur</th>
            <th class="text-center" width="25%">Barang</th>
            <th class="text-center" width="18%">Akun Kas</th>
            <th class="text-center" width="15%">Laba Kotor</th>
            <th class="text-center" width="15%">Laba Bersih</th>
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
                        @foreach ($value->SaleDetail as $as => $sd)
                        <tr>
                            <td>x{{ $sd->qty }}</td>
                            <th>{{ $sd->item->brand->name }} <br> {{ $sd->item->name }}</th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <b>{{ $value->accountData->code }}</b>
                                <br>{{ $value->accountData->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <th class="text-right">Rp. {{ number_format($value->total_price, 0, ".", ",") }}</th>
            <th class="text-right">Rp. {{ number_format($value->total_profit_store, 0, ".", ",") }}</th>
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
