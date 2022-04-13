<html>
<head>
    <title>Andromart | {{ $title }}</title>
    <link href="https://panel.jpmandiri.com/assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- datepicker -->
    <link href="https://panel.jpmandiri.com/assets/vendors/datapicker/datepicker3.css" rel="stylesheet">
    <link href="https://panel.jpmandiri.com/assets/vendors/daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="https://panel.jpmandiri.com/assets/vendors/toastr/toastr.min.css" rel="stylesheet">
    <link href="https://panel.jpmandiri.com/assets/css/chosen/chosen.css" rel="stylesheet">
    <script type="text/javascript" src="https://panel.jpmandiri.com/assets/plugins/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <style>
        .height {
            background: white;
            height: 100%;
        }

        .pt-2 {
            padding-top: 20px;
        }

        .pl-2 {
            padding-top: 20px;
        }

        .pr-2 {
            padding-right: 20px !important;
        }

        .width-10 {
            width: 10%;
        }

        .width-20 {
            width: 20%;
        }

        .border-black {
            border: 1px solid #9999;
        }

        .box-git {
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

        .mt-1 {
            margin-top: 10px !important;
        }

        .mt-2 {
            margin-top: 20px !important;
        }

        .mb-1 {
            margin-bottom: 10px !important;
        }

        .mb-2 {
            margin-bottom: 20px !important;
        }

        .mr-1 {
            margin-right: 10px !important;
        }

        .mr-2 {
            margin-right: 20px !important;
        }

        .ml-1 {
            margin-left: 10px !important;
        }

        .ml-2 {
            margin-left: 20px !important;
        }

        .grey {
            color: grey;
        }

        .width-100 {
            width: 100%;
        }

        .none {
            text-decoration: none;
            list-style-type: none;
        }

        .d-inline-block {
            display: inline-block;
            vertical-align: middle;
        }

        .d-inline {
            display: inline;
            vertical-align: middle;
        }

        .d-inline li {
            display: inline;
        }

        .m-auto {
            margin: auto;
        }

        .nav-tabs li a {
            padding-left: 0 !important;
            padding-right: 0 !important;
            text-align: center !important;
        }

        .font-small {
            font-size: 12px;
        }

        .middle {
            height: 47px;
        }

        .black {
            color: black;
        }

        .head {
            background: grey !important;
            color: white;
            width: 100%;
            height: 100%;
            vertical-align: middle;
        }

        .mt-5 {
            margin-top: 50px
        }

        .head_awal {
            background-color: black !important;
            color: white;
            `
        }

        .head_awal1 {
            background-color: black !important;
            color: white;
            `
        }

        .head_awal2 {
            background-color: black !important;
            color: white;
            `
        }

        .hide {
            display: none;
        }

        .disabled {
            pointer-events: none;
        }

        .tree tr {
            border: hidden;
        }

        .tree_1 tr {
            border: hidden;
        }

        hr {
            border-top: 1px solid black;
            margin-top: 2px;
            margin-bottom: 0px;
        }

        .text-right {
            border: none;
        }

        .text-right {
            border: none;
        }

        .border-right-none {
            border-right: none !important;
        }

        .border-none {
            border: none !important;
        }

        .table-border td {
            border: 1px solid black !important;
            padding: 1px;
        }

        .table-margin {
            margin-top: 70px;
            background: white;
            font-size: 10px;
            padding: 5px;
        }

        .mb-3 {
            margin-bottom: 10px;
        }

        body {
            font-family: Arial;
        }

        @media print {

            header,
            header * {
                display: none !important;
            }

            .table thead tr td,
            .table tbody tr td {
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                background-color: red;
                -webkit-print-color-adjust: exact;
            }

            body {
                background-color: white !important;
            }

            #navigation {
                display: none;
            }

            #isi {
                margin: 0px 0px !important;
            }

            .table-margin {
                margin-top: 0px;
            }
        }

        .ttd {
            height: 70px;
            width: 20%;
        }

        .dotted {
            border-bottom: 2px dotted gray;
            width: 100%;
            height: 1px;
            margin-bottom: 5px;
            margin-top: 10px;
            position: relative;
        }

        .fa-scissors {
            position: absolute;
            top: -10px;
            font-size: 20px;
            font-weight: 800
        }

        #navigation ul {
            float: right;
            padding-right: 110px;
        }

        #navigation ul li {
            color: #fff;
            font-size: 15pt;
            list-style-type: none;
            display: inline-block;
            margin-left: 40px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

    </style>
    <style type="text/css" media="print">
        #navigation {
            display: none;
        }

        .table-data td.total {
            background-color: #ccc !important;
            -webkit-print-color-adjust: exact;
        }

        .table-data td.not-same {
            color: red !important;
            -webkit-print-color-adjust: exact;
        }

        .page-break {
            display: block;
            page-break-before: always;
        }

    </style>
    <style type="text/css">
        #overlay,
        #overlay-load,
        #overlay-jurnal {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
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

        @keyframes lds-ring {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css"
        integrity="sha256-FdatTf20PQr/rWg+cAKfl6j4/IY3oohFAJ7gVC3M34E=" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css"
        integrity="sha256-zFnNbsU+u3l0K+MaY92RvJI6AdAVAxK3/QrBApHvlH8=" crossorigin="anonymous">
    <style shopback-extension-v5-6-5="" data-styled-version="4.2.0"></style>
</head>

<body style="background: rgb(85, 85, 85);" class="">
    <div id="overlay-jurnal" class="text-center">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div> <br>
        <span style="color: white;">
            Sedang Mengenerate Excel. Harap Tunggu..
        </span>
    </div>
    <div class="col-md-12" id="navigation"
        style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
        <div class="row">
            <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
                Andromart
            </div>
            <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
                <ul>
                    <li><i class="fa fa-file-excel" style="cursor: pointer;" id="btnExport" data-toggle="tooltip"
                            data-placement="bottom" title="" onclick="excel()" data-original-title="Export Excel"></i>
                    </li>
                    <li><i class="fa fa-print" style="cursor: pointer;" id="print" title="Print Laporan" onclick="cetak()"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="isi" class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
        <table style="width: 100%">
            <caption>
                <h3><b>Andromart | {{ $title }}</b></h3>
            </caption>
        </table>
        <table style="width: 60%">
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Cabang</td>
                <td> : &nbsp; </td>
                <td> {{ Auth::user()->employee->branch->name }} </td>
            </tr>
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Dikeluarkan oleh</td>
                <td> : &nbsp; </td>
                <td> {{ Auth::user()->employee->name }} </td>
            </tr>
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Dikeluarkan pada tanggal</td>
                <td> : &nbsp; </td>
                <td> {{ date('D, d M Y') }} </td>
            </tr>
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Periode</td>
                <td> : &nbsp; </td>
                <td> {{ $periode }} </td>
            </tr>
            <tr>
                <td style="font-weight: bold;color: #A9A9A9">Filter {{ $subtitle }}</td>
                <td> : &nbsp; </td>
                <td> {{ $val }} </td>
            </tr>
        </table>
        <br>
        <hr>
        <br>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="">Tanggal</th>
                    <th class="text-center" width="">Faktur</th>
                    <th class="text-center" width="25%">Barang</th>
                    <th class="text-center" width="">Supplier</th>
                    <th class="text-center" width="">Pembayaran</th>
                    {{-- <th class="text-center" width="">Operator</th> --}}
                    <th class="text-center" width="15%">Jumlah</th>
                </tr>
            </thead>
            @foreach($data as $key => $value)
            <tbody class="dropHere" style="border: none !important">
                <tr>
                    <td>{{ $value->date }}</td>
                    <td>{{ $value->code }}</td>
                    <td>
                        @foreach ($value->purchasingDetail as $as => $pd)
                            {{ $pd->qty }}x {{ $pd->item->name }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($value->purchasingDetail as $qw => $pds)
                            {{ $pds->item->supplier->name }}
                        @endforeach
                    </td>
                    <td>
                        @if ($value->status = 'paid')
                            LUNAS
                        @else
                            HUTANG
                        @endif
                    </td>
                    {{-- <td>{{ $value->employee->name }}</td> --}}
                    <td class="text-right">Rp. {{ number_format($value->price, 0, '.', ',') }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
        <table class="table table-bordered" style="color: black;border:1px solid black">
            <thead>
                <tr style="color: #6777ef">
                    <th class="text-left" width="50%"><h4>Jumlah Transaksi : {{ $tr }}</h4></th>
                    <th class="text-right" width="50%"><h4>Total Pengeluaran : Rp. {{ number_format($sumBayar, 0, '.', ',') }}</h4></th>
                </tr>
            </thead>
        </table>
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

            $("#xlsDownload").html("<a href=\"" + blobUrl + "\" download=\"Laporan Transaksi\_" + ss +
                "\.xls\" id=\"xlsFile\">Downlaod</a>");
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
