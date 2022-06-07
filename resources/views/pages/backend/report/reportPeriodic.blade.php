@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Laporan Periodic'))
@section('titleContent', __('Laporan Periodic'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Laporan Periodic') }}</div>
@endsection

@section('content')
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
                        <h2 class="section-title">Periode Bulan <b class="dropMonth">{{ date('F Y') }}</b> </h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-9  mb-1 mr-10">
                                        <label for="inputPassword2" class="sr-only">Bulan</label>
                                        <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                            name="dtpickermnth" id="dtpickermnth" />
                                    </div>
                                    <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                        style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                                        <button class="btn btn-primary tombol ml-2" onclick="expandAll()" type="button"
                                        style="margin-bottom: 6px"><i class="fas fa-list"></i> Expand</button>
                                        <button class="btn btn-primary tombol ml-2" onclick="closeAll()" type="button"
                                        style="margin-bottom: 6px"><i class="fas fa-angle-double-up"></i> Perkecil</button>
                                </div>
                                <br>
                                <div>
                                    @for ($i = 0; $i < count($data); $i++)
                                        <div class="accordion" id="accordion1">
                                            <div class="accordion-group">
                                                <div class="accordion-heading"
                                                    style="padding:10px;background-color:blanchedalmond">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                        data-parent="#accordion1"
                                                        href="#{{ str_replace(' ', '', $data[$i]['main']) }}">
                                                        {{ $data[$i]['main'] }}
                                                    </a>
                                                </div>
                                                <div id="{{ str_replace(' ', '', $data[$i]['main']) }}"
                                                    class="accordion-body collapse">

                                                    <div class="accordion-inner">
                                                        <div class="accordion" id="accordion2">
                                                            @if (isset($data[$i]['main_detail']))
                                                                @for ($j = 0; $j < count($data[$i]['main_detail']); $j++)
                                                                    <div class="accordion-group">
                                                                        @if ($data[$i]['main_detail'][$j]['detail'] != 'Tranfer')
                                                                        <div class="accordion-heading"
                                                                            style="padding:10px;background-color:lightgoldenrodyellow;margin-bottom:10px">
                                                                            <a class="accordion-toggle"
                                                                                data-toggle="collapse"
                                                                                data-parent="#accordion2"
                                                                                href="#{{ str_replace(' ', '', $data[$i]['main_detail'][$j]['detail']) }}">
                                                                                {{ $data[$i]['main_detail'][$j]['detail'] }}
                                                                                {{-- SaldoAkhirJurnalFix --}}
                                                                            </a>
                                                                        </div>
                                                                        <div id="{{ str_replace(' ', '', $data[$i]['main_detail'][$j]['detail']) }}"
                                                                            class="accordion-body collapse in">
                                                                            @if (isset($data[$i]['main_detail'][$j]['branch']))
                                                                                @for ($k = 0; $k < count($data[$i]['main_detail'][$j]['branch']); $k++)
                                                                                    <div class="accordion"
                                                                                        style="margin-bottom:-10px"
                                                                                        id="accordion3">
                                                                                        <div class="accordion-inner">
                                                                                            <div class="accordion-group">
                                                                                                <div class="accordion-heading"
                                                                                                    style="padding:10px;background-color:oldlace;margin-bottom:20px">
                                                                                                    <a class="accordion-toggle"
                                                                                                        data-toggle="collapse"
                                                                                                        data-parent="#accordion3"
                                                                                                        href="#{{ str_replace(' ', '', $data[$i]['main_detail'][$j]['detail']) }}{{ $data[$i]['main_detail'][$j]['branch'][$k]['nama'] }}">
                                                                                                        Cabang
                                                                                                        {{ $data[$i]['main_detail'][$j]['branch'][$k]['nama'] }}
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div id="{{ str_replace(' ', '', $data[$i]['main_detail'][$j]['detail']) }}{{ $data[$i]['main_detail'][$j]['branch'][$k]['nama'] }}"
                                                                                                    class="accordion-body collapse in"
                                                                                                    style="padding:0px">
                                                                                                    <div
                                                                                                        class="accordion-inner">
                                                                                                        <table
                                                                                                            style="width: 100%;background-color:white;border:1px solid black"
                                                                                                            class="table">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    {{-- <td style="height: 0px;padding: 20px;">Kode</td> --}}
                                                                                                                    <th
                                                                                                                         style="height: 0px;padding: 10px;border:1px solid black">
                                                                                                                        Tanggal
                                                                                                                    </th>
                                                                                                                    <th
                                                                                                                        style="height: 0px;padding: 10px;border:1px solid black">
                                                                                                                        Kode
                                                                                                                        Trans
                                                                                                                    </th>

                                                                                                                    <th
                                                                                                                        style="height: 0px;padding: 10px;border:1px solid black">
                                                                                                                        desc
                                                                                                                    </th>

                                                                                                                    <th
                                                                                                                        style="height: 0px;padding: 10px;border:1px solid black">
                                                                                                                        D
                                                                                                                    </th>
                                                                                                                    <th
                                                                                                                        style="height: 0px;padding: 10px;border:1px solid black">
                                                                                                                        K
                                                                                                                    </th>
                                                                                                                    <th
                                                                                                                        style="height: 0px;padding: 10px;border:1px solid black">
                                                                                                                        Saldo
                                                                                                                        Akhir
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <th style="height: 0px;border:1px solid black;text-align:right"
                                                                                                                        colspan="5">
                                                                                                                        Saldo
                                                                                                                        Sebelumnya
                                                                                                                    </th>
                                                                                                                    <th
                                                                                                                        style="height: 0px;border:1px solid black;text-align:right">
                                                                                                                        Rp.

                                                                                                                        {{ number_format($data[$i]['main_detail'][$j]['branch'][$k]['SaldoAkhirJurnalFix'], 0, '.', ',') }}
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                                @php
                                                                                                                    $totalSaldoBerjalan = $data[$i]['main_detail'][$j]['branch'][$k]['SaldoAkhirJurnalFix'];
                                                                                                                @endphp
                                                                                                                @if (isset($data[$i]['main_detail'][$j]['branch'][$k]['jurnal']))
                                                                                                                    @for ($l = 0; $l < count($data[$i]['main_detail'][$j]['branch'][$k]['jurnal']); $l++)
                                                                                                                        <tr>
                                                                                                                            <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black">
                                                                                                                                {{ $data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['date'] }}
                                                                                                                            </td>
                                                                                                                            <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black">
                                                                                                                                {{ $data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['ref'] }}
                                                                                                                            </td>
                                                                                                                            <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black">
                                                                                                                                {{ $data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['desc'] }}
                                                                                                                            </td>
                                                                                                                            {{-- <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black">
                                                                                                                                @if ($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['debet_kredit'] == 'D')
                                                                                                                                    DEBET
                                                                                                                                @else
                                                                                                                                    KREDIT
                                                                                                                                @endif
                                                                                                                            </td> --}}
                                                                                                                            <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black;text-align:right">
                                                                                                                                @if ($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['debet_kredit'] == 'D')
                                                                                                                                    Rp.
                                                                                                                                    {{ number_format($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['total'], 0, '.', ',') }}
                                                                                                                                @else
                                                                                                                                    0
                                                                                                                                @endif
                                                                                                                            </td>
                                                                                                                            <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black;text-align:right">
                                                                                                                                @if ($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['debet_kredit'] == 'D')
                                                                                                                                    0
                                                                                                                                @else
                                                                                                                                    Rp.
                                                                                                                                    {{ number_format($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['total'], 0, '.', ',') }}
                                                                                                                                @endif
                                                                                                                            </td>
                                                                                                                            <td
                                                                                                                                style="height: 0px;padding-top: 5px;border:1px solid black;text-align:right">
                                                                                                                                @php
                                                                                                                                    if ($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['debet_kredit'] == 'D') {
                                                                                                                                        $totalSaldoBerjalan += $data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['total'];
                                                                                                                                    } else {
                                                                                                                                        if (($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['debet_kredit'] == 'K') && ($data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['acc_debet_kredit'] == 'K')) {
                                                                                                                                            $totalSaldoBerjalan += $data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['total'];
                                                                                                                                        }else{
                                                                                                                                            $totalSaldoBerjalan -= $data[$i]['main_detail'][$j]['branch'][$k]['jurnal'][$l]['total'];
                                                                                                                                        }

                                                                                                                                    }
                                                                                                                                    echo 'Rp. ' . number_format($totalSaldoBerjalan, 0, '.', ',');
                                                                                                                                @endphp
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    @endfor
                                                                                                                    <tr>
                                                                                                                        <th style="height: 0px;border:1px solid black;text-align:right"
                                                                                                                            colspan="5">
                                                                                                                            Saldo
                                                                                                                            Akhir
                                                                                                                        </th>
                                                                                                                        <th
                                                                                                                            style="height: 0px;border:1px solid black;text-align:right">
                                                                                                                            Rp.
                                                                                                                            {{ number_format($totalSaldoBerjalan, 0, '.', ',') }}
                                                                                                                        </th>
                                                                                                                    </tr>
                                                                                                                @endif
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endfor
                                                                            @endif
                                                                        </div>
                                                                        @endif
                                                                    </div>

                                                                @endfor
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endfor
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
            window.location.href = '{{ route('report-periodic.index') }}?&dateS=' + $(".dtpickermnth").val();
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

    {{-- <script src="{{ asset('assets/pages/report/reportPeriodic.js') }}"></script> --}}
@endsection
