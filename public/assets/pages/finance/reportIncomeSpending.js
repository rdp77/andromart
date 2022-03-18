$(".filter_name").on("keyup", function () {
    table.search($(this).val()).draw();
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// fungsi update status
function checkData() {
    var dateS = $("#startDate").val();
    var dateE = $("#endDate").val();
    var tipe = $(".tipe").val();
    var cabang = $(".cabang").val();
    // $('.dropHereTotal').text(0);
    // $('.dropHereTotalVal').val(0);
    var jurnalDetailD = [];
    var jurnalDetailK = [];
    var jurnalDetailTransaksi = [];

    $(".dropHere").empty();
    $.ajax({
        url: "/finance/report/search-report-income-spending",
        data: { dateS: dateS, dateE: dateE, tipe: tipe, cabang: cabang },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHere").empty();
                if (data.message == "empty") {
                    $(".dropHere").empty();
                } else {
                    var totalPengeluaran = 0;
                    var totalPendapatan = 0;
                    $.each(data.result, function (index, value) {
                        if (data.tipe == "Pengeluaran") {
                            // $.each(
                            //     value.journal_detail,
                            //     function (index1, value1) { 
                            //         jurnalDetailTransaksi[index] =
                            //             "<b>" +
                            //             value.journal_detail[0].account_data
                            //                 .code +
                            //             "</b><br>" +
                            //             value.journal_detail[0].account_data
                            //                 .name;
                            //         if (value.code.includes("DD")) {
                            //             jurnalDetailD[index] = " Rp. 0";
                            //         } else {
                            //             jurnalDetailK[index] =
                            //                 " Rp. " +
                            //                 parseInt(
                            //                     value.journal_detail[0].total
                            //                 ).toLocaleString("en-US");
                            //         }
                            //     }
                            // );

                            $.each(
                                value.journal_detail,
                                function (index1, value1) {
                                    if (data.cabang == null) {
                                        jurnalDetailTransaksi[index] =
                                            "<b>" +
                                            value.journal_detail[0].account_data
                                                .code +
                                            "</b><br>" +
                                            value.journal_detail[0].account_data
                                                .name;
                                        if (value.code.includes("DD")) {
                                            jurnalDetailD[index] = " Rp. 0";
                                        } else {
                                            jurnalDetailK[index] =
                                                " Rp. " +
                                                parseInt(
                                                    value.journal_detail[0]
                                                        .total
                                                ).toLocaleString("en-US");
                                        }
                                    } else {
                                        if (
                                            data.cabang ==
                                            value.journal_detail[0].account_data
                                                .branch_id
                                        ) {
                                            jurnalDetailTransaksi[index] =
                                                "<b>" +
                                                value.journal_detail[0]
                                                    .account_data.code +
                                                "</b><br>" +
                                                value.journal_detail[0]
                                                    .account_data.name;
                                            if (value.code.includes("DD")) {
                                                jurnalDetailD[index] = " Rp. 0";
                                            } else {
                                                jurnalDetailK[index] =
                                                    " Rp. " +
                                                    parseInt(
                                                        value.journal_detail[0]
                                                            .total
                                                    ).toLocaleString("en-US");
                                            }
                                        }
                                    }
                                }
                            );
                            if (jurnalDetailK[index] == undefined) {
                                var jurnalDetailKReal = "";
                            } else {
                                var jurnalDetailKReal = jurnalDetailK[index];
                            }
                            if (jurnalDetailD[index] == undefined) {
                                var jurnalDetailDReal = "";
                            } else {
                                var jurnalDetailDReal = "";
                            }
                            if (jurnalDetailTransaksi[index] != undefined) {
                                if (value.code.includes("KK")) {
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
                                            jurnalDetailDReal +
                                            "</b></td>" +
                                            "<td><b>" +
                                            jurnalDetailKReal +
                                            "</b></td>" +
                                            "</tr>"
                                    );
                                } else {
                                    totalPendapatan += 0;
                                }
                            }
                        } else if (data.tipe == "Pemasukan") {
                            $.each(
                                value.journal_detail,
                                function (index1, value1) {
                                    if (data.cabang == null) {
                                        jurnalDetailTransaksi[index] =
                                            "<b>" +
                                            value.journal_detail[0].account_data
                                                .code +
                                            "</b><br>" +
                                            value.journal_detail[0].account_data
                                                .name;
                                        if (value.code.includes("DD")) {
                                            jurnalDetailD[index] =
                                                " Rp. " +
                                                parseInt(
                                                    value.journal_detail[0]
                                                        .total
                                                ).toLocaleString("en-US");
                                        } else {
                                            jurnalDetailK[index] = " Rp. 0";
                                        }
                                    } else {
                                        if (
                                            data.cabang ==
                                            value.journal_detail[0].account_data
                                                .branch_id
                                        ) {
                                            jurnalDetailTransaksi[index] =
                                                "<b>" +
                                                value.journal_detail[0]
                                                    .account_data.code +
                                                "</b><br>" +
                                                value.journal_detail[0]
                                                    .account_data.name;
                                            if (value.code.includes("DD")) {
                                                jurnalDetailD[index] =
                                                    " Rp. " +
                                                    parseInt(
                                                        value.journal_detail[0]
                                                            .total
                                                    ).toLocaleString("en-US");
                                            } else {
                                                jurnalDetailK[index] = " Rp. 0";
                                            }
                                        }
                                    }
                                }
                            );

                            if (jurnalDetailD[index] == undefined) {
                                var jurnalDetailDReal = "";
                            } else {
                                var jurnalDetailDReal = jurnalDetailD[index];
                            }
                            if (jurnalDetailK[index] == undefined) {
                                var jurnalDetailKReal = "";
                            } else {
                                var jurnalDetailKReal = "";
                            }
                            if (jurnalDetailTransaksi[index] != undefined) {
                                if (value.code.includes("KK")) {
                                    totalPengeluaran += 0;
                                } else {
                                    totalPendapatan += value.total;
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
                                            jurnalDetailDReal +
                                            "</b></td>" +
                                            "<td><b>" +
                                            jurnalDetailKReal +
                                            "</b></td>" +
                                            "</tr>"
                                    );
                                }
                            }
                        } else {
                            $.each(
                                value.journal_detail,
                                function (index1, value1) {
                                    if (data.cabang == null) {
                                        jurnalDetailTransaksi[index] =
                                            "<b>" +
                                            value.journal_detail[0].account_data
                                                .code +
                                            "</b><br>" +
                                            value.journal_detail[0].account_data
                                                .name;
                                        if (value.code.includes("DD")) {
                                            jurnalDetailD[index] =
                                                " Rp. " +
                                                parseInt(
                                                    value.journal_detail[0]
                                                        .total
                                                ).toLocaleString("en-US");
                                        } else {
                                            jurnalDetailK[index] =
                                                " Rp. " +
                                                parseInt(
                                                    value.journal_detail[0]
                                                        .total
                                                ).toLocaleString("en-US");
                                        }
                                    } else {
                                        if (
                                            data.cabang ==
                                            value.journal_detail[0].account_data
                                                .branch_id
                                        ) {
                                            jurnalDetailTransaksi[index] =
                                                "<b>" +
                                                value.journal_detail[0]
                                                    .account_data.code +
                                                "</b><br>" +
                                                value.journal_detail[0]
                                                    .account_data.name;
                                            if (value.code.includes("DD")) {
                                                jurnalDetailD[index] =
                                                    " Rp. " +
                                                    parseInt(
                                                        value.journal_detail[0]
                                                            .total
                                                    ).toLocaleString("en-US");
                                            } else {
                                                jurnalDetailK[index] =
                                                    " Rp. " +
                                                    parseInt(
                                                        value.journal_detail[0]
                                                            .total
                                                    ).toLocaleString("en-US");
                                            }
                                        }
                                    }
                                }
                            );
                            // console.log(jurnalDetailTransaksi[index]);
                            if (jurnalDetailD[index] == undefined) {
                                var jurnalDetailDReal = "";
                            } else {
                                var jurnalDetailDReal = jurnalDetailD[index];
                            }

                            if (jurnalDetailK[index] == undefined) {
                                var jurnalDetailKReal = "";
                            } else {
                                var jurnalDetailKReal = jurnalDetailK[index];
                            }

                            if (jurnalDetailTransaksi[index] != undefined) {
                                if (value.code.includes("KK")) {
                                    totalPengeluaran += value.total;
                                } else {
                                    totalPendapatan += value.total;
                                }
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
                                        jurnalDetailDReal +
                                        "</b></td>" +
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
                    $(".dropPendapatan").text(
                        "Rp. " +
                            parseInt(totalPendapatan).toLocaleString("en-US")
                    );
                    // $('.dropHereTotalVal').html('<input type="hidden" class="form-control" name="totalValue" value="'+totalAkhir+'">');
                }
            }
        },
        error: function (data) {},
    });
}


function printDiv() {
    var outputString = 
    '<style type="text/css">'+
    '#areaToPrint {font-size:5px;font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;}'+
    '#areaToPrint td, #areaToPrint th {border: 1px solid #ddd;padding: 8px;}'+
    '#areaToPrint tr:nth-child(even){background-color: #f2f2f2;}'+
    '#areaToPrint tr:hover {background-color: #ddd;}'+
    '#areaToPrint th {padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #04AA6D;color: red;}'+
    '</style>';
    var divToPrint = document.getElementById('areaToPrint');
    newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.document.write(outputString);
    newWin.print();
    newWin.close();
}