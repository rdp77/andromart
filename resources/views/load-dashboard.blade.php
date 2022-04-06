<div class="row">
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
                    {{ $dataServiceHandphone + $dataServiceLaptop }}
                </div>
                <div class="card-footer">
                    <figure class="highcharts-figure">
                        <div id="containerServiceMasuk" style="width:100%"></div>
                        <p class="highcharts-description">

                        </p>
                    </figure>
                    {{-- <table class="table">
                        <tr>
                            <th>Handphone</th>
                            <th><b
                                    class="dataServiceHandphone">{{ number_format($dataServiceHandphone, 0, ',', '.') }}</b>
                            </th>
                        </tr>
                        <tr>
                            <th>Laptop</th>
                            <th><b
                                    class="dataServiceLaptop">{{ number_format($dataServiceLaptop, 0, ',', '.') }}</b>
                            </th>
                        </tr>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pendapatan Kotor</h4>
                </div>
                <div class="card-body dropPendapatanKotor">
                    <figure class="highcharts-figure">
                        <div id="containerPendapatanKotor" style="width:100%"></div>
                        <p class="highcharts-description">

                        </p>
                    </figure>
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
                    <h style="font-size: 15px">Total Keseluruhan Pendapatan Kas.</h>
                    <br>
                    Rp. {{ number_format($totalKeseluruhanPendapatan, 0, ',', '.') }}
                </div>
                <div class="card-footer">
                    <table class="table">
                        {{-- <tr>
                        <th>Cash</th>
                        <th class="text-right"><b class="dropPendapatanCash">Rp.
                                {{ number_format($totalCash, 0, ',', '.') }}</b></th>
                    </tr>
                    <tr>
                        <th>Debet</th>
                        <th class="text-right"><b class="dropPendapatanDebit">Rp.
                                {{ number_format($totalDebit, 0, ',', '.') }}</b></th>
                    </tr>
                    <tr>
                        <th>Transfer</th>
                        <th class="text-right"><b class="dropPendapatanTransfer">Rp.
                                {{ number_format($totalTransfer, 0, ',', '.') }}</b></th>
                    </tr> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Sharing Profit</h4>
                </div>
                <div class="card-body dropHereSharingProfitTotal">
                    Rp. {{ $totalSharingProfit }}
                </div>
                <div class="card-footer">
                    <figure class="highcharts-figure">
                        <div id="containerSharingProfit" style="width:100%"></div>
                        <p class="highcharts-description">

                        </p>
                    </figure>

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
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"
                        style="position: relative; height: 300px; overflow: auto;display: block;">
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

<script language="JavaScript">
    var cashPendapatanKotor = <?php echo $totalCash; ?>;
    var debetPendapatanKotor = <?php echo $totalDebit; ?>;
    var transferPendapatanKotor = <?php echo $totalTransfer; ?>;

    var chartPendapatanKotor = Highcharts.chart('containerPendapatanKotor', {
        chart: {
            type: 'variablepie'
        },
        title: {
            text: ''
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                'Total: <b>{point.y}</b><br/>'
        },
        series: [{
            minPointSize: 100,
            innerSize: '30%',
            zMin: 0,
            name: 'Total Pendapatan Kotor',
            data: [{
                name: 'Cash',
                y: cashPendapatanKotor,
            }, {
                name: 'Debet',
                y: debetPendapatanKotor,
            }, {
                name: 'Transfer',
                y: transferPendapatanKotor,
            }]
        }]
    });

    var dataServiceHandphone = <?php echo $dataServiceHandphone; ?>;
    var dataServiceLaptop = <?php echo $dataServiceLaptop; ?>;


    Highcharts.chart('containerServiceMasuk', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'Handphone',
                'Laptop'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total (Unit)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} Unit</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Handphone',
            data: [dataServiceHandphone]

        }, {
            name: 'Laptop',
            data: [dataServiceLaptop]

        }]
    });
    Highcharts.chart('containerSharingProfit', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },

        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'low'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Rupiah'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        xAxis: {
            categories: [''],
            layout: 'vertical',
            title: {
                text: null
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: false,
            borderWidth: 1,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
            @foreach ($karyawan as $i => $el)
                {
                name:"{{ $el->name }}",
                data:[{{ $sharingProfit1Service[$i] +$sharingProfit2Service[$i] +$sharingProfitSaleSales[$i] +$sharingProfitSaleBuyer[$i] }}]
                },
            @endforeach
        ]
    });
</script>
