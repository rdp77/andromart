@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Laporan Pengeluaran'))
@section('titleContent', __('Laporan Pengeluaran'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Laporan Pengeluaran') }}</div>
@endsection

@section('content')
    {{-- @include('pages.backend.components.filterSearch') --}}
    @include('layouts.backend.components.notification')

    {{-- <style>
    .areaToPrint{
        font-size: 10px;
    }
</style> --}}

    <form class="form-data">
        @csrf
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">Search Data </h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-md-4 col-lg-4">
                                        <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                                        <input id="startDate" type="text" class="form-control datepicker"
                                            name="startDate">
                                    </div>
                                    <div class="form-group col-12 col-md-4 col-lg-4">
                                        <label for="endDate">{{ __('Tanggal Akhir') }}<code>*</code></label>
                                        <input id="endDate" type="text" class="form-control datepicker" name="endDate">
                                    </div>
                                    {{-- </div> --}}
                                    {{-- <div class="row"> --}}
                                    {{-- <div class="form-group col-6 col-md-6 col-lg-6">
                            <label for="startDate">{{ __('Tipe') }}<code>*</code></label>
                            <select class="form-control tipe" name="tipe">
                                <option value="">- select -</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                                <option value="Pemasukan">Pemasukan</option>
                            </select>
                        </div> --}}
                                    <div class="form-group col-12 col-md-4 col-lg-4">
                                        <label for="startDate">{{ __('Cabang') }}<code>*</code></label>
                                        <select class="select2 cabang" name="cabang">
                                            <option value="">- Select -</option>
                                            @foreach ($branch as $el)
                                                <option value="{{ $el->id }}">{{ $el->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-md-12 col-lg-12">
                                        <button class="btn btn-primary" style="margin-right: 20px" type="button"
                                            onclick="checkData()"><i class="fas fa-eye"></i> Cari</button>
                                        <button class="btn btn-warning" type="button" onclick="printDiv()"><i
                                                class="fas fa-print"></i> Cetak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <h2 class="section-title">Total Pengeluaran</h2> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped " id="areaToPrint">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Transaksi</th>
                                        <th class="text-center">Akun</th>
                                        {{-- <th class="text-center">Debet</th> --}}
                                        <th class="text-center">Kredit</th>
                                        {{-- <th class="text-center">total</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="dropHere" style="border: none !important">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6">
                                            <h5>Pengeluaran : <b class="dropPengeluaran">Rp. 0</b></h5>
                                        </th>
                                        {{-- <th colspan="3"><h5>Pendapatan : <b class="dropPendapatan">Rp. 0</b></h5></th> --}}
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- <div class="dropHereTotalVal"></div> --}}

                        </div>
                    </div>
                </div>
        </section>
    </form>
@endsection
@section('script')

    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        function checkData() {
            var dateS = $("#startDate").val();
            var dateE = $("#endDate").val();
            var tipe = $(".tipe").val();
            var cabang = $(".cabang").val();
            var jurnalDetailD = [];
            var jurnalDetailK = [];
            var jurnalDetailTransaksi = [];

            $(".dropHere").empty();
            $.ajax({
                url: "/report/report/search-report-spending",
                data: {
                    dateS: dateS,
                    dateE: dateE,
                    tipe: tipe,
                    cabang: cabang
                },
                type: "POST",
                success: function(data) {
                    if (data.status == "success") {
                        $(".dropHere").empty();
                        if (data.message == "empty") {
                            $(".dropHere").empty();
                        } else {
                            var totalPengeluaran = 0;
                            $.each(data.result, function(index, value) {
                                if (value.journal_detail[0]
                                    .account_data.main_detail_id == 29 ||
                                    value.journal_detail[0]
                                    .account_data.main_detail_id == 12 ||
                                    value.journal_detail[0]
                                    .account_data.main_detail_id == 28 ||
                                    value.type == 'Transfer Masuk') {
                                    }else{
                                    $.each(
                                        value.journal_detail,
                                        function(index1, value1) {

                                            console.log(parseInt(
                                                value.journal_detail[0]
                                                .total
                                            ).toLocaleString("en-US"));

                                            if (data.cabang == null) {
                                                jurnalDetailTransaksi[index] =
                                                    "<b>" +
                                                    value.journal_detail[0]
                                                    .account_data.code + "</b><br>" +
                                                    value.journal_detail[0]
                                                    .account_data.name;
                                                jurnalDetailK[index] =
                                                    " Rp. " +
                                                    parseInt(
                                                        value.journal_detail[0]
                                                        .total
                                                    ).toLocaleString("en-US");
                                            } else {
                                                if (
                                                    data.cabang ==
                                                    value.journal_detail[0]
                                                    .account_data.branch_id
                                                ) {
                                                    jurnalDetailTransaksi[index] =
                                                        "<b>" +
                                                        value.journal_detail[0]
                                                        .account_data.code +
                                                        "</b><br>" +
                                                        value.journal_detail[0]
                                                        .account_data.name;
                                                    jurnalDetailK[index] =
                                                        " Rp. " +
                                                        parseInt(
                                                            value
                                                            .journal_detail[0]
                                                            .total
                                                        ).toLocaleString(
                                                            "en-US"
                                                        );
                                                }
                                            }
                                        }
                                    );
                                    if (jurnalDetailK[index] == undefined) {
                                        var jurnalDetailKReal = "";
                                    } else {
                                        var jurnalDetailKReal = jurnalDetailK[index];
                                    }

                                    if (jurnalDetailTransaksi[index] != undefined) {

                                        totalPengeluaran += value.total;

                                        $(".dropHere").append(
                                            "<tr>" +
                                            "<td><b>" +
                                            value.code +
                                            "</b><br>" +
                                            value.type +
                                            "</td>" +
                                            "<td><b>" +
                                            moment(value.date).format(
                                                "DD MMMM YYYY"
                                            ) +
                                            "</b></td>" +
                                            "<td><b>" +
                                            value.ref +
                                            "</b><br>" +
                                            value.description +
                                            "</td>" +
                                            "<td>" +
                                            jurnalDetailTransaksi[index] +
                                            "</td>" +
                                            "<td><b>" +
                                            jurnalDetailKReal +
                                            "</b></td>" +
                                            "</tr>"
                                        );

                                    }

                                }
                            });


                            $(".dropPengeluaran").text(
                                "Rp. " +
                                parseInt(totalPengeluaran).toLocaleString("en-US")
                            );

                        }
                    }
                },
                error: function(data) {},
            });
        }

        function printDiv() {
            var outputString =
                '<style type="text/css">' +
                "#areaToPrint {" +
                "font-size:5px;font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;color: black;" +
                "}" +
                "#areaToPrint td, #areaToPrint th {" +
                "border: 1px solid black;padding: 8px;" +
                "}" +
                "#areaToPrint tr:nth-child(even){" +
                "background-color: #f2f2f2;" +
                "}" +
                "#areaToPrint tr:hover {" +
                "background-color: #ddd;" +
                "}" +
                "#areaToPrint th {" +
                "padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #04AA6D;" +
                "}" +
                "</style>";

            var divToPrint = document.getElementById("areaToPrint");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.write(outputString);
            newWin.print();
            newWin.close();
        }
    </script>
@endsection
