<html>

<head>
    <title>Laporan Penyusutan</title>
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
                    <li><i class="fa fa-align-justify" style="cursor: pointer;" onclick="$('#modal_buku_besar').modal('show')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tampilkan Setting Buku Besar"></i></li>
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
                <h3  class="text-center"><b>Laporan Penyusutan </b></h3>
                <h4  class="text-center"><b>Periode : {{ date('F Y') }}</b></h4>
            </caption>
        {{-- </table> --}}
        <br>
        <table class="table table-bordered table-sm" style="color: black;font-size:9px">
            <thead>
                <tr >
                    <th  class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Kode') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Nama/Barang') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Cabang') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Bulan Selesai') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Golongan') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Jenis Asset') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Status') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Tgl Per.') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Nilai Per.') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Nilai Awal Peny.') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Nilai Peny.') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Akml. Peny.') }}
                    </th>
                    <th  class="text-center">
                        {{ __('Nilai Buku') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPerolehan = 0;
                    $totalAwalPenyusutan = 0;
                    $totalPenyusutan = 0;
                    $totalAkumulasiPenyusutan = 0;
                    $totalNilaiPenyusutan = 0;
                @endphp
                @foreach ($data as $index => $el)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $el->code }}</td>
                        <td>{{ $el->items_id == null ? $el->items : $el->ItemsRel->items_id  }}</td>
                        <td>{{ $el->Branch->name }}</td>
                        <td>{{ $el->date_finished }}</td>
                        <td>{{ $el->Asset->name }}</td>
                        <td>{{ $el->activaGroup->name }}</td>
                        <td>{{ $el->status }}</td>
                        <td>{{ date('d-m-Y',strtotime($el->date_acquisition)) }}</td>
                        <th class="text-right">Rp. {{ number_format($el->total_acquisition, 0, '.', ',') }}</th>
                        <th class="text-right">Rp. {{ number_format($el->total_early_depreciation, 0, '.', ',') }}</th>
                        <th class="text-right">Rp. {{ number_format($el->total_depreciation, 0, '.', ',') }}</th>
                        <th class="text-right">Rp. {{ number_format($el->accumulation_depreciation, 0, '.', ',') }}</th>
                        <th class="text-right">Rp. {{ number_format($el->remaining_depreciation, 0, '.', ',') }}</th>
                    </tr>

                    @php
                        $totalPerolehan += $el->total_acquisition;
                        $totalAwalPenyusutan += $el->total_early_depreciation;
                        $totalPenyusutan += $el->total_depreciation;
                        $totalAkumulasiPenyusutan += $el->accumulation_depreciation;
                        $totalNilaiPenyusutan += $el->remaining_depreciation;
                    @endphp

                @endforeach

            </tbody>
            <tfoot>
                <th colspan="9"> Total</th>
                <th class="text-right">Rp. {{ number_format($totalPerolehan, 0, '.', ',') }}</th>
                <th class="text-right">Rp. {{ number_format($totalAwalPenyusutan, 0, '.', ',') }}</th>
                <th class="text-right">Rp. {{ number_format($totalPenyusutan, 0, '.', ',') }}</th>
                <th class="text-right">Rp. {{ number_format($totalAkumulasiPenyusutan, 0, '.', ',') }}</th>
                <th class="text-right">Rp. {{ number_format($totalNilaiPenyusutan, 0, '.', ',') }}</th>
            </tfoot>
        </table>

        <hr>
    </div>
    <div id="modal_buku_besar" class="modal" style="display: none;">
        <div class="modal-dialog" style="width: 40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Filter Laporan Aktiva</h4>
                    <input type="hidden" class="parrent">
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div class="row">
                        <form id="filter_form" action="">
                            {{-- <div class="col-sm-12 mb-3">
                                <label>Tanggal Awal</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                    name="dtpickermnth" id="dtpickermnth" />
                                </div>
                            </div> --}}
                            <div class="col-sm-12 mb-3">
                                <label>cabang</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="">- Select -</option>
                                        @foreach ($branch as $el)
                                            <option value="{{$el->id}}">{{$el->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cari()" class="btn btn-primary btn-sm" id="proses_buku_besar">cari</button>
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
        function cari(params) {
            var branch = $("#branch_id").val();
            window.location.href = '{{ route('activa.excel-view') }}?&branch='+branch;
        }
    </script>

</body>

</html>
