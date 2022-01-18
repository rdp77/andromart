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

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Filter dengan :</h4>
                                <select style="margin-top: 10px" onchange="checkFilter()" name="filter"
                                    class="filter form-control" id="">
                                    <option value="">- Select -</option>
                                    <option value="Tanggal">Tanggal</option>
                                    <option value="Bulan">Bulan</option>
                                    <option value="Tahun">Tahun</option>
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
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Sharing Profit</h4>
                    </div>
                    <div class="card-body dropHereSharingProfitTotal">
                        {{ $totalSharingProfit }}
                    </div>
                    <div class="card-footer">
                        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="position: relative;
                                                    height: 200px;
                                                    overflow: auto;display: block;">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Profit</th>
                                    </tr>
                                </thead>
                                <tbody class="dropHereSharingProfit">

                                    @foreach ($karyawan as $i => $el)
                                        <tr>
                                            <th scope="row">{{ $i + 1 }}</th>
                                            <td>{{ $el->name }}</td>
                                            <td>{{ number_format($sharingProfit1Service[$i] + $sharingProfit2Service[$i] + $sharingProfitSaleSales[$i] + $sharingProfitSaleBuyer[$i], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pendapatan Kotor</h4>
                    </div>
                    <div class="card-body dropPendapatanKotor">
                        @php
                            $totalKeseluruhanPendapatan = 0;
                            $totalCash = 0;
                            $totalDebit = 0;
                            $totalTransfer = 0;
                        @endphp
                        @foreach ($dataPendapatan as $i => $el)
                            @php
                                $totalKeseluruhanPendapatan += $el->total;
                            @endphp
                            @if ($el->type == 'Pembayaran Service')
                                @if ($el->ServicePayment->payment_method == 'Cash')
                                    @php
                                        $totalCash += $el->total;
                                    @endphp
                                @elseif ($el->ServicePayment->payment_method == 'Debit')
                                    @php
                                        $totalDebit += $el->total;
                                    @endphp
                                @elseif ($el->ServicePayment->payment_method == 'Transfer')
                                    @php
                                        $totalTransfer += $el->total;
                                    @endphp
                                @endif
                            @elseif($el->type == 'Penjualan')
                                @if ($el->sale->payment_method == 'Cash')
                                    @php
                                        $totalCash += $el->total;
                                    @endphp
                                @elseif ($el->sale->payment_method == 'Debit')
                                    @php
                                        $totalDebit += $el->total;
                                    @endphp
                                @elseif ($el->sale->payment_method == 'Transfer')
                                    @php
                                        $totalTransfer += $el->total;
                                    @endphp
                                @endif
                            @endif

                        @endforeach
                        {{ number_format($totalKeseluruhanPendapatan, 0, ',', '.') }}
                    </div>
                    <div class="card-footer">
                        <table class="table">
                            <tr>
                                <th>Cash</th>
                                <th><b class="dropPendapatanCash">{{ number_format($totalCash, 0, ',', '.') }}</b></th>
                            </tr>
                            <tr>
                                <th>Debet</th>
                                <th><b class="dropPendapatanDebit">{{ number_format($totalDebit, 0, ',', '.') }}</b></th>
                            </tr>
                            <tr>
                                <th>Transfer</th>
                                <th><b
                                        class="dropPendapatanTransfer">{{ number_format($totalTransfer, 0, ',', '.') }}</b>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Service In</h4>
                    </div>
                    <div class="card-body dataServiceTotal">
                        {{ $dataServiceTotal }}
                    </div>
                    <div class="card-footer">
                        <table class="table">
                            <tr>
                                <th>Handphone</th>
                                <th><b
                                        class="dataServiceHandphone">{{ number_format($dataServiceHandphone, 0, ',', '.') }}</b>
                                </th>
                            </tr>
                            <tr>
                                <th>Laptop</th>
                                <th><b class="dataServiceLaptop">{{ number_format($dataServiceLaptop, 0, ',', '.') }}</b>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Top Chart Penjualan</h4>
                    </div>
                    <div class="card-footer ">
                        <table class="table table-striped topSales">
                            @foreach ($topSales as $topSales)
                                <tr>
                                    <th>{{ $topSales->name }}</th>
                                    <th>{{ $topSales->total }}</th>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Progress Teknisi</h4>
                    </div>
                    <div class="card-body ">
                        {{ $dataServiceTotal }}
                    </div>
                    <div class="card-footer">
                        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="position: relative;
                                                    height: 300px;
                                                    overflow: auto;display: block;">
                            <table class="table table-bordered table-striped mb-0" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Selesai / Diterima</th>
                                        <th scope="col">Cancel / Return</th>
                                    </tr>
                                </thead>
                                <tbody class="totalServiceFix">

                                    @foreach ($karyawan as $i => $el)
                                        <tr>
                                            <th scope="row">{{ $i + 1 }}</th>
                                            <td>{{ $el->name }}</td>
                                            <td style="font-size: 17px;font-weight:bold">
                                                {{ $totalServiceProgress[$i] }}
                                            </td>
                                            <td style="font-size: 17px;font-weight:bold">
                                                {{ $totalServiceDone[$i] }}
                                            </td>
                                            <td style="font-size: 17px;font-weight:bold">
                                                {{ $totalServiceCancel[$i] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-12">
            <div class="card card-statistic-2">
                <div onclick="countTrafic()" class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Traffic</h4>
                    </div>
                    <div class="card-body dataTraffic">
                        {{ $dataTrafficToday }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Data Service</h4>
                </div>
                <div class="card-body">
                    <h4>KPI Karyawan</h4>
                </div>
                <div class="card-footer">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="position: relative;
                        height: 300px;
                        overflow: auto;display: block;">
                        <table class="table table-bordered table-striped mb-0" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col" >Progress</th>
                                    <th scope="col" >Selesai / Diterima</th>
                                    <th scope="col" >Cancel / Return</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($karyawan as $i => $el)
                                    <tr>
                                        <th scope="row">{{ $i + 1 }}</th>
                                        <td>{{ $el->name }}</td>
                                        <td style="font-size: 17px;font-weight:bold" >
                                            {{$totalServiceProgress[$i]}}
                                        </td>
                                        <td style="font-size: 17px;font-weight:bold" >
                                            {{$totalServiceDone[$i]}}
                                        </td>
                                        <td style="font-size: 17px;font-weight:bold" >
                                            {{$totalServiceCancel[$i]}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="card card-hero">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-history"></i>
            </div>
            <h4>{{ __('pages.history') }}</h4>
            <div class="card-description">
                {{ __('pages.historyDesc') }}
            </div>
        </div>
        <div class="card-body p-0">
            <div class="tickets-list">
                @foreach ($log as $l)
                    <a href="javascript:void(0)" class="ticket-item">
                        <div class="ticket-title">
                            <h4>{{ $l->info }}</h4>
                        </div>
                        <div class="ticket-info">
                            <div>{{ $l->ip }}</div>
                            <div class="bullet"></div>
                            <div class="text-primary">
                                {{ __('Tercatat pada tanggal ') . date('d-M-Y', strtotime($l->added_at)) . __(' Jam ') . date('H:m', strtotime($l->added_at)) }}
                            </div>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('dashboard.log') }}" class="ticket-item ticket-more">
                    {{ __('Lihat Semua ') }} <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div> --}}
@endsection


@section('script')
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
            // locale:'id',
            autoclose: true,
            startView: "months",
            minViewMode: "months"
        });
        $(".dtpickeryr").datepicker({
            format: "yyyy",
            // locale:'id',
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

        function searchData(params) {
            var startDate = $('.startDate').val();
            var endDate = $('.endDate').val();
            var dtpickermnth = $('.dtpickermnth').val();
            var dtpickeryr = $('.dtpickeryr').val();
            var filter = $('.filter').val();
            $.ajax({
                url: "/dashboard/filter-data-dashboard",
                type: 'GET',
                data: {
                    'type': filter,
                    'year': dtpickeryr,
                    'month': dtpickermnth,
                    'startDate': startDate,
                    'endDate': endDate
                },
                success: function(data) {
                    $('.dropPendapatanKotor').html(data.totalKeseluruhanPendapatan);
                    $('.dropPendapatanCash').html(data.totalCash);
                    $('.dropPendapatanDebit').html(data.totalDebit);
                    $('.dropPendapatanTransfer').html(data.totalKeseluruhanPendapatan);
                    $('.dataServiceHandphone').html(data.dataServiceHandphone);
                    $('.dataServiceLaptop').html(data.dataServiceLaptop);
                    $('.dataServiceTotal').html(data.dataServiceTotal);
                    $('.dataTraffic').html(data.dataTraffic);
                    
                    $('.dropHereSharingProfitTotal').html(data.totalSharingProfit);
                    $('.dropHereSharingProfit').empty();
                    $('.totalServiceFix').empty();
                    $('.topSales').empty();
                    $.each(data.totalSharingProfitSplit, function(index, value) {
                        $(".dropHereSharingProfit").append(
                            "<tr>" +
                            "<td><b>" +
                            (index + 1) +
                            "</b>" +
                            "</td>" +
                            "<td><b>" +
                            value.nama +
                            "</b>" +
                            "</td>" +
                            "<td style='text-align: right'><b>" +
                            "Rp. " +
                            parseInt(value.total).toLocaleString("en-US") +
                            "</b>" +
                            "</b></td>" +
                            "</tr>"
                        );
                    });
                    $.each(data.topSales, function(index, value) {
                        $(".topSales").append(
                            "<tr>" +
                            "<td><b>" +
                            value.name +
                            "</b>" +
                            "</td>" +
                            "<td><b>"+
                            value.total +
                            "</b>" +
                            "</b></td>" +
                            "</tr>"
                        );
                    });
                    $.each(data.totalServiceFix, function(index, value) {
                        $(".totalServiceFix").append(
                            "<tr>" +
                            "<td><b>" +
                            (index + 1) +
                            "</b>" +
                            "</td>" +
                            "<td><b>" +
                            value.nama +
                            "</b>" +
                            "</td>" +
                            "<td style='text-align: right'><b>"+
                            value.progress +
                            "</b></td>" +
                            "<td style='text-align: right'><b>"+
                            value.done +
                            "</b></td>" +
                            "<td style='text-align: right'><b>"+
                            value.cancel +
                            "</b></td>" +
                            "</tr>"
                        );
                    });
                }
            });
        }
    </script>



@endsection
