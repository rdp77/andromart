@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Dashboard'))
@section('titleContent', __('Dashboard'))
@section('breadcrumb', __('Tanggal ') . date('d-M-Y'))

@section('content')
    @include('layouts.backend.components.notification')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }

    </style>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-statistic-2">
                <div class="row">

                    <div class="col-lg-2 col-md-2 col-sm-3">
                        <div class="card-wrap">
                            <div class="card-header">
                                {{-- <h4>Filter dengan :</h4> --}}
                                <label>{{ __('Tanggal :') }}</label>
                                <select style="margin-top: 10px" onchange="checkFilter()" name="filter"
                                    class="select2 filter form-control" id="">
                                    <option value="">- Select -</option>
                                    <option value="Tanggal">Tanggal</option>
                                    <option value="Bulan">Bulan</option>
                                    <option value="Tahun">Tahun</option>
                                </select>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3">
                        <div class="card-wrap">
                            <div class="card-header">
                                {{-- <h4>Filter dengan :</h4> --}}
                                <label>{{ __('Cabang :') }}</label>
                                <select style="margin-top: 10px" name="branch"
                                    class="select2 branch form-control" id="">
                                    <option value="">- Select -</option>
                                    @foreach ($branch as $el)
                                        <option value="{{$el->id}}">{{$el->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6 filterTanggal" style="display: none">
                        <div class="card-wrap">
                            <div class="card-header">
                                <div class="row">
                                    <div class="form-group col-6 col-md-6 col-lg-6">
                                        <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                                        <input id="startDate" type="text" class="startDate form-control datepicker"
                                            name="startDate">
                                    </div>
                                    <div class="form-group col-6 col-md-6 col-lg-6">
                                        <label for="endDate">{{ __('Tanggal Akir') }}<code>*</code></label>
                                        <input id="endDate" type="text" class="endDate form-control datepicker"
                                            name="endDate">
                                    </div>

                                </div>
                                <button class="btn btn-primary tombol" onclick="searchData('Tanggal')" type="button"
                                    style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6 filterBulan" style="display: none">
                        <div class="card-wrap">
                            <div class="card-header">
                                <div class="row">
                                    <div class="form-group col-12 col-md-12 col-lg-12">
                                        <label for="dtpickermnth">{{ __('Bulan') }}<code>*</code></label>

                                        <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                            name="dtpickermnth" id="dtpickermnth" />
                                    </div>

                                </div>
                                <button class="btn btn-primary tombol" onclick="searchData('Bulan')" type="button"
                                    style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6 filterTahun" style="display: none">
                        <div class="card-wrap">
                            <div class="card-header">
                                <div class="row">
                                    <div class="form-group col-12 col-md-12 col-lg-12">
                                        <label for="dtpickeryr">{{ __('Tahun') }}<code>*</code></label>
                                        <input type="text" class="form-control dtpickeryr" value="{{ date('Y') }}"
                                            name="dtpickeryr" id="dtpickeryr" />
                                    </div>

                                </div>
                                <button class="btn btn-primary tombol" onclick="searchData('Tahun')" type="button"
                                    style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dropHereHtml">
    </div>
 
    {{-- @include('dashboard-content') --}}


@endsection
@section('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <script language="JavaScript">
        function countTrafic() {
            $.ajax({
                url: "/transaction/service/traffic-count",
                type: 'GET',
                success: function(data) {
                    location.reload();
                    swal('Data Telah Tersimpan', {
                        icon: "success",
                    });
                }
            });
        }
        $(".dtpickermnth").datepicker({
            format: "MM yyyy",
            autoclose: true,
            startView: "months",
            minViewMode: "months"
        });
        $(".dtpickeryr").datepicker({
            format: "yyyy",
            autoclose: true,
            startView: "years",
            minViewMode: "years"
        });

        function checkFilter() {
            var par = $('.filter').find(':selected').val();
            if (par == 'Tanggal') {
                $('.filterTanggal').css('display', 'block');
                $('.filterBulan').css('display', 'none');
                $('.filterTahun').css('display', 'none');
            } else if (par == 'Bulan') {
                $('.filterTanggal').css('display', 'none');
                $('.filterTahun').css('display', 'none');
                $('.filterBulan').css('display', 'block');
            } else if (par == 'Tahun') {
                $('.filterTanggal').css('display', 'none');
                $('.filterBulan').css('display', 'none');
                $('.filterTahun').css('display', 'block');
            }
        }

        window.onload= searchData ();

        function searchData(params) {
            var startDate = $('.startDate').val();
            var endDate = $('.endDate').val();
            var dtpickermnth = $('.dtpickermnth').val();
            var dtpickeryr = $('.dtpickeryr').val();
            var filter = $('.filter').val();
            var branch = $('.branch').val();
            
            $.ajax({
                url: "/dashboard/filter-data-dashboard",
                type: 'GET',
                data: {
                    'branch': branch,
                    'type': filter,
                    'year': dtpickeryr,
                    'month': dtpickermnth,
                    'startDate': startDate,
                    'endDate': endDate
                },
                success: function(data) {
                    $('.dropHereHtml').html(data);
                }
            });
        }
       

    </script>

@endsection
