@extends('layouts.backend.default')
@section('title', __('pages.title') . __('Laporan Laba Rugi'))
@section('titleContent', __('Laporan Laba Rugi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Laporan Laba Rugi') }}</div>
@endsection

@section('content')
    {{-- @include('pages.backend.components.filterSearch') --}}
    @include('layouts.backend.components.notification')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }

        .table.table-bordered {
            border: 1px solid black !important;
            margin-top: 20px;
        }

        .table.table-bordered td {
            border: 1px solid #9a9a9a !important;
        }

        .table.table-bordered>thead>tr>th {
            border: 1px solid black !important;
        }

    </style>
    <form class="form-data">
        @csrf
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">Periode Bulan <b class="dropMonth">{{ date('F Y') }}</b> </h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-10  mb-1 mr-10">
                                        <label for="inputPassword2" class="sr-only">Bulan</label>
                                        <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                            name="dtpickermnth" id="dtpickermnth" />
                                    </div>
                                    <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                        style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                                    <button class="btn btn-primary tombol ml-2" onclick="cetakData()" type="button"
                                    style="margin-bottom: 6px"><i class="fas fa-print"></i> Cetak</button>
                                    {{-- <button class="btn btn-primary tombol ml-2" onclick="closeAll()" type="button" --}}
                                    {{-- style="margin-bottom: 6px"><i class="fas fa-angle-double-up"></i> Perkecil</button> --}}
                                </div>
                                <br>
                                <div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-bordered table-sm" style="color: black">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="color:black">Pendapatan
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Pendapatan Kotor</td>
                                                <td></td>
                                                <td style="text-align: right"><b>Rp.
                                                    

                                                        {{ number_format($totalPenjualan+$totalService, 0, '.', ',') }}</b></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 50px">Total Service</td>
                                                <td></td> 
                                                <td style="text-align: right"><b>Rp.
                                                    {{ number_format($totalService, 0, '.', ',') }}</b></td>
                                            <tr>
                                                <td style="padding-left: 50px">Total Penjualan</td>
                                                <td></td> 
                                                <td style="text-align: right"><b>Rp.
                                                    {{ number_format($totalPenjualan, 0, '.', ',') }}</b></td>
                                            <tr>
                                                <td style="padding-left: 50px">Diskon</td>
                                                <td style="text-align: right"><b>Rp.
                                                        {{ number_format($Diskon, 0, '.', ',') }}</b></td>
                                                <td></td>
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
                                                        {{ number_format($totalPenjualan+$totalService-$Diskon-$HPP, 0, '.', ',') }}</b>
                                                </td>
                                            </tr>
                                            @php
                                                $labaBersih = $PendapatanBersih - $HPP;
                                            @endphp
                                            {{-- <tr>
                                                <th colspan="3" style="color:black;text-align:center">Beban Usaha
                                                </th>
                                            </tr> --}}
                                            <tr>
                                                <th colspan="3" style="color:black">Beban
                                                    Operasional</th>
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
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;">
                                                                Operasional</td>

                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;">
                                                                Listrik</td>
                                                        </tr>
                                                    </table>
                                                    Total Beban Umum Lain
                                                </td>
                                                <td style="text-align: right">
                                                    <b><br></b>
                                                    
                                                    <table style="width: 100%;text-align:left">
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;">
                                                                Rp.
                                                                {{ number_format($operasional, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;">
                                                                Rp.
                                                                {{ number_format($listrik, 0, '.', ',') }}</td>

                                                        </tr>
                                                    </table>
                                                    <b>Rp.
                                                        {{ number_format($operasional + $listrik, 0, '.', ',') }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="1" style="background-color: #ffffdc;color:black">Total Beban
                                                    Operasional
                                                </th>
                                                <td style="text-align: right;background-color: #ffffdc;color:black"><b>Rp.
                                                        {{ number_format($operasional + $listrik + $sharingProfit, 0, '.', ',') }}</b>
                                                </td>
                                                <td style="text-align: right;background-color: #ffffdc"></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" style="color:black">Beban
                                                    Administrasi Umum</th>
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
                                                        Beban Umum Lain
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                ATK</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Air (PDAM)</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Meeting / Konsumsi</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Internet</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Qurban</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Wisata</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Sosial Internal</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Iuran Bulanan</td>
                                                        </tr>
                                                    </table>
                                                    Total Beban Umum Lain
                                                </td>
                                                <td style="text-align: right">
                                                    <table style="width: 100%;text-align:left">
                                                        <b><br></b>

                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($atk, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($air, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($meeting, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($internet, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($qurban, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($wisata, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($biayaSosial, 0, '.', ',') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:0px solid black !important;padding-left:40px;padding-top:0px">
                                                                Rp.
                                                                {{ number_format($iuranBulanan, 0, '.', ',') }}</td>
                                                        </tr>
                                                    </table>
                                                    <b>Rp.
                                                        {{ number_format($atk + $air + $meeting + $internet + $qurban + $wisata + $biayaSosial + $iuranBulanan, 0, '.', ',') }}</b>
                                                </td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td>Beban Sewa</td>
                                                <td style="text-align: right"><b>Rp.
                                                        {{ number_format($bebanSewa, 0, '.', ',') }}</b>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th colspan="1" style="background-color: #ffffdc;color:black">Total Beban
                                                    Administrasi
                                                </th>
                                                <td style="text-align: right;background-color: #ffffdc;color:black"><b>Rp.
                                                        {{                                                         number_format($atk + $air + $meeting + $internet + $qurban + $wisata + $biayaSosial + $iuranBulanan + +$gaji + $bebanSewa, 0, '.', ',') }}</b>
                                                </td>
                                                <td style="text-align: right;background-color: #ffffdc"></td>
                                            </tr>
                                            @php
                                                $totalBebanUmumLain = $atk + $air + $meeting + $internet + $qurban + $wisata + $biayaSosial + $iuranBulanan;
                                                $totalBebanOperasional = $operasional + $listrik + $sharingProfit;
                                                $totalBebanUsaha = $totalBebanUmumLain + $gaji + $bebanSewa + $totalBebanOperasional;
                                            @endphp
                                            {{-- <tr>
                                                <th colspan="1" style="background-color: #ffffdc;color:black">Total Beban
                                                    Usaha
                                                </th>
                                                <td style="text-align: right;background-color: #ffffdc;color:black"><b>Rp.
                                                        {{ number_format($totalBebanUmumLain + $gaji + $bebanSewa + $totalBebanOperasional, 0, '.', ',') }}</b>
                                                </td>
                                                <td style="text-align: right;background-color: #ffffdc"></td>
                                            </tr> --}}

                                            <tr>
                                                <th colspan="2" style="background-color: yellow;color:black">Laba Bersih
                                                    {{-- <br>
                                                    <h1>{{ $labaBersih }}</h1>
                                                    <br>
                                                    <h1>{{ $totalBebanUmumLain }}</h1>
                                                    <br>
                                                    <h1>{{ $gaji }}</h1>
                                                    <br>
                                                    <h1>{{ $bebanSewa }}</h1>
                                                    <br>
                                                    <h1>{{ $totalBebanOperasional }}</h1>
                                                    <br>
                                                    <h1>{{ $totalBebanUmumLain + $gaji + $bebanSewa + $totalBebanOperasional }}</h1> --}}
                                                </th>
                                                <td style="text-align: right;background-color: yellow;color:black"><b>Rp.
                                                        {{ number_format($labaBersih - $totalBebanUsaha, 0, '.', ',') }}</b>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                                <br>
                                <div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </section>
    </form>
@endsection
@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(".dtpickermnth").datepicker({
            format: "MM yyyy",
            // locale:'id',
            autoclose: true,
            startView: "months",
            minViewMode: "months"
        });

        function searchData() {
            var dateS = $(".dtpickermnth").val();
            window.location.href = '{{ route('report-income-statement.index') }}?&dateS=' + $(".dtpickermnth").val();
        }
        function cetakData() {
            var dateS = $(".dtpickermnth").val();
            window.location.href = '{{ route('report-income-statement.printReportIncomeStatement') }}?&dateS=' + $(".dtpickermnth").val();
        }
        

        function expandAll(params) {
            // $('#accordion .panel-collapse').collapse('toggle');
            $('.collapse').collapse('show');
        }

        function closeAll(params) {
            // $('#accordion .panel-collapse').collapse('toggle');
            $('.collapse').collapse('hide');
        }
    </script>

    {{-- <script src="{{ asset('assets/pages/report/reportLaba Rugi.js') }}"></script> --}}
@endsection
