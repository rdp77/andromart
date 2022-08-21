@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Laporan Neraca'))
@section('titleContent', __('Laporan Neraca'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Laporan Neraca') }}</div>
@endsection

@section('content')
    {{-- @include('pages.backend.components.filterSearch') --}}
    @include('layouts.backend.components.notification')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
    <form class="form-data">
        @csrf
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">Neraca <b>{{ date('F Y') }}</b> </h2>
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="row">
                                    <table style="width:100%">
                                        <tr>
                                            <th style="text-align:center">ANDROMART INDONESIA
                                                <br>
                                                Neraca
                                                <br>
                                                Per {{ date('d F Y') }}
                                            </th>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <table style="color: black;border-collapse:collapse;width:100%">
                                        <thead>

                                            <tr>
                                                <th width="49%" style="color:black;border-top: 1px solid black">Aktiva Lancar
                                                </th>
                                                <th style="border-left: 1px solid black;border-top: 1px solid black" rowspan="10">

                                                </th>
                                                <th width="49%" style="color:black;border-top: 1px solid black">Utang Lancar
                                                </th>
                                            </tr>

                                            <tr>
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td
                                                                style="padding-left:10px;">
                                                                <b>KAS</b>
                                                            </td>
                                                            <td
                                                                style="padding-left:40px;">
                                                                <b>Rp.</b></td>
                                                            <td
                                                                style="padding-left:10px;text-align:right">
                                                                <b>{{ number_format($dataKasTotal, 0, ',', ',') }}</b>
                                                            </td>
                                                        </tr>
                                                        @for ($i = 0; $i < count($accountDataKas); $i++)
                                                            @php
                                                                $totalPerkas = 0;
                                                            @endphp
                                                            @for ($j = 0; $j < count($dataKas); $j++)
                                                                @if ($accountDataKas[$i]['main_detail_id'] == $dataKas[$j]['akun'])
                                                                    @php
                                                                        $totalPerkas += $dataKas[$j]['total'];
                                                                    @endphp
                                                                @endif
                                                            @endfor
                                                            <tr>
                                                                <td
                                                                    style="padding-left:40px;">
                                                                    {{ $accountDataKas[$i]['name'] }}
                                                                </td>
                                                                <td
                                                                    style="padding-left:40px;">
                                                                    Rp.</td>
                                                                <td
                                                                    style="padding-left:10px;text-align:right">
                                                                    {{ number_format($totalPerkas, 0, ',', ',') }}
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td
                                                                style="padding-left:10px;">
                                                                <b>Persediaan</b>
                                                            </td>
                                                            <td
                                                                style="padding-left:40px;">
                                                                <b>Rp.</b></td>
                                                            <td
                                                                style="padding-left:10px;text-align:right">
                                                                {{-- <b>{{ number_format($dataKasTotal, 0, ',', ',') }}</b> --}}
                                                            </td>
                                                        </tr>
                                                        {{-- @for ($i = 0; $i < count($accountDataPersediaan); $i++)
                                                            @php
                                                                $totalPerPersediaan = 0;
                                                            @endphp
                                                            @for ($j = 0; $j < count($dataPersediaan); $j++)
                                                                @if ($dataPersediaan[$i]['main_detail_id'] == $dataPersediaan   [$j]['akun'])
                                                                    @php
                                                                        $totalPerPersediaan += $dataPersediaan[$j]['total'];
                                                                    @endphp
                                                                @endif
                                                            @endfor
                                                            <tr>
                                                                <td
                                                                    style="padding-left:40px;">
                                                                    {{ $dataPersediaanTotal[$i]['name'] }}
                                                                </td>
                                                                <td
                                                                    style="padding-left:40px;">
                                                                    Rp.</td>
                                                                <td
                                                                    style="padding-left:10px;text-align:right">
                                                                    {{ number_format($dataPersediaanTotal, 0, ',', ',') }}
                                                                </td>
                                                            </tr>
                                                        @endfor --}}
                                                    </table>

                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-header" style="background-color: #ffffdc; color:black">
                            {{-- <h3>Total Kas : Rp. {{ number_format($total, 0, ',', ',') }}</h3> --}}
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
    </script>
    <script src="{{ asset('assets/pages/report/reportCashBalance.js') }}"></script>
@endsection
