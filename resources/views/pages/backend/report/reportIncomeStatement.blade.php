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

        table.table-bordered {
            border: 1px solid black !important;
            margin-top: 20px;
        }
        .table.table-bordered td {
            border: 1px solid #9a9a9a !important;
        }
        table.table-bordered>thead>tr>th {
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
                                    <div class="form-group col-sm-11  mb-1 mr-10">
                                        <label for="inputPassword2" class="sr-only">Bulan</label>
                                        <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                            name="dtpickermnth" id="dtpickermnth" />
                                    </div>
                                    <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                        style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                                    {{-- <button class="btn btn-primary tombol ml-2" onclick="expandAll()" type="button" --}}
                                    {{-- style="margin-bottom: 6px"><i class="fas fa-list"></i> Expand</button> --}}
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
                                    <table class="table table-bordered table-md" style="color: black">
                                        <thead>
                                            <tr>
                                                <th colspan="3">PENDAPATAN</th>
                                            </tr>
                                            <tr>
                                                <td >Pendapatan Kotor</td>
                                                <td></td>
                                                <td style="text-align: right"><b>Rp. {{number_format($PendapatanKotor,0,'.',',')}}</b></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 50px">Diskon</td>
                                                <td style="text-align: right"><b>Rp. {{number_format($Diskon,0,'.',',')}}</b></td>
                                                <td></td>
                                            <tr>
                                                <td style="padding-left: 50px">Pendapatan Bersih</td>
                                                <td style="text-align: right"><b>Rp. {{number_format($PendapatanBersih,0,'.',',')}}</b></td>
                                                <td></td>
                                            <tr>
                                                <td style="padding-left: 50px">HPP</td>
                                                <td style="text-align: right"><b>Rp. {{number_format($HPP,0,'.',',')}}</b></td>
                                                <td></td>
                                            <tr>
                                                <td >Laba Kotor</td>
                                                <td></td>
                                                <td style="text-align: right"><b>Rp. {{number_format($PendapatanBersih-$HPP,0,'.',',')}}</b></td>
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
