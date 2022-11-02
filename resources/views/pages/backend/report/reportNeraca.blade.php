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
                                    <div class="col-sm-5">
                                        <label>{{ __('Bulan :') }}</label>
                                        <input type="text" class="form-control dtpickermnth" value="{{ date('F Y') }}"
                                        name="dtpickermnth" id="dtpickermnth" />
                                    </div>
                                    <div class="col-sm-5">
                                        <label>{{ __('Cabang :') }}</label>
                                        <select class="form-control" name="branch" id="branch">
                                            <option value="">- Select -</option>
                                            @foreach ($Branch as $el1)
                                                <option value="{{$el1->id}}">{{$el1->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <br>
                                        <button class="btn btn-primary tombol" onclick="searchData()" type="button"
                                        style="margin-bottom: 6px;margin-top:9px"><i class="fas fa-search"></i> Cari</button>
                                        <button class="btn btn-primary tombol ml-2" onclick="expandAll()" type="button"
                                        style="margin-bottom: 6px;margin-top:9px"><i class="fas fa-list"></i> Cetak</button>
                                    </div>
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
        function searchData(params) {
            var date = $(".dtpickermnth").val();
            var branch = $("#branch").val();
            window.location.href = '{{ route('report-neraca.printReportNeraca') }}?&date='+date+'&branch='+branch;
        }
    </script>
    {{-- <script src="{{ asset('assets/pages/report/reportCashBalance.js') }}"></script> --}}
    
@endsection
