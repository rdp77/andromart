<html>

<head>
    <title>Laporan Laba Rugi</title>
    <link href="https://panel.jpmandiri.com/assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

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
            font-family: Arial, Helvetica, sans-serif;
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
                Andromart Indonesia
            </div>
            <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
                <ul>
                    {{-- <li><i class="fa fa-align-justify" style="cursor: pointer;" onclick="$('#modal_buku_besar').modal('show')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tampilkan Setting Buku Besar"></i></li> --}}
                    <li><i class="fa fa-file-excel" style="cursor: pointer;" id="btnExport" data-toggle="tooltip"
                            data-placement="bottom" title="" onclick="excel()"
                            data-original-title="Export Excel"></i></li>
                    <li><i class="fa fa-print" onclick="cetak()" style="cursor: pointer;" id="print"
                            title="Print Laporan"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="isi" class="col-md-10 col-md-offset-1"
        style="background: white; padding: 10px 15px; margin-top: 80px;">
        {{-- <table style="width: 100%"> --}}
        <caption>
            <h2 class="text-center"><b>ANDROMART INDONESIA </b></h2>
            <h3 class="text-center"><b>Laporan Neraca </b></h3>
            <h3 class="text-center" style="margin: auto"><b>
            @if ($branch == '')
                Seluruh Cabang
            @else
                Cabang {{$checkBranch->name}}
            @endif    
            </b></h3>
            <h4 class="text-center"><b>Periode : {{ date('t F Y') }}</b></h4>
        </caption>
        {{-- </table> --}}
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row" style="padding: 10px">
                    <br>
                    <table style="border-collapse:collapse;width:100%">
                        <thead>
                            <tr>
                                <th style="border-top: 1px solid black">
                                    <br>
                                    <br>
                                </th>
                                <th style="border-left: 1px solid black;border-top: 1px solid black">
                                    <br>
                                    <br>

                                </th>
                                <th style="border-top: 1px solid black">
                                    <br>
                                    <br>

                                </th>
                            </tr>
                            <tr>
                                <th width="49%">Aktiva
                                    Lancar
                                </th>
                                <th style="border-left: 1px solid black;" rowspan="100">

                                </th>
                                <th width="49%" style="padding-left:30px">Utang
                                    Lancar
                                </th>
                            </tr>

                            <tr>
                                <td style="padding-left:30px;">
                                    <table style="margin-top: 20px;">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <b>KAS</b>
                                            </td>
                                            {{-- <td> --}}
                                            {{-- <b>Rp.</b> --}}
                                            {{-- </td> --}}
                                            <td style="padding-left:0px;text-align:right;padding-right:30px"">
                                                <b>{{ number_format($dataKasTotal, 0, ',', ',') }}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        @php
                                                $namaPerkas;
                                                $totalPerkas = 0;
                                            @endphp
                                        @for ($i = 0; $i < count($dataKas); $i++)
                                            
                                            {{-- @for ($j = 0; $j < count($dataKas); $j++)
                                                @if ($accountDataKas[$i]['id'] == $dataKas[$j]['akun_id'])
                                                    
                                                @endif
                                            @endfor --}}
                                            @php
                                                $totalPerkas += $dataKas[$i]['total'];
                                            @endphp

                                            <tr>
                                                <td style="padding-left:50px;padding-top:10px">
                                                    <input type="text" value="{{ $dataKas[$i]['akun_nama'] }}"
                                                        disabled
                                                        style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:450px">
                                                </td>
                                                {{-- <td style="padding-top:10px">Rp.</td> --}}
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <input type="text"
                                                        value="{{ number_format($dataKas[$i]['total'], 0, ',', ',') }}" disabled
                                                        style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">

                                                </td>
                                            </tr>
                                        @endfor
                                    </table>
                                <td style="padding-left: 30px;">

                                    <br><br>
                                    <b>Liabilitas</b>
                                    <table style="margin-top: 20px;">
                                        <tr>
                                        </tr>
                                    </table>
                                    <table>
                                        <tbody>
                                            {{-- DATA MODAL --}}
                                            <tr>
                                                <td style="padding-left:40px;"><b>Pendapatan Dimuka</b></td>
                                                <td style="padding-left:0px;text-align:right;padding-right:30px">
                                                    <b>{{ number_format($dataPendapatanDimukaTotal, 0, ',', ',') }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            @for ($i = 0; $i < count($dataPendapatanDimuka); $i++)
                                                @php
                                                @endphp
                                                <tr>
                                                    <td style="padding-left:80px;padding-top:10px">
                                                        <input type="text" value="{{ $dataPendapatanDimuka[$i]['akun_nama'] }}"
                                                            disabled
                                                            style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:350px">
                                                    </td>

                                                    <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                        <input type="text"
                                                            value="{{ number_format($dataPendapatanDimuka[$i]['total'], 0, ',', ',') }}"
                                                            disabled
                                                            style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                    <b>Ekuitas</b>
                                    <table style="margin-top: 20px;">
                                        <tr>
                                        </tr>
                                    </table>
                                    <table>
                                        <tbody>
                                            {{-- DATA MODAL --}}
                                            <tr>
                                                <td style="padding-left:40px;"><b>Modal</b></td>
                                                <td style="padding-left:0px;text-align:right;padding-right:30px">
                                                    <b>{{ number_format($dataModalTotal, 0, ',', ',') }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            @for ($i = 0; $i < count($dataModal); $i++)
                                                @php
                                                @endphp
                                                <tr>
                                                    <td style="padding-left:80px;padding-top:10px">
                                                        <input type="text" value="{{ $dataModal[$i]['akun_nama'] }}"
                                                            disabled
                                                            style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:350px">
                                                    </td>

                                                    <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                        <input type="text"
                                                            value="{{ number_format($dataModal[$i]['total'], 0, ',', ',') }}"
                                                            disabled
                                                            style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                    </td>
                                                </tr>
                                            @endfor

                                           

                                        </tbody>
                                    </table>
                                </td>
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:30px;">
                                    <table style="margin-top:10px">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <b>Persediaan</b>
                                            </td>
                                            <td style="text-align:right;padding-right:32px">
                                                <b>
                                                    @if ($dataPersediaanTotal < 0)
                                                        (
                                                        {{ number_format(abs($dataPersediaanTotal), 0, ',', ',') }} )
                                                    @else
                                                        {{ number_format($dataPersediaanTotal, 0, ',', ',') }}
                                                    @endif
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        @for ($i = 0; $i < count($dataPersediaan); $i++)
                                            @php
                                                // $dataPersediaan = 0;
                                            @endphp
                                            <tr>
                                                <td style="padding-left:50px;padding-top:10px">
                                                    <input type="text"
                                                        value="
                                                        {{ $dataPersediaan[$i]['akun_nama'] }}"
                                                        disabled
                                                        style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:450px">
                                                </td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <input type="text"
                                                        value="
                                                        @if ($dataPersediaan[$i]['total'] < 0) (
                                                            {{ number_format(abs($dataPersediaan[$i]['total']), 0, ',', ',') }} )
                                                        @else
                                                            {{ number_format($dataPersediaan[$i]['total'], 0, ',', ',') }} @endif"
                                                        disabled
                                                        style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                </td>

                                            </tr>
                                        @endfor
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:30px;">
                                    <table style="margin-top:10px">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <b>Uang Dimuka</b>
                                            </td>
                                            <td style="text-align:right;padding-right:32px">
                                                <b>
                                                    @if ($dataUangDimukaTotal < 0)
                                                        (
                                                        {{ number_format(abs($dataUangDimukaTotal), 0, ',', ',') }} )
                                                    @else
                                                        {{ number_format($dataUangDimukaTotal, 0, ',', ',') }}
                                                    @endif
                                                </b>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        @for ($i = 0; $i < count($dataUangDimuka); $i++)
                                            @php
                                                // $dataUangDimuka = 0;
                                            @endphp
                                            <tr>
                                                <td style="padding-left:50px;padding-top:10px">
                                                    <input type="text"
                                                        value="
                                                        {{ $dataUangDimuka[$i]['akun_nama'] }}"
                                                        disabled
                                                        style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:450px">
                                                </td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <input type="text"
                                                        value="
                                                        @if ($dataUangDimuka[$i]['total'] < 0) (
                                                            {{ number_format(abs($dataUangDimuka[$i]['total']), 0, ',', ',') }} )
                                                        @else
                                                            {{ number_format($dataUangDimuka[$i]['total'], 0, ',', ',') }} @endif"
                                                        disabled
                                                        style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                </td>

                                            </tr>
                                        @endfor
                                    </table>
                                    <td>
                                        <table>
                                             {{-- DATA SALDO LABA --}}
                                             <tr>
                                                <td><br></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:40px;"><b>Saldo Laba</b></td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <b>{{ number_format(0, 0, ',', ',') }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><br></td>
                                            </tr>
                                            {{-- DATA LABA TERTAHAN --}}
                                            <tr>
                                                <td style="padding-left:40px;"><b>Laba Berjalan</b></td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <b>
                                                        <input type="text"
                                                            value="
                                                            @if ($labaBerjalan < 0) ({{ number_format(abs($labaBerjalan), 0, ',', ',') }})
                                                            @else
                                                            {{ number_format($labaBerjalan, 0, ',', ',') }} @endif"
                                                            disabled
                                                            style="border: none;font-size:15px;font-weight:bold;background-color:transparent;width:520px;text-align:right">
                                                    </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:30px;">
                                    <table style="margin-top:10px">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <b>Mutasi / Transfer</b>
                                            </td>
                                            <td style="text-align:right;padding-right:32px">
                                                <b>
                                                    @if ($dataMutasiTransferTotal < 0)
                                                        (
                                                        {{ number_format(abs($dataMutasiTransferTotal), 0, ',', ',') }} )
                                                    @else
                                                        {{ number_format($dataMutasiTransferTotal, 0, ',', ',') }}
                                                    @endif
                                                </b>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        @for ($i = 0; $i < count($dataMutasiTransfer); $i++)
                                            @php
                                                // $dataMutasiTransfer = 0;
                                            @endphp
                                            <tr>
                                                <td style="padding-left:50px;padding-top:10px">
                                                    <input type="text"
                                                        value="
                                                        {{ $dataMutasiTransfer[$i]['akun_nama'] }}"
                                                        disabled
                                                        style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:450px">
                                                </td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <input type="text"
                                                        value="
                                                        @if ($dataMutasiTransfer[$i]['total'] < 0) (
                                                            {{ number_format(abs($dataMutasiTransfer[$i]['total']), 0, ',', ',') }} )
                                                        @else
                                                            {{ number_format($dataMutasiTransfer[$i]['total'], 0, ',', ',') }} @endif"
                                                        disabled
                                                        style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                </td>

                                            </tr>
                                        @endfor
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <th width="49%">Aktiva
                                    Tetap
                                </th>
                            </tr>
                            <tr>
                                <td style="padding-left:30px;">
                                    <table style="margin-top: 20px;">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <b>Asset</b>
                                            </td>
                                            <td style="text-align:right;padding-right:35px">
                                                <b>{{ number_format($dataAssetTotal, 0, ',', ',') }}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        @for ($i = 0; $i < count($dataAsset); $i++)
                                            @php
                                                // $dataAsset = 0;
                                            @endphp
                                            <tr>
                                                <td style="padding-left:50px;">
                                                    <input type="text" value="{{ $dataAsset[$i]['akun_nama'] }}"
                                                        disabled
                                                        style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:450px">
                                                </td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <input type="text"
                                                        value="
                                                        @if ($dataAsset[$i]['total'] < 0) (
                                                            {{ number_format(abs($dataAsset[$i]['total']), 0, ',', ',') }} )
                                                        @else
                                                            {{ number_format($dataAsset[$i]['total'], 0, ',', ',') }} @endif"
                                                        disabled
                                                        style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                </td>
                                            </tr>
                                        @endfor
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <th><br></th>
                            </tr>
                            <tr>
                                <td style="padding-left:30px;">
                                    <table style="margin-bottom: 30px;">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <b>Penyusutan</b>
                                            </td>
                                            <td style="text-align:right;padding-right:35px">
                                                <b>
                                                    @if ($dataPenyusutanTotal < 0)
                                                        ({{ number_format(abs($dataPenyusutanTotal), 0, ',', ',') }})
                                                    @else
                                                        ({{ number_format($dataPenyusutanTotal, 0, ',', ',') }})
                                                    @endif
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        @for ($i = 0; $i < count($dataPenyusutan); $i++)
                                            @php
                                                // $dataPenyusutan = 0;
                                            @endphp
                                            <tr>
                                                <td style="padding-left:50px;">
                                                    <input type="text"
                                                        value="{{ $dataPenyusutan[$i]['akun_nama'] }}" disabled
                                                        style="border: none;font-size:12px;font-weight:bold;background-color:transparent;width:450px">
                                                </td>
                                                <td style="text-align:right;padding-top:10px;padding-right:30px">
                                                    <input type="text"
                                                        value="
                                                        @if ($dataPenyusutan[$i]['total'] < 0) (
                                                            {{ number_format(abs($dataPenyusutan[$i]['total']), 0, ',', ',') }} )
                                                        @else
                                                            {{ number_format($dataPenyusutan[$i]['total'], 0, ',', ',') }} @endif"
                                                        disabled
                                                        style="border: none;font-size:13px;font-weight:bold;background-color:transparent;width:200px;text-align:right">
                                                </td>
                                            </tr>
                                        @endfor
                                    </table>

                                </td>
                            </tr>
                            </tr>
                        </thead>

                    </table>
                    <table style="width:100%;">
                        <thead>
                            <tr style="color:black;border-top: 1px solid black">
                                <th style="width:50%">
                                    <table style="margin-top: 30px;">
                                        <tr>
                                            <th>TOTAL</th>
                                            <th style="padding-left:540px;">Rp.
                                                {{ number_format($dataPersediaanTotal + $dataKasTotal + $dataUangDimukaTotal - $dataPenyusutanTotal + $dataAssetTotal + $dataMutasiTransferTotal, 0, ',', ',') }}
                                            </th>
                                        </tr>
                                    </table>
                                </th>
                                <th style="width:50%;padding-top: 30px;padding-left:60px;">
                                    <table>
                                        <tr>
                                            <th>TOTAL</th>
                                            <th style="padding-left:452px;">Rp.
                                                {{ number_format($dataModalTotal + $labaBerjalan + $dataPendapatanDimukaTotal, 0, ',', ',') }}
                                            </th>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <hr>
    </div>
    <div id="modal_buku_besar" class="modal" style="display: none;">
        <div class="modal-dialog" style="width: 40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Filter Laporan Absensi</h4>
                    <input type="hidden" class="parrent">
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div class="row">
                        <form id="filter_form" action="">
                            <div class="col-sm-12 mb-3">
                                <label>Tanggal Awal</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control dtpickermnth"
                                        value="{{ date('F Y') }}" name="dtpickermnth" id="dtpickermnth" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cari()" class="btn btn-primary btn-sm"
                        id="proses_buku_besar">Proses</button>
                </div>
            </div>
        </div>
    </div>
    <div id="xlsDownload" style="display: none"></div>

    <script type="text/javascript" src="https://panel.jpmandiri.com/assets/vendors/bootstrap/js/bootstrap.min.js"></script>

    <!-- datepicker  -->
    <script src="https://panel.jpmandiri.com/assets/vendors/daterangepicker/moment.min.js"></script>
    <script src="https://panel.jpmandiri.com/assets/vendors/datapicker/bootstrap-datepicker.js"></script>
    <script src="https://panel.jpmandiri.com/assets/vendors/daterangepicker/daterangepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Toastr -->
    <script src="https://panel.jpmandiri.com/assets/vendors/toastr/toastr.min.js"></script>

    <script src="https://panel.jpmandiri.com/assets/js/chosen/chosen.jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });

            baseUrl = 'https://panel.jpmandiri.com';

            // script for buku besar

            // export excel---------------------------------------------------
        });

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

            $("#xlsDownload").html("<a href=\"" + blobUrl + "\" download=\"Laporan Penyusutan\_" + ss +
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
