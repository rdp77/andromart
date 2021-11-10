<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Kecil</title>
    <style>
        .container {
            /* width: 300px; */
            width: 50mm;
        }
        .header {
            margin: 0;
            text-align: center;
        }
        h2, p {
            margin: 0;
        }
        .flex-container-1 {
            display: flex;
            margin-top: 10px;
        }
        .flex-container-2 {
            display: flex;
            width: 50mm;
        }
        .flex-container-1 > div {
            text-align : left;
        }
        .flex-container-1 .right {
            text-align : right;
            width: 40mm;
        }
        .flex-container-1 .left {
            width: 10mm;
        }
        .flex-container {
            /* width: 300px; */
            width: 50mm;
            display: flex;
        }

        .flex-container > div {
            -ms-flex: 1;  /* IE 10 */
            flex: 1;
        }
        ul {
            display: contents;
        }
        ul li {
            display: block;
        }
        hr {
            border-style: dashed;
        }
        a {
            text-decoration: none;
            text-align: center;
            padding: 10px;
            background: #00e676;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><img alt="Porto" height="50" src="{{ asset('assetsfrontend/img/andromart.png') }}"></h2>
            <small> {{Auth::user()->employee->branch->address}} </small><br>
            <small> 0{{Auth::user()->employee->branch->phone}} </small>
        </div>
        <hr>
        <div class="flex-container-1">
            <div class="left">
                <ul>
                    <li>Invoice</li>
                    <li>Sales</li>
                    <li>Tanggal</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li> {{ $sale->code }} </li>
                    <li> {{ $sale->sales->name }} </li>
                    <li> {{ date('d F Y',strtotime($sale->date)) }} </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-bottom: 5px; text-align:right;">
            <div style="text-align: left;">
                <ul>
                    <li><b>Barang</b></li>
                </ul>
            </div>
            <div><b>Sub Total</b></div>
        </div>
        @foreach ($sale->saleDetail as $i => $sd)
            <div class="flex-container-2">
                <div style="text-align: left;">
                    <ul>
                        <li>{{ $sd->Item->name }}</li>
                        <li>Garansi {{ $sd->Item->warranty->periode }}{{ $sd->Item->warranty->name }}</li>
                        <li>{{ $sd->qty }}*{{ number_format($sd->price,0,".",",") }}</li>
                    </ul>
                </div>
                <div style="text-align: right">
                    <ul>
                        <li>-</li>
                        <li>-</li>
                        <li>{{ number_format($sd->total,0,".",",") }}</li>
                    </ul>
                </div>
            </div>
        @endforeach
        <hr>
        <div class="flex-container" style="text-align: right; margin-top: 10px;">
            <div>
                <ul>
                    <li>Total</li>
                    {{-- <li>Pembayaran</li>
                    <li>Kembalian</li> --}}
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>Rp {{ number_format($sale->item_price) }} </li>
                    {{-- <li>Rp {{ number_format($sale->pembayaran) }}</li>
                    <li>Rp {{ number_format($sale->kembalian) }}</li> --}}
                </ul>
            </div>
        </div>
        <hr>
        <div class="header">
            <p ><b> Terimakasih </b></p>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
</body>
</html>
