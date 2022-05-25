<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center" width="13%">Tanggal</th>
            <th class="text-center" width="12%">Faktur</th>
            <th class="text-center" width="25%">Barang</th>
            <th class="text-center" width="18%">Akun Kas</th>
            <th class="text-center" width="12%">Laba Kotor</th>
            <th class="text-center" width="10%">HPP</th>
            <th class="text-center" width="10%">Laba Bersih</th>
        </tr>
    </thead>
    @foreach($data as $key => $value)
    <tbody class="dropHere" style="border: none !important">
        <tr role="row" class="odd">
            <td>{{ \Carbon\Carbon::parse($value->date)->locale('id')->isoFormat('LL') }}</td>
            <th>{{ $value->code }}</th>
            <td>
                @foreach ($value->SaleDetail as $as => $sd)
                <b>x{{ $sd->qty }}</b> &nbsp;
                {{ $sd->item->brand->name }} <br> {{ $sd->item->name }} <br>
                @endforeach
            </td>
            <td>
                <b>{{ $value->accountData->code }}</b>
                <br>{{ $value->accountData->name }}
            </td>
            <th class="text-right">Rp. {{ number_format($value->total_price, 0, ".", ",") }}</th>
            <th class="text-right">Rp. {{ number_format($value->total_hpp, 0, ".", ",") }}</th>
            <th class="text-right">Rp. {{ number_format($value->total_profit_store, 0, ".", ",") }}</th>
        </tr>
    </tbody>
    @endforeach
    <tfoot>
        <tr style="color: #6777ef;">
            <th colspan="2" class="text-left"><h5>Jumlah Transaksi : {{ $tr }}</h5></th>
            <th colspan="2" class="text-center"><h5>Pendapatan Kotor : Rp. {{ number_format($sumKotor, 0, ".", ",") }}</h5></th>
            <th colspan="3" class="text-right"><h5>Pendapatan Bersih : Rp. {{ number_format($sumBersih, 0, ".", ",") }}</h5></th>
        </tr>
    </tfoot>
</table>
