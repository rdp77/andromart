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

        h2,
        p {
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

        .flex-container-1>div {
            text-align: left;
        }

        .flex-container-1 .right {
            text-align: right;
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

        .flex-container>div {
            -ms-flex: 1;
            /* IE 10 */
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
                    <li> {{ $return->code }} </li>
                    <li> {{ $return->Sale->Sales->name }} </li>
                    <li> {{ date('d F Y',strtotime($return->created_at)) }} </li>
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
            <div><b>Tipe</b></div>
        </div>
        @foreach ($return->SaleReturnDetail as $i => $r)
        <div class="flex-container-2">
            <div style="text-align: left;">
                <ul>
                    <li>{{ $r->Item->name }}</li>
                </ul>
            </div>
            <div style="text-align: right">
                <ul>
                    <li>-</li>
                    @switch($r->type)
                    @case(1)
                    {{ __('Diservice') }}
                    @break
                    @case(2)
                    {{ __('Diganti Baru') }}
                    @break
                    @case(3)
                    {{ __('Tukar Tambah') }}
                    @break
                    @case(4)
                    {{ __('Diganti Uang') }}
                    @break
                    @case(5)
                    {{ __('Diganti Barang Lain') }}
                    @break
                    @endswitch
                </ul>
            </div>
        </div>
        @endforeach
        <hr>
        <div class="header">
            <p><b> Terimakasih </b></p>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
</body>

</html>