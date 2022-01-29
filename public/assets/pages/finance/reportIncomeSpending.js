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

    var totalPengeluaran = 0;
    var totalPendapatan = 0;
    $(".dropHere").empty();
    $.ajax({
        url: "/finance/report/search-report-income-spending",
        data: { dateS: dateS, dateE: dateE, tipe: tipe , cabang: cabang},
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHere").empty();
                if (data.message == "empty") {
                    $(".dropHere").empty();
                } else {
                    $.each(data.result, function (index, value) {
                        if (value.code.includes("KK")) {
                            totalPengeluaran += value.total;
                        } else {
                            totalPendapatan += value.total;
                        }

                        $.each(value.journal_detail, function (index1, value1) {

                            // if (value.journal_detail[1].account_data.name.includes('Transfer / Setoran')) {

                            //     jurnalDetailTransaksi[index] =
                            //     "<b>" +
                            //     value.journal_detail[1].account_data.code +
                            //     "</b><br>" +
                            //     value.journal_detail[1].account_data.name;
                            
                            // }else{
                            
                                jurnalDetailTransaksi[index] =
                                "<b>" +
                                value.journal_detail[0].account_data.code +
                                "</b><br>" +
                                value.journal_detail[0].account_data.name;
                            
                            // }
                            

                            if (value.code.includes("DD")) {
                                jurnalDetailD[index] =
                                    " Rp. " +
                                    parseInt(
                                        value.journal_detail[0].total
                                    ).toLocaleString("en-US");
                            } else {
                                jurnalDetailK[index] =
                                    " Rp. " +
                                    parseInt(
                                        value.journal_detail[0].total
                                    ).toLocaleString("en-US");
                            }
                        });

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
                        
                        $(".dropHere").append(
                            "<tr>" +
                                "<td><b>" +
                                value.code +
                                "</b><br>" +
                                value.type +
                                "</td>" +
                                "<td><b>" +
                                moment(value.date).format("DD MMMM YYYY") +
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
                                // '<td style="vertical-align: top;"><b> Rp. '+
                                //     parseInt(value.total).toLocaleString('en-US')+
                                // '</b></td>'+
                                "</tr>"
                        );
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
