@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Laporan Kas Bulanan'))
@section('titleContent', __('Laporan Kas Bulanan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Laporan Kas Bulanan') }}</div>
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
                        <h2 class="section-title">Periode Bulan <b class="dropMonth">{{ date('F Y') }}</b> </h2>
                        <div class="card">


                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-11  mb-1">
                                        <label for="inputPassword2" class="sr-only">Bulan</label>
                                        <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                            name="dtpickermnth" id="dtpickermnth" />
                                    </div>
                                    <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                        style="margin-bottom: 6px"><i class="fas fa-search"></i> Cari</button>
                                </div>
                                <br>
                                <div class="row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                {{-- <th>Kode</th> --}}
                                                <th>Nama</th>
                                                {{-- <th>Cabang</th> --}}
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="dropHere">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="dropTotal">

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">Laporan Kas Saat ini <b>{{ date('d F Y') }}</b> </h2>
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @for ($i = 0; $i < count($data); $i++)
                                                <tr>
                                                    <th>
                                                        @php
                                                            // var_dump($data[$i]);
                                                            echo $data[$i]['namaAkun'];
                                                            $total += $data[$i]['total'];
                                                            // var_dump($data[$i]['akun']);
                                                        @endphp
                                                    </th>
                                                    {{-- @for ($j = 0; $j < count($data[$i]['jurnal']); $j++) --}}
                                                    <th style="text-align: right">Rp.
                                                        {{ number_format($data[$i]['total'], 0, ',', ',') }}
                                                        {{-- @endfor --}}
                                                    </th>
                                                </tr>
                                            @endfor

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-header" style="background-color: #ffffdc; color:black">
                            <h3>Total Kas : Rp. {{ number_format($total, 0, ',', ',') }}</h3>
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
