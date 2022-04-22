<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center" width="12%">Tanggal</th>
            <th class="text-center" width="25%" colspan="2">Faktur</th>
            <th class="text-center" width="13%">Customer</th>
            <th class="text-center" width="18%">Status</th>
            <th class="text-center" width="13%">Keterangan</th>
            <th class="text-center" width="14%">Jumlah</th>
        </tr>
    </thead>
    @foreach($data as $key => $value)
    <tbody class="dropHere" style="border: none !important">
        <tr role="row" class="odd">
            <td>{{ \Carbon\Carbon::parse($value->date)->locale('id')->isoFormat('LL') }}</td>
            <td> 
                {{-- <b>{{ $value->code }}</b><br> --}}
                <b>{{ $value->paymentCode }}</b><br>
                Kode Pembayaran
            </td>
            <td> 
                {{-- <b>{{ $value->service->code }}</b><br> --}}
                <b>{{ $value->serviceCode }}</b><br>
                Kode Service
            </td>
            <td>
                <b>{{ $value->customer_name }}</b><br>
                {{ $value->customer_phone }}
            </td>
            <td>Pembayaran &nbsp; :
                <strong>
                    @if ($value->type == null)
                        Belum Bayar
                    @elseif($value->type == "DownPayment")
                        Bayar DP
                    @elseif ($value->type == "Lunas")
                        Lunas
                    @endif
                </strong><br>
                Pekerjaan &emsp; &nbsp; :
                <strong>
                    @if ($value->work_status == "Proses")
                        Proses Pengerjaan
                    @elseif($value->work_status == "Mutasi")
                        Perpindahan Teknisi
                    @elseif ($value->work_status == "Selesai")
                        Selesai
                    @elseif($value->work_status == "Cancel")
                        Service Batal
                    @elseif ($value->work_status == "Manifest")
                        Barang Diterima
                    @elseif ($value->work_status == "Diambil")
                        Sudah Diambil
                    @elseif ($value->work_status == "Return")
                        Sudah Diambil
                    @endif
                </strong>
            </td>
            <td>
                {{ $value->description }}
            </td>
            <th class="text-right">Rp. {{ number_format($value->total, 0, ".", ",") }}</th>
        </tr>
    </tbody>
    @endforeach
    <tfoot>
        <tr style="color: #6777ef;">
            <th colspan="2" class="text-left"><h5>Jumlah Transaksi : {{ $tr }}</h5></th>
            <th colspan="3" class="text-center"><h5>Pendapatan Kotor : Rp. {{ number_format($sumKotor, 0, ".", ",") }}</h5></th>
            <th colspan="2" class="text-right"><h5>Pendapatan Bersih : Rp. {{ number_format($sumBersih, 0, ".", ",") }}</h5></th>
        </tr>
    </tfoot>
</table>
