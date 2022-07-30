<html><head>
    <title>Laporan Laba Rugi</title>
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
            font-family: Arial, Helvetica, sans-serif;
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
                Andromart Indonesia
            </div>
            <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
                <ul>
                    {{-- <li><i class="fa fa-align-justify" style="cursor: pointer;" onclick="$('#modal_buku_besar').modal('show')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tampilkan Setting Buku Besar"></i></li> --}}
                    <li><i class="fa fa-file-excel" style="cursor: pointer;" id="btnExport" data-toggle="tooltip" data-placement="bottom" title="" onclick="excel()" data-original-title="Export Excel"></i></li>
                    <li><i class="fa fa-print"  onclick="cetak()" style="cursor: pointer;" id="print" title="Print Laporan"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="isi" class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
        <table style="width: 100%">
            <caption>
                <h3><b>Laporan Laba Rugi </b></h3>
            </caption>
        </table>
        <br>
        <table class="table table-bordered table-sm" style="color: black">
            <thead>
                <tr>
                    <th colspan="3" style="color:black">Pendapatan
                    </th>
                </tr>

                <tr>
                    <td>Service
                        <table>
                            <tr>
                                <td
                                    style="border:0px solid black !important;padding-left:40px;">
                                    Diskon Service</td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: right"><br> <b>Rp.
                            {{ number_format($DiskonService, 0, '.', ',') }}</b>
                    <td style="text-align: right">
                        <b>Rp.
                            {{ number_format($totalService, 0, '.', ',') }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Penjualan
                        <table>
                            <tr>
                                <td
                                    style="border:0px solid black !important;padding-left:40px;">
                                    Diskon Penjualan</td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: right"><br> <b>Rp.
                            {{ number_format($DiskonPenjualan, 0, '.', ',') }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>Rp.
                            {{ number_format($totalPenjualan, 0, '.', ',') }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Pendapatan Lain-Lain
                        <table>
                            @for ($i = 0; $i < count($dataPendapatanLainLain); $i++)
                                <tr>
                                    <td
                                        style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                        @php
                                            echo $dataPendapatanLainLain[$i]['namaAkun'];
                                        @endphp
                                    </td>
                                </tr>
                            @endfor
                        </table>
                        Total Pendapatan Lain-Lain
                    </td>
                    <td style="text-align: right">
                        <table style="width: 100%;text-align:left">
                            <b><br></b>
                            @php
                                $totalPendapatanLainLain = 0;
                            @endphp
                            @for ($i = 0; $i < count($dataPendapatanLainLain); $i++)
                                <tr>
                                    <td
                                        style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                        {{ number_format($dataPendapatanLainLain[$i]['total'], 0, ',', ',') }}
                                        @php
                                            $totalPendapatanLainLain += $dataPendapatanLainLain[$i]['total'];
                                        @endphp
                                </tr>
                            @endfor
                        </table>
                        <b>Rp.
                            {{ number_format($totalPendapatanLainLain, 0, '.', ',') }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Pendapatan Kotor</td>
                    <td></td>
                    <td style="text-align: right"><b>Rp.
                            {{ number_format($totalPenjualan + $totalPendapatanLainLain + $totalService - $DiskonPenjualan - $DiskonService, 0, '.', ',') }}</b>
                    </td>
                </tr>
                {{-- <tr>
                    <td style="padding-left: 50px">Total Service</td>
                    <td></td>
                    <td style="text-align: right"><b>Rp.
                        {{ number_format($totalService, 0, '.', ',') }}</b></td>
                <tr>
                    <td style="padding-left: 50px">Total Penjualan</td>
                    <td></td>
                    <td style="text-align: right"><b>Rp.
                        {{ number_format($totalPenjualan, 0, '.', ',') }}</b></td>
                <tr> --}}
                {{-- <td style="padding-left: 50px">Diskon</td>
                    <td style="text-align: right"><b>Rp.
                            {{ number_format($Diskon, 0, '.', ',') }}</b></td>
                    <td></td> --}}
                <tr>
                    <td style="padding-left: 50px">HPP</td>
                    <td style="text-align: right"><b>Rp.
                            {{ number_format($HPP, 0, '.', ',') }}</b>
                    </td>
                    <td></td>
                <tr>
                    <th colspan="1" style="background-color: #ffffdc;color:black">Laba Kotor
                    </th>
                    <td style="text-align: right;background-color: #ffffdc"></td>
                    <td style="text-align: right;background-color: #ffffdc;color:black"><b>Rp.
                            {{ number_format($totalPenjualan + $totalPendapatanLainLain+ $totalService - $DiskonPenjualan - $DiskonService - $HPP, 0, '.', ',') }}</b>
                    </td>
                </tr>
                @php
                    $labaKotor = $totalPendapatanLainLain + $totalPenjualan + $totalService - $DiskonPenjualan - $DiskonService - $HPP;
                @endphp
                {{-- <tr>
                    <th colspan="3" style="color:black;text-align:center">Beban Usaha
                    </th>
                </tr> --}}
                <tr>
                    <th colspan="3" style="color:black">Beban</th>
                </tr>
                <tr>
                    <td>Sharing Profit</td>
                    <td style="text-align: right"><b>Rp.
                            {{ number_format($sharingProfit, 0, '.', ',') }}</b>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Beban Umum Lain
                        <table>
                            @for ($i = 0; $i < count($dataBeban); $i++)
                                <tr>
                                    <td
                                        style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                        @php
                                            if (!str_contains($dataBeban[$i]['namaAkun'], 'Fee Back Office') && !str_contains($dataBeban[$i]['namaAkun'], 'Sharing Profit') && !str_contains($dataBeban[$i]['namaAkun'], 'Mutasi') && !str_contains($dataBeban[$i]['namaAkun'], 'Transfer') && !str_contains($dataBeban[$i]['namaAkun'], 'Biaya HPP')) {
                                                echo $dataBeban[$i]['namaAkun'];
                                                # code...
                                            }
                                        @endphp
                                    </td>
                                </tr>
                            @endfor
                        </table>
                        Total Beban Umum Lain
                    </td>
                    <td style="text-align: right">
                        <table style="width: 100%;text-align:left">
                            <b><br></b>
                            @php
                                $totalDataBeban = 0;
                            @endphp
                            @for ($i = 0; $i < count($dataBeban); $i++)
                                <tr>
                                    <td
                                        style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                        @php
                                            if (!str_contains($dataBeban[$i]['namaAkun'], 'Fee Back Office') && !str_contains($dataBeban[$i]['namaAkun'], 'Sharing Profit') && !str_contains($dataBeban[$i]['namaAkun'], 'Mutasi') && !str_contains($dataBeban[$i]['namaAkun'], 'Transfer') && !str_contains($dataBeban[$i]['namaAkun'], 'Biaya HPP')) {
                                                echo 'Rp.' . number_format($dataBeban[$i]['total'], 0, ',', ',');
                                                $totalDataBeban += $dataBeban[$i]['total'];
                                            }

                                        @endphp
                                </tr>
                            @endfor
                        </table>
                        <b>Rp.
                            {{ number_format($totalDataBeban, 0, '.', ',') }}</b>
                    </td>
                </tr>
                <tr>
                    <th colspan="1" style="background-color: #ffffdc;color:black">Total Beban
                        Operasional
                    </th>
                    <td style="text-align: right;background-color: #ffffdc;color:black"><b>Rp.
                            {{ number_format($totalDataBeban + $sharingProfit, 0, '.', ',') }}</b>
                    </td>
                    <td style="text-align: right;background-color: #ffffdc"></td>
                </tr>
                <tr>
                    <th colspan="3" style="color:black">Biaya Umum</th>
                </tr>

                <tr>
                    <td>Gaji Karyawan</td>
                    <td style="text-align: right"><b>Rp.
                            {{ number_format($gaji, 0, '.', ',') }}</b>
                    </td>
                    <td></td>

                </tr>
                <tr>
                    <td>
                        <table>
                            Biaya Umum Lain
                            @for ($i = 0; $i < count($dataBiaya); $i++)
                                <tr>
                                    <td
                                        style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                        @php
                                            echo $dataBiaya[$i]['namaAkun'];
                                        @endphp
                                    </td>
                                </tr>
                            @endfor
                        </table>
                        Total Biaya Umum Lain
                    </td>
                    <td style="text-align: right">
                        <table style="width: 100%;text-align:left">
                            <b><br></b>
                            @php
                                $totalDataBiaya = 0;
                            @endphp
                            @for ($i = 0; $i < count($dataBiaya); $i++)
                                <tr>
                                    <td
                                        style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                        Rp.
                                        {{ number_format($dataBiaya[$i]['total'], 0, ',', ',') }}
                                        @php
                                            $totalDataBiaya += $dataBiaya[$i]['total'];
                                        @endphp
                                </tr>
                            @endfor
                        </table>
                        <b>Rp.
                            {{ number_format($totalDataBiaya, 0, '.', ',') }}</b>
                    </td>
                    <td></td>

                </tr>

                <tr>
                    <th colspan="1" style="background-color: #ffffdc;color:black">Total Beban
                        Administrasi
                    </th>
                    <td style="text-align: right;background-color: #ffffdc;color:black"><b>Rp.
                            {{ number_format($totalDataBiaya, 0, '.', ',') }}</b>
                    </td>
                    <td style="text-align: right;background-color: #ffffdc"></td>
                </tr>
                <tr>
                    <th colspan="2" style="background-color: yellow;color:black">Laba Bersih

                    </th>
                    <td style="text-align: right;background-color: yellow;color:black"><b>Rp.
                            {{ number_format($labaKotor - $totalDataBeban - $sharingProfit - $totalDataBiaya - $gaji, 0, '.', ',') }}</b>
                    </td>
                </tr>
            </thead>
        </table>

        <hr>
    </div>
    <div id="modal_buku_besar" class="modal" style="display: none;">
        <div class="modal-dialog" style="width: 40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
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
                                    <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                    name="dtpickermnth" id="dtpickermnth" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cari()" class="btn btn-primary btn-sm" id="proses_buku_besar">Proses</button>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
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

        $("#xlsDownload").html("<a href=\"" + blobUrl + "\" download=\"Laporan Labar Rugi\_" + ss + "\.xls\" id=\"xlsFile\">Downlaod</a>");
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
