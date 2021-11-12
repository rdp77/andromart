@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Dashboard'))
@section('titleContent', __('Dashboard'))
@section('breadcrumb', __('Tanggal ') . date('d-M-Y'))

@section('content')
    @include('layouts.backend.components.notification')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        {{-- <h3>{{$total[1]}}</h3> --}}
                        <h3>Sharing Profit </h3>
                        <br>
                        {{-- <div class="card-header-action dropdown">
                    <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Month</a>
                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                      <li class="dropdown-title">Select Period</li>
                      <li><a href="#" class="dropdown-item">Today</a></li>
                      <li><a href="#" class="dropdown-item">Week</a></li>
                      <li><a href="#" class="dropdown-item active">Month</a></li>
                      <li><a href="#" class="dropdown-item">This Year</a></li>
                    </ul>
                  </div> --}}
                    </div>
                    <div class="card-body" id="top-5-scroll" tabindex="2"
                        style="height: 315px; overflow: hidden; outline: none;">
                        <ul class="list-unstyled list-unstyled-border">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($sharingProfit as $i => $el)
                                <li class="media">
                                    <i class="fas fa-phone" style="font-size: 50px;margin-right:20px"></i>
                                    <div class="media-body">
                                        <div class="media-title">{{ $el->name }}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary" data-width="64%"
                                                    style="width: 64%;"></div>
                                                <div class="budget-price-label">{{ $sharingProfit1[$i] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            @php
                                $total = 0;
                            @endphp
                            @foreach ($sharingProfit as $i => $el)
                                <li class="media">
                                    <i class="fas fa-phone" style="font-size: 50px;margin-right:20px"></i>
                                    <div class="media-body">
                                        <div class="media-title">{{ $el->name }}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary" data-width="64%"
                                                    style="width: 64%;"></div>
                                                <div class="budget-price-label">{{ $sharingProfit1[$i] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer pt-3 d-flex justify-content-center">
                        {{-- <div class="budget-price justify-content-center">
                    <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                    <div class="budget-price-label">Selling Price</div>
                  </div>
                  <div class="budget-price justify-content-center">
                    <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
                    <div class="budget-price-label">Budget Price</div>
                  </div> --}}
                    </div>
                </div>
                {{-- <div class="card-stats">
                <div class="card-stats-title">
                    {{ __('Simpanan Agustus 2021') }}
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-archive"></i>
            </div> --}}
                {{-- <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Simpanan Anggota') }}</h4>
                </div>
                <div class="card-body">
                    59
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-archive"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Penarikan Tunai') }}</h4>
                </div>
                <div class="card-body">
                    59
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-archive"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Jumlah Simpanan') }}</h4>
                </div>
                <div class="card-body">
                    59
                </div>
            </div> --}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Balance</h4>
                    </div>
                    <div class="card-body">
                        $187,13
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Sales</h4>
                    </div>
                    <div class="card-body">
                        4,732
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ __('Total Admin') }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $users }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-list-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ __('Total Aktivitas') }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $logCount }}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    </div>
@endsection
