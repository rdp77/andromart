<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center" width="13%">Tanggal</th>
            <th class="text-center" width="12%">Faktur</th>
            <th class="text-center" width="25%">Customer</th>
            <th class="text-center" width="20%">Barang</th>
            <th class="text-center" width="18%">Status</th>
            <th class="text-center" width="12%">Jumlah</th>
        </tr>
    </thead>
    @foreach($data as $key => $value)
    <tbody class="dropHere" style="border: none !important">
        <tr role="row" class="odd">
            <td>{{ \Carbon\Carbon::parse($value->created_at)->locale('id')->isoFormat('LL') }}</td>
            <th><a href="{{ route('service.show', $value->id) }}">{{ $value->code }}</a></th>
            <td>
                
                <strong>{{ $value->customer_name}}</strong> &nbsp; ||  
                {{ $value->customer_phone}}<br>
                {{ $value->customer_address}}
               
            </td>
            <td>
                @if ($value->group_service == null)
                    <b>{{ $value->Brand->name }} {{ $value->Type->name }}</b><br>
                    IMEI : <b>{{ $value->no_imei}}</b>
                @else
                    <b>{{ $value->Brand->name }} {{ $value->Items->name }} ( UPGRADE BARANG DAGANG )</b><br>
                    IMEI : <b>{{ $value->no_imei}} </b>
                @endif
            <td>
                Pekerjaan : <b>{{ $value->work_status }}</b><br>
                Pembayaran :
                    @if ($value->payment_status == null)
                        <b>Belum Bayar</b>
                    @else
                        <b>{{ $value->payment_status}}</b>
                    @endif
            </td>
            {{-- <th>{{ $value->payment_status }}</th> --}}
            <th class="text-right">Rp. {{ number_format($value->total_price, 0, ".", ",") }}</th>
        </tr>
    </tbody>
    @endforeach
    <tfoot>
        <tr style="color: #6777ef;">
            <th colspan="2" class="text-left"><h5>Jumlah Transaksi : {{ $tr }}</h5></th>
            <th colspan="2" class="text-center"><h5>Pendapatan Kotor : Rp. {{ number_format($sumKotor, 0, ".", ",") }}</h5></th>
            <th colspan="2" class="text-right"><h5>Pendapatan Bersih : Rp. {{ number_format($sumBersih, 0, ".", ",") }}</h5></th>
        </tr>
    </tfoot>
</table>
