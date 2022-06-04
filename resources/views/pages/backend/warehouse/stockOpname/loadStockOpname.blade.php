@foreach($stockCategory as $key => $el)
    <h5>Kategori : {{$el->name}}</h5><br>
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th class="text-center" width="6%" >{{ __('NO') }}</th>
                <th class="text-center" width="34%">{{ __('Barang') }}</th>
                <th class="text-center" width="5%">{{ __('Stok') }}</th>
                <th class="text-center" width="5%">{{ __('Satuan') }}</th>
                <th class="text-center" width="25%">{{ __('Harga Beli') }}</th>
                <th class="text-center" width="25%">{{ __('Saldo') }}</th>
            </tr>
        </thead>
        @php
            $no=1;
            $sumActiva = 0;
            $sumItem = 0;
        @endphp
        @foreach ($item as $key1 => $el1)
            @if ($el1->category == $el->code)
            @php
                $sumBuy = $el1->stock*$el1->hargabeli;
                $sumActiva += $el1->stock*$el1->hargabeli;
                $sumItem += $el1->stock;
            @endphp
        <tbody style="border: none !important">
            <tr>
                <th scope="row" class="text-right">{{ $no++ }}</th>
                <td>{{ $el1->merk }} {{ $el1->itemName }}</td>
                <td>{{ $el1->stock }}</td>
                <td>{{ $el1->satuan }}</td>
                <td class="text-right">Rp. {{ number_format($el1->hargabeli, 0, ".", ",") }}</td>
                <td class="text-right">Rp. {{ number_format($sumBuy, 0, ".", ",") }}</td>
            </tr>
        </tbody>
                @endif
                @endforeach
        <tfoot>
            <tr style="color: #6777ef;">
                <th colspan="3" class="text-right"><h4>Total Barang : {{ $sumItem }} </h4></th>
                <th colspan="3" class="text-right"><h4>Total Saldo : Rp. {{ number_format($sumActiva, 0, ".", ",") }}</h4></th>
            </tr>
        </tfoot>
    </table>
    <br>
@endforeach