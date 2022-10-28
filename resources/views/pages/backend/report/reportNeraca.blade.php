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
                                                Per {{ date('t F Y') }}
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
                                                <th width="49%" style="color:black;border-top: 1px solid black">Aktiva
                                                    Lancar
                                                </th>
                                                <th style="border-left: 1px solid black;border-top: 1px solid black"
                                                    rowspan="100">

                                                </th>
                                                <th width="49%" style="color:black;border-top: 1px solid black">Utang
                                                    Lancar
                                                </th>
                                            </tr>

                                            <tr>
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left:10px;">
                                                                <b>KAS</b>
                                                            </td>
                                                            <td style="padding-left:50px;">
                                                                <b>Rp.</b>
                                                            </td>
                                                            <td style="padding-left:10px;text-align:right">
                                                                <b>{{ number_format($dataKasTotal, 0, ',', ',') }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                        </tr>
                                                        @for ($i = 0; $i < count($accountDataKas); $i++)
                                                            @php
                                                                $namaPerkas;
                                                                $totalPerkas = 0;
                                                            @endphp
                                                            @for ($j = 0; $j < count($dataKas); $j++)
                                                                @if ($accountDataKas[$i]['id'] == $dataKas[$j]['akun_id'])
                                                                    @php
                                                                        $totalPerkas += $dataKas[$j]['total'];
                                                                    @endphp
                                                                @endif
                                                            @endfor

                                                            <tr>
                                                                <td style="padding-left:50px;">
                                                                    {{ $accountDataKas[$i]['name'] }}
                                                                </td>
                                                                <td style="padding-left:50px;">
                                                                    Rp.</td>
                                                                <td style="padding-left:10px;text-align:right">
                                                                    {{ number_format($totalPerkas, 0, ',', ',') }}
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </table>
                                                <td>
                                                    <br><br><br><br><br><br><br><br>
                                                <b>Ekuitas</b>
                                                    <table>
                                                        <tr>
                                                        </tr>
                                                    </table>
                                                    <table>
                                                        <tbody>
                                                            {{-- DATA MODAL --}}
                                                            <tr>
                                                                <td style="padding-left:40px;"><b>MODAL</b></td>
                                                                <td style="padding-left:180px;"><b>Rp.</b></td>
                                                                <td style="padding-left:10px;text-align:right">
                                                                    <b>{{ number_format($dataModalTotal, 0, ',', ',') }}</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                            </tr>
                                                            @for ($i = 0; $i < count($dataModal); $i++)
                                                                @php
                                                                @endphp
                                                                <tr>
                                                                    <td style="padding-left:80px;">
                                                                        {{ $dataModal[$i]['akun_nama'] }}
                                                                    </td>
                                                                    <td style="padding-left:180px;">
                                                                        Rp.</td>
                                                                    <td style="padding-left:18px;text-align:right">
                                                                        {{ number_format($dataModal[$i]['total'], 0, ',', ',') }}
                                                                    </td>
                                                                </tr>
                                                            @endfor

                                                            {{-- DATA SALDO LABA --}}
                                                            <tr>
                                                                <td><br></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-left:40px;"><b>Saldo Laba</b></td>
                                                                <td style="padding-left:180px;"><b>Rp.</b></td>
                                                                <td style="padding-left:10px;text-align:right">
                                                                    <b>{{ number_format(0, 0, ',', ',') }}</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><br></td>
                                                            </tr>
                                                            {{-- DATA LABA TERTAHAN --}}
                                                            <tr>
                                                                <td style="padding-left:40px;"><b>Laba Berjalan</b></td>
                                                                <td style="padding-left:180px;"><b>Rp.</b></td>
                                                                <td style="padding-left:10px;text-align:right">
                                                                    <b>{{ number_format($labaBerjalan, 0, ',', ',') }}</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left:10px;">
                                                                <b>Persediaan</b>
                                                            </td>
                                                            <td style="padding-left:38px;">
                                                                <b>Rp.</b>
                                                            </td>
                                                            <td style="padding-left:18px;text-align:right">
                                                                <b>{{ number_format($dataPersediaanTotal, 0, ',', ',') }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                        </tr>
                                                        @for ($i = 0; $i < count($dataPersediaan); $i++)
                                                            @php
                                                                // $dataPersediaan = 0;
                                                            @endphp
                                                            <tr>
                                                                <td style="padding-left:50px;">
                                                                    {{ $dataPersediaan[$i]['akun_nama'] }}
                                                                </td>
                                                                <td style="padding-left:38px;">
                                                                    Rp.</td>
                                                                <td style="padding-left:18px;text-align:right">
                                                                    {{ number_format($dataPersediaan[$i]['total'], 0, ',', ',') }}
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="49%" style="color:black">Aktiva
                                                    Tetap
                                                </th>

                                            </tr>
                                            <tr>
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left:10px;">
                                                                <b>Asset</b>
                                                            </td>
                                                            <td style="padding-left:138px;">
                                                                <b>Rp.</b>
                                                            </td>
                                                            <td style="padding-left:18px;text-align:right">
                                                                <b>{{ number_format($dataAssetTotal, 0, ',', ',') }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                        </tr>
                                                        @for ($i = 0; $i < count($dataAsset); $i++)
                                                            @php
                                                                // $dataAsset = 0;
                                                            @endphp
                                                            <tr>
                                                                <td style="padding-left:50px;">
                                                                    {{ $dataAsset[$i]['akun_nama'] }}
                                                                </td>
                                                                <td style="padding-left:138px;">
                                                                    Rp.</td>
                                                                <td style="padding-left:18px;text-align:right">
                                                                    {{ number_format($dataAsset[$i]['total'], 0, ',', ',') }}
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th><br></th>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left:10px;">
                                                                <b>Penyusutan</b>
                                                            </td>
                                                            <td style="padding-left:38px;">
                                                                <b>Rp.</b>
                                                            </td>
                                                            <td style="padding-left:18px;text-align:right">
                                                                <b>
                                                                    @if ($dataPenyusutanTotal < 0)
                                                                        ({{ number_format($dataPenyusutanTotal - $dataPenyusutanTotal - $dataPenyusutanTotal, 0, ',', ',') }})
                                                                    @else
                                                                        ({{ number_format($dataPenyusutanTotal, 0, ',', ',') }})
                                                                    @endif
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                        </tr>
                                                        @for ($i = 0; $i < count($dataPenyusutan); $i++)
                                                            @php
                                                                // $dataPenyusutan = 0;
                                                            @endphp
                                                            <tr>
                                                                <td style="padding-left:50px;">
                                                                    {{ $dataPenyusutan[$i]['akun_nama'] }}
                                                                </td>
                                                                <td style="padding-left:38px;">
                                                                    Rp.</td>
                                                                <td style="padding-left:18px;text-align:right">
                                                                    @if ($dataPenyusutan[$i]['total'] < 0)
                                                                        ({{ number_format($dataPenyusutan[$i]['total'] - $dataPenyusutan[$i]['total'] - $dataPenyusutan[$i]['total'], 0, ',', ',') }})
                                                                    @else
                                                                        ({{ number_format($dataPenyusutan[$i]['total'], 0, ',', ',') }})
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </table>

                                                </td>
                                            </tr>
                                            </tr>
                                        </thead>

                                    </table>
                                    <table style="width:100%">
                                        <thead>
                                            <tr style="color:black;border-top: 1px solid black">
                                                <th style="width:50%">
                                                    <table>
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th style="padding-left:348px;">Rp.
                                                                {{ number_format($dataPersediaanTotal + $dataKasTotal - $dataPenyusutanTotal + $dataAssetTotal, 0, ',', ',') }}
                                                            </th>
                                                        </tr>
                                                    </table>


                                                </th>
                                                <th style="width:50%">
                                                    <table>
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th style="padding-left:348px;">Rp.
                                                                {{ number_format($dataModalTotal+$labaBerjalan, 0, ',', ',') }}
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </th>
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
