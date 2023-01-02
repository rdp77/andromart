<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h1>Laporan Keuangan</h1>
                </div>
                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Pendapatan Kotor</p>
                            <b>Rp. {{ number_format($pendapatanKotor, 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Pendapatan Bersih</p>
                            <b>Rp. {{ number_format($pendapatanBersih, 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Laba Bersih</p>
                            <b>Rp. {{ number_format($labaBersih, 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Beban & Biaya</p>
                            <b>Rp. {{ number_format($beban + $biaya, 0, ',', '.') }}</b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Income</p>
                            <b>Rp. {{ number_format($income, 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Outcome</p>
                            <b>Rp. {{ number_format($outcome, 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Asset Tetap</p>
                            <b>Rp. {{ number_format($asset, 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Persediaan</p>
                            <b>Rp. {{ number_format($persediaan, 0, ',', '.') }}</b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Kas Kecil</p>
                            <b>Rp. {{ number_format($kas['Kas Kecil'], 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Kas Bank Jago</p>
                            <b>Rp. {{ number_format($kas['Kas Bank Jago'], 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Kas Bank BCA</p>
                            <b>Rp. {{ number_format($kas['Kas Bank BCA'], 0, ',', '.') }}</b>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Kas Besar</p>
                            <b>Rp. {{ number_format($kas['Kas Besar'], 0, ',', '.') }}</b>
                        </div>
                    </div>
                </div>
                <div class="card-footer">


                </div>
            </div>
        </div>
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h1>Laporan Service</h1>
                </div>
                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p>Service</p>
                            <figure class="highcharts-figure">
                                <div id="containerServiceMasuk" style="width:100%"></div>
                                <p class="highcharts-description">

                                </p>
                            </figure>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <p>Pekerjaan</p>
                            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-bordered table-sm table-striped mb-0"
                                    style="text-align: center;font-size:18px;">
                                    <tr>
                                        <th colspan="2">Belum diambil</th>
                                    </tr>
                                    <tr>
                                        <th> {{ $service['belumDiambilCount'] }}</th>
                                        <th>Rp. {{ number_format($service['belumDiambilSum'], 0, ',', '.') }} </th>
                                    </tr>
                                </table>
                            </div>
                            <p>Progress</p>
                            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"
                                style="position: relative; height: 260px; overflow: auto;display: block;">
                                <table class="table table-bordered table-sm table-striped mb-0"
                                    style="text-align: center;font-size:18px;">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Total</th>
                                    </tr>
                                    @for ($i = 0; $i < count($service['dataService']); $i++)
                                        <tr>
                                            <td style="text-align: left">{{ $service['dataService'][$i]['nama'] }}</td>
                                            <td>{{ $service['dataService'][$i]['total'] }}</td>
                                        </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <p>KPI TEKNISI</p>
                        </div>
                    </div>
                    <br>

                </div>
                <div class="card-footer">


                </div>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
    var dataServiceHandphone = <?php echo $service['serviceHandphone']; ?>;
    var dataServiceLaptop = <?php echo $service['serviceLaptop']; ?>;


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
                'Service Masuk',
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
</script>
