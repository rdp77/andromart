@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Dashboard'))
@section('titleContent', __('Dashboard'))
@section('breadcrumb', __('Tanggal ') . date('d-M-Y'))

@section('content')
    @include('layouts.backend.components.notification')
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
                    <div class="card-body">
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
                                <tbody>

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
                    <div class="card-body">
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
                                <th><b>{{ number_format($totalCash, 0, ',', '.') }}</b></th>
                            </tr>
                            <tr>
                                <th>Debet</th>
                                <th><b>{{ number_format($totalDebit, 0, ',', '.') }}</b></th>
                            </tr>
                            <tr>
                                <th>Transfer</th>
                                <th><b>{{ number_format($totalTransfer, 0, ',', '.') }}</b></th>
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
                    <div class="card-body">
                        {{ $dataServiceTotal }}
                    </div>
                    <div class="card-footer">
                        <table class="table">
                            <tr>
                                <th>Handphone</th>
                                <th><b>{{ number_format($dataServiceHandphone, 0, ',', '.') }}</b></th>
                            </tr>
                            <tr>
                                <th>Laptop</th>
                                <th><b>{{ number_format($dataServiceLaptop, 0, ',', '.') }}</b></th>
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
                        <h4>Top Chart Penjualan ACC</h4>
                    </div>
                    <div class="card-body">
                        {{-- {{ $dataServiceTotal }} --}}
                    </div>
                    <div class="card-footer">
                        <table class="table">
                            <tr>
                                <th>Handphone</th>
                                {{-- <th><b>{{ number_format($dataServiceHandphone, 0, ',', '.') }}</b></th> --}}
                            </tr>
                            <tr>
                                <th>Laptop</th>
                                {{-- <th><b>{{ number_format($dataServiceLaptop, 0, ',', '.') }}</b></th> --}}
                            </tr>
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
                    <div class="card-body">
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
                    <div class="card-body">
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
    {{-- 
    <div class="card card-hero">
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
    </script>



@endsection
