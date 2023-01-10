<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="col-lg-12 col-md-12 col-sm-12" id="areaToPrint">
            <h1 class="section-title">Total Summary</h1>
            <div class="row" id="areaToStyle">
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Kotor </h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($pendapatanKotor, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Bersih</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($pendapatanBersih, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Laba Bersih</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($labaBersih, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Beban & Biaya</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($beban + $biaya, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Income </h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($income, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Outcome</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($outcome, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Asset Tetap</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($asset, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Persediaan</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($persediaan, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Kecil </h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($kas['Kas Kecil'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Bank Jago</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($kas['Kas Bank Jago'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Bank BCA</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($kas['Kas Bank BCA'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign fa-2xl"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Besar</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($kas['Kas Besar'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
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
                                        <th colspan="2" style="text-align: center">Belum diambil 
                                         <a href="{{ route('dashboard.printDataServiceBelumDiambilDashboard') }}" rel="noopener noreferrer"> Print Data</a></th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center"> {{ $service['belumDiambilCount'] }}</th>
                                        <th style="text-align: center">Rp.
                                            {{ number_format($service['belumDiambilSum'], 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            <p>Progress</p>
                            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"
                                style="position: relative; height: 262px; overflow: auto;display: block;">
                                <table class="table table-bordered table-sm table-striped mb-0"
                                    style="text-align: center;font-size:18px;">
                                    <tr>
                                        <th colspan="2">Progress Service</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <th>Qty</th>
                                    </tr>
                                    @for ($i = 0; $i < count($service['dataService']); $i++)
                                        <tr>
                                            <td style="text-align: left;font-weight: normal;">
                                                {{ $service['dataService'][$i]['nama'] }}
                                            </td>
                                            <td style="font-weight: normal;">
                                                {{ $service['dataService'][$i]['total'] }}</td>
                                        </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <p>KPI TEKNISI</p>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-6">
                                    <select name="" class="form-control select2" id="employee">
                                        <option selected>- Select -</option>
                                        @foreach ($employee as $el)
                                            <option value="{{ $el->id }}">{{ $el->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <button class="btn btn-primary"
                                        onclick="{searchKpi(),checkSharingProfitEmployee()}">Cari</button>
                                </div>
                                <br>
                                <div class="container">
                                    <div class="progress" style="height: 3rem !important;margin-top:20px">
                                        <div class="progress-bar progress-bar-success solved" role="progressbar"
                                            style="width:50%;background-color: #47c363!important">
                                            0%
                                        </div>
                                        <div class="progress-bar progress-bar-danger cancel" role="progressbar"
                                            style="width:50%;background-color: #fc544b !important">
                                            0%
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p>Sharing Profit & Loss</p>
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"
                                        style="position: relative; height: 228px; overflow: auto;display: block;">
                                        <table class="table table-bordered table-sm table-striped mb-0"
                                            style="text-align: center;font-size:18px;">
                                            <tr>
                                                <th colspan="2" style="text-align: center">Sharing Profit </th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Teknisi 1</th>
                                                <th style="text-align: right" class="sp1">Rp. 0</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Teknisi 2</th>
                                                <th style="text-align: right" class="sp2">Rp. 0</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Buyer</th>
                                                <th style="text-align: right" class="spb">Rp. 0</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Sales</th>
                                                <th style="text-align: right" class="sps">Rp. 0</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Total</th>
                                                <th style="text-align: right" class="spt">Rp. 0</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="text-align: center">Loss </th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Teknisi 1</th>
                                                <th style="text-align: right" class="ls1">Rp. 0</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center"> Teknisi 2</th>
                                                <th style="text-align: right" class="ls2">Rp. 0</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
    function checkSharingProfitEmployee(params) {
        $('.sp1').html('Rp. 0');
        $('.sp2').html('Rp. 0');
        $('.sps').html('Rp. 0');
        $('.spb').html('Rp. 0');
        $('.spt').html('Rp. 0');
        $('.ls1').html('Rp. 0');
        $('.ls2').html('Rp. 0');

        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        var dtpickermnth = $('.dtpickermnth').val();
        var dtpickeryr = $('.dtpickeryr').val();
        var filter = $('.filter').val();
        var branch = $('.branch').val();
        var employee = $('#employee').val();
        $.ajax({
            url: "/dashboard/filter-sharing-profit-dashboard",
            type: 'GET',
            data: {
                'branch': branch,
                'type': filter,
                'year': dtpickeryr,
                'month': dtpickermnth,
                'startDate': startDate,
                'endDate': endDate,
                'employee': employee
            },
            success: function(data) {
                $('.sp1').html('Rp. ' + data.sp1);
                $('.sp2').html('Rp. ' + data.sp2);
                $('.sps').html('Rp. ' + data.sps);
                $('.spb').html('Rp. ' + data.spb);
                $('.spt').html('Rp. ' + data.spt);
                $('.ls1').html('Rp. ' + data.ls1);
                $('.ls2').html('Rp. ' + data.ls2);
            }
        });
    }

    function searchKpi(params) {
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        var dtpickermnth = $('.dtpickermnth').val();
        var dtpickeryr = $('.dtpickeryr').val();
        var filter = $('.filter').val();
        var branch = $('.branch').val();
        var employee = $('#employee').val();
        $.ajax({
            url: "/dashboard/filter-kpi-dashboard",
            type: 'GET',
            data: {
                'branch': branch,
                'type': filter,
                'year': dtpickeryr,
                'month': dtpickermnth,
                'startDate': startDate,
                'endDate': endDate,
                'employee': employee
            },
            success: function(data) {
                $('.solved').html(data[1]+'/[' + data[2].toFixed(2) + '%]');
                $('.cancel').html(data[0]+'/[' + data[3].toFixed(2) + '%]');
                console.log(data[2]);
                console.log(data[3]);
                $('.solved').css('width', data[2].toFixed(2) + '%');
                $('.cancel').css('width', data[3].toFixed(2) + '%');
            }
        });
    }

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
