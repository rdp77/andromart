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
                                    <div class="form-group col-12 col-md-6 col-lg-6">
                                        <label for="type">{{ __('Tipe Pencarian') }}<code>*</code></label>
                                        <select class="select2 type validation" name="type">
                                            <option value="Bulan">Bulan</option>
                                            <option value="Quartal">Quartal</option>
                                            <option value="Tahun">Tahun</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-6">
                                        <label for="type">{{ __('Cabang') }}<code>*</code></label>
                                        <select class="select2 branch validation" name="branch">
                                            <option value="">- Select -</option>
                                            @foreach ($branch as $el)
                                                <option value="{{ $el->id }}">{{ $el->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row showBulan">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <div class="d-block">
                                                <label for="name"
                                                    class="control-label">{{ __('Bulan') }}<code>*</code></label>
                                            </div>
                                            <input type="text" class="form-control dtpickermnth typeBulan" value="{{ date('F Y') }}"
                                                name="typeBulan" id="dtpickermnth" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group ml-4">
                                            <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                                style="margin-top: 32px"><i class="fas fa-search"></i> Cari</button>
                                            <button class="btn btn-primary tombol ml-3" onclick="cetakData()" type="button"
                                                style="margin-top: 32px"><i class="fas fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row showQuartal" style="display: none">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <div class="d-block">
                                                <label for="name"
                                                    class="control-label">{{ __('Quartal') }}<code>*</code></label>
                                            </div>
                                            <select name="Quartal" id="1" class="form-control Quartal">
                                                <option value="Q1">Quartal 1</option>
                                                <option value="Q2">Quartal 2</option>
                                                <option value="Q3">Quartal 3</option>
                                                <option value="Q4">Quartal 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <div class="d-block">
                                                <label for="name"
                                                    class="control-label">{{ __('Tahun') }}<code>*</code></label>
                                            </div>
                                            <input type="text" class="form-control dtpickeryrs typeQuartalTahun" value="{{ date('Y') }}"
                                                name="typeQuartalTahun" id="dtpickeryrs" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group ml-4">
                                            <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                                style="margin-top: 32px"><i class="fas fa-search"></i> Cari</button>
                                            <button class="btn btn-primary tombol ml-3" onclick="cetakData()" type="button"
                                                style="margin-top: 32px"><i class="fas fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row showTahun" style="display: none">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <div class="d-block">
                                                <label for="name"
                                                    class="control-label">{{ __('Tahun') }}<code>*</code></label>
                                            </div>
                                            <input type="text" class="form-control dtpickeryrs typeTahun" value="{{ date('Y') }}"
                                                name="typeTahun" id="dtpickeryrs" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group ml-4">
                                            <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                                style="margin-top: 32px"><i class="fas fa-search"></i> Cari</button>
                                            <button class="btn btn-primary tombol ml-3" onclick="cetakData()" type="button"
                                                style="margin-top: 32px"><i class="fas fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
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
                                                <td>Pendapatan Kotor</td>
                                                <td></td>
                                                <td style="text-align: right"><b>Rp.


                                                        {{ number_format($totalPenjualan + $totalService - $DiskonPenjualan - $DiskonService, 0, '.', ',') }}</b>
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
                                                        {{ number_format($totalPenjualan + $totalService - $DiskonPenjualan - $DiskonService - $HPP, 0, '.', ',') }}</b>
                                                </td>
                                            </tr>
                                            @php
                                                $labarKotor = $totalPenjualan + $totalService - $DiskonPenjualan - $DiskonService - $HPP;
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
                                                        {{ number_format($labarKotor - $totalDataBeban - $sharingProfit - $totalDataBiaya - $gaji, 0, '.', ',') }}</b>
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

        $(".dtpickeryrs").datepicker({
            format: "yyyy",
            // locale:'id',
            autoclose: true,
            startView: "years",
            minViewMode: "years"
        });

        $('.type').change(function() {
            var type = $(this).val();
            // alert(type);
            if (type == 'Bulan') {
                $('.showBulan').css('display', 'flex');
                $('.showQuartal').css('display', 'none');
                $('.showTahun').css('display', 'none');
            } else if (type == 'Quartal') {
                $('.showBulan').css('display', 'none');
                $('.showQuartal').css('display', 'flex');
                $('.showTahun').css('display', 'none');
            } else if (type == 'Tahun') {
                $('.showBulan').css('display', 'none');
                $('.showQuartal').css('display', 'none');
                $('.showTahun').css('display', 'flex');
            }

        });
        // function type() {

        // }

        function searchData() {
            var type = $(".type").val();
            var branch = $(".branch").val();
            var typeBulan = $(".typeBulan").val();
            var Quartal = $(".Quartal").val();
            var typeQuartalTahun = $(".typeQuartalTahun").val();
            var typeTahun = $(".typeTahun").val();
            window.location.href = '{{ route('report-income-statement.index') }}?&bulan=' + typeBulan
            +'&branch=' + branch
            +'&type=' + type
            +'&Quartal=' + Quartal
            +'&typeQuartalTahun=' + typeQuartalTahun
            +'&typeTahun=' + typeTahun;
        }

        function cetakData() {
            var dateS = $(".dtpickermnth").val();
            window.location.href = '{{ route('report-income-statement.printReportIncomeStatement') }}?&dateS=' + $(
                ".dtpickermnth").val();
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
