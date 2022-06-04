<html><head>
    <title>Andromart | Laporan Stock</title>
    <link href="https://panel.jpmandiri.com/assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    {{-- <link href="https://panel.jpmandiri.com/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> --}}
    <!-- datepicker -->
    <link href="https://panel.jpmandiri.com/assets/vendors/datapicker/datepicker3.css" rel="stylesheet">
    <link href="https://panel.jpmandiri.com/assets/vendors/daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="https://panel.jpmandiri.com/assets/vendors/toastr/toastr.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://panel.jpmandiri.com/assets/plugins/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <link href="https://panel.jpmandiri.com/assets/css/chosen/chosen.css" rel="stylesheet">
    <style>
        .height{
        background: white;
            height: 100%;
        }
        .pt-2{
            padding-top: 20px;
        }
        .pl-2{
            padding-top: 20px;
        }
        .pr-2{
            padding-right: 20px !important;
        }
        .width-10{
            width: 10%;
        }
        .width-20{
            width: 20%;
        }
        .border-black{
            border:1px solid #9999;
        }
        .box-git{
            width: 100%;
            height: 133px;
        }
        .nopadding-right {
         padding-right: 0 !important;
         margin-right: 0 !important;
        }

        .nopadding-left {
         padding-left: 0 !important;
         margin-left: 0 !important;
        }
        .mt-1{
        margin-top: 10px !important;
        }
        .mt-2{
        margin-top: 20px !important;
        }
        .mb-1{
        margin-bottom: 10px !important;
        }
        .mb-2{
        margin-bottom: 20px !important;
        }
        .mr-1{
        margin-right: 10px !important;
        }
        .mr-2{
        margin-right: 20px !important;
        }
        .ml-1{
        margin-left: 10px !important;
        }
        .ml-2{
        margin-left: 20px !important;
        }
        .grey{
        color: grey;
        }
        .width-100{
        width: 100%;
        }
        .none{
        text-decoration: none;
        list-style-type: none;
        }
        .d-inline-block{
        display: inline-block;
        vertical-align: middle;
        }
        .d-inline{
        display: inline;
        vertical-align: middle;
        }
        .d-inline li{
        display: inline;
        }
        .m-auto{
        margin: auto;
        }
        .nav-tabs li a{
        padding-left: 0 !important;
        padding-right: 0 !important;
        text-align: center !important;
        }
        .font-small{
        font-size: 12px;
        }
        .middle{
        height: 47px;
        }
        .black{
        color: black;
        }
        .head{
        background: grey !important;
        color:white;
        width: 100%;
        height: 100%;
        vertical-align: middle;
        }
        .mt-5{
        margin-top: 50px
        }
        .head_awal{
        background-color: black !important;
        color: white;`
        }
        .head_awal1{
        background-color: black !important;
        color: white;`
        }
        .head_awal2{
        background-color: black !important;
        color: white;`
        }
        .hide{
        display: none;
        }
        .disabled{
            pointer-events: none;
        }

        .tree tr{
            border :hidden;
        }

        .tree_1 tr{
            border :hidden;
        }

        hr{
            border-top: 1px solid black;
            margin-top: 2px;
            margin-bottom: 0px;
        }

        .text-right{
            border: none;
        }

        .text-right{
            border: none;
        }

        .border-right-none{
            border-right: none !important;
        }

        .border-none{
            border: none !important;
        }
        .table-border td{
            border: 1px solid black !important;
            padding:1px;
        }

        .table-margin{
            margin-top: 70px;
            background: white;
            font-size: 10px;
            padding: 5px;
        }

        .mb-3{
            margin-bottom: 10px;
        }
        body{
            font-family: Arial;
        }
        @media  print
        {
            header, header *
            {
                display: none !important;
            }

            .table thead tr td,.table tbody tr td{
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                background-color: red;
                -webkit-print-color-adjust:exact ;
            }
            body{
                background-color: white !important;
            }

            #navigation{
                display: none;
            }

            #isi{
                margin:0px 0px !important;
            }

            .table-margin{
                margin-top: 0px;
            }
        }

        .ttd{
            height: 70px;
            width: 20%;
        }

        .dotted{
            border-bottom: 2px dotted gray;
            width: 100%;
            height: 1px;
            margin-bottom: 5px;
            margin-top: 10px;
            position: relative;
        }

        .fa-scissors{
            position: absolute;
            top: -10px;
            font-size: 20px;
            font-weight: 800
        }

        #navigation ul{
            float: right;
            padding-right: 110px;
        }

        #navigation ul li{
            color: #fff;
            font-size: 15pt;
            list-style-type: none;
            display: inline-block;
            margin-left: 40px;
        }
        body{
                font-family: Arial, Helvetica, sans-serif;
            }

    </style>
    <style type="text/css" media="print">
        #navigation{
            display: none;
        }

        .table-data td.total{
             background-color: #ccc !important;
             -webkit-print-color-adjust: exact;
        }

        .table-data td.not-same{
             color: red !important;
             -webkit-print-color-adjust: exact;
        }

        .page-break { display: block; page-break-before: always; }

    </style>
    <style type="text/css">
        #overlay, #overlay-load, #overlay-jurnal {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.6);
            z-index: 2500;
            display: none;
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px;
            margin-top: 200px;
        }
        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 51px;
            height: 51px;
            margin: 6px;
            border: 6px solid #cef;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #cef transparent transparent transparent;
        }
        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }
        @keyframes  lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" integrity="sha256-FdatTf20PQr/rWg+cAKfl6j4/IY3oohFAJ7gVC3M34E=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" integrity="sha256-zFnNbsU+u3l0K+MaY92RvJI6AdAVAxK3/QrBApHvlH8=" crossorigin="anonymous">
<style shopback-extension-v5-6-5="" data-styled-version="4.2.0"></style></head>

<body style="background: rgb(85, 85, 85);" class="">
    <div id="overlay-jurnal" class="text-center">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div> <br>
        <span style="color: white;">
            Sedang Mengenerate Excel. Harap Tunggu..
        </span>
    </div>
    <div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
        <div class="row">
            <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
                Andromart Cabang {{Auth::user()->employee->branch->name}}
            </div>
            <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
                <ul>
                    <li><i class="fa fa-file-excel" style="cursor: pointer;" id="btnExport" data-toggle="tooltip" data-placement="bottom" title="" onclick="excel()" data-original-title="Export Excel"></i></li>
                    <li><i class="fa fa-print"  onclick="cetak()" style="cursor: pointer;" id="print" title="Print Laporan"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="isi" class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
        <table style="width: 100%">
            <caption>
                <h3><b>Andromart | Laporan Stock Opname</b></h3>
            </caption>
        </table>
        <table style="width: 40%">
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Cabang</td>
                <td> : &nbsp; </td>
                <td> {{Auth::user()->employee->branch->name}} </td>
            </tr>
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Dikeluarkan oleh</td>
                <td> : &nbsp; </td>
                <td> {{Auth::user()->employee->name}} </td>
            </tr>
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Dikeluarkan tanggal</td>
                <td> : &nbsp; </td>
                <td> {{ date('D, d M Y') }} </td>
            </tr>
            @php
                $totalActiva = 0;
            @endphp
            @foreach ($activa as $activa)
                @php
                    $totalActiva += $activa->stock*$activa->hargabeli;
                @endphp
            @endforeach
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Total Aktifa Lancar</td>
                <td> : &nbsp; </td>
                <td> Rp. {{ number_format($totalActiva, 0, ".", ",") }} </td>
            </tr>
        </table>
        <br>
        <hr>
        <br>
        <div class="card-body">
            @foreach($category as $key => $el)
            <h4><strong> Kategori : {{$el->name}} </strong></h4>
            <table class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" width="6%" >{{ __('NO') }}</th>
                        <th class="text-center" width="44%">{{ __('Barang') }}</th>
                        <th class="text-center" width="5%">{{ __('Stok') }}</th>
                        <th class="text-center" width="5%">{{ __('Satuan') }}</th>
                        <th class="text-center" width="20%">{{ __('Harga Beli') }}</th>
                        <th class="text-center" width="20%">{{ __('Saldo') }}</th>
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
                        <td class="text-right">{{ $no++ }}</td>
                        <td>{{ $el1->merk }} {{ $el1->itemName }}</td>
                        <td class="text-center">{{ $el1->stock }}</td>
                        <td class="text-center">{{ $el1->satuan }}</td>
                        <td class="text-right">Rp. {{ number_format($el1->hargabeli, 0, ".", ",") }}</td>
                        <td class="text-right">Rp. {{ number_format($sumBuy, 0, ".", ",") }}</td>
                    </tr>
                </tbody>
                @endif
                @endforeach
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right"><h4>Total Barang : {{ $sumItem }} </h4></th>
                        <th colspan="3" class="text-right"><h4>Total Saldo : Rp. {{ number_format($sumActiva, 0, ".", ",") }}</h4></th>
                    </tr>
                </tfoot>
            </table>
            <br>
            @endforeach
        </div>
    </div>
    <div id="xlsDownload" style="display: none"></div>
    <script type="text/javascript">
        function excel(argument) {
            var blob = b64toBlob(btoa($('div[id=isi]').html()), "application/vnd.ms-excel");
            var blobUrl = URL.createObjectURL(blob);
            var dd = new Date();
            var ss = '' + dd.getFullYear() + "-" +
                (dd.getMonth() + 1) + "-" +
                (dd.getDate()) +
                "_" +
                dd.getHours() +
                dd.getMinutes() +
                dd.getSeconds();

            $("#xlsDownload").html("<a href=\"" + blobUrl + "\" download=\"Laporan Stock Opname\_" + ss + "\.xls\" id=\"xlsFile\">Downlaod</a>");
            $("#xlsFile").get(0).click();

            function b64toBlob(b64Data, contentType, sliceSize) {
                contentType = contentType || '';
                sliceSize = sliceSize || 512;

                var byteCharacters = atob(b64Data);
                var byteArrays = [];


                for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    var slice = byteCharacters.slice(offset, offset + sliceSize);

                    var byteNumbers = new Array(slice.length);
                    for (var i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }
                    var byteArray = new Uint8Array(byteNumbers);

                    byteArrays.push(byteArray);
                }

                var blob = new Blob(byteArrays, {
                    type: contentType
                });
                return blob;

            }
        }
        function cetak(params) {
            window.print();
        }
    </script>
</body>
</html>
