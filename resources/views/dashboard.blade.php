@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Dashboard'))
@section('titleContent', __('Dashboard'))
@section('breadcrumb', __('Tanggal ').date('d-M-Y'))

@section('content')
@include('layouts.backend.components.notification')
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-stats">
                <div class="card-stats-title">
                    {{ __('Simpanan Agustus 2021') }}
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-archive"></i>
            </div>
            <div class="card-wrap">
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
            </div>
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
            @foreach($log as $l )
            <a href="javascript:void(0)" class="ticket-item">
                <div class="ticket-title">
                    <h4>{{ $l->info }}</h4>
                </div>
                <div class="ticket-info">
                    <div>{{ $l->ip }}</div>
                    <div class="bullet"></div>
                    <div class="text-primary">
                        {{ __('Tercatat pada tanggal ').date("d-M-Y", strtotime($l->added_at)).
                        __(' Jam ').date("H:m", strtotime($l->added_at)) }}
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