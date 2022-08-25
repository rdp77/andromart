"use strict";

var table = $("#table").DataTable({
    pageLength: 10,
    processing: true,
    serverSide: true,
    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Semua"],
    ],
    ajax: {
        url: "/finance/sharing-profit/sharing-profit",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "created_by" },
        { data: "dateFormat" },
        { data: "dateRange" },
        { data: "technician.name" },
        { data: "totalValue" },
        { data: "action", orderable: false, searchable: true },
    ],
    order: [[0, "desc"]],
    buttons: [
        {
            extend: "print",
            text: "Print Semua",
            exportOptions: {
                modifier: {
                    selected: null,
                },
                columns: ":visible",
            },
            messageTop: "Dokumen dikeluarkan tanggal " + moment().format("L"),
            // footer: true,
            header: true,
        },
        {
            extend: "csv",
        },
        {
            extend: "print",
            text: "Print Yang Dipilih",
            exportOptions: {
                columns: ":visible",
            },
        },
        {
            extend: "excelHtml5",
            exportOptions: {
                columns: ":visible",
            },
        },
        {
            extend: "pdfHtml5",
            exportOptions: {
                columns: [0, 1, 2, 5],
            },
        },
        {
            extend: "colvis",
            postfixButtons: ["colvisRestore"],
            text: "Sembunyikan Kolom",
        },
    ],
});

$(".filter_name").on("keyup", function () {
    table.search($(this).val()).draw();
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function del(id) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data pengguna Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/finance/sharing-profit/sharing-profit/" + id,
                type: "DELETE",
                success: function () {
                    swal("Data pengguna berhasil dihapus", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Data tidak jadi dihapus!");
        }
    });
}

function save() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            $.ajax({
                url: "/transaction/service/service",
                data: $(".form-data").serialize(),
                type: "POST",
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, {
                            icon: "success",
                        });
                        location.reload();
                    }
                },
                error: function (data) {
                    // edit(id);
                },
            });
        } else {
            swal("Dibatalkan !");
        }
    });
}

// fungsi update status
function checkEmploye() {
    var technicianId = $(".technicianId").find(":selected").val();
    var dateS = $("#startDate").val();
    var dateE = $("#endDate").val();
    $(".dropHereTotal").text(0);
    $(".dropHereTotalVal").val(0);
    $(".dropHere").empty();
    $.ajax({
        url: "/finance/sharing-profit/sharing-profit-load-data-service",
        data: { id: technicianId, dateS: dateS, dateE: dateE },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHere").empty();
                if (data.message == "empty") {
                    $(".dropHere").empty();
                    $(".hiddenFormUpdate").css("display", "none");
                } else {
                    if (data.result.work_status == "Selesai") {
                        $(".hiddenFormUpdate").css("display", "none");
                    } else {
                        $(".hiddenFormUpdate").css("display", "block");
                    }
                    var totalAkhir = 0;
                    $.each(data.result, function (index, value) {
                        if (value.technician_id == technicianId) {
                            var totalProfit = value.sharing_profit_technician_1;
                        } else {
                            var totalProfit = value.sharing_profit_technician_2;
                        }
                        if (value.sharing_profit_detail.length == 0) {
                            var pay =
                                '<div class="badge badge-danger">Belum Bayar</div>';
                            var payDetail = "Belum Bayar";
                            totalAkhir += totalProfit;
                        } else {
                            if (value.sharing_profit_detail[0].sharing_profit.employe_id != value.technician_id) {
                                var pay =
                                '<div class="badge badge-danger">Belum Bayar</div>';
                                var payDetail = "Belum Bayar";
                                totalAkhir += totalProfit;

                                console.log('cari belom bayar');
                            
                            } else {
                                var pay =
                                '<div class="badge badge-success">Sudah Dibayarkan</div>';
                                var payDetail = "Sudah Dibayarkan";
                                totalAkhir += 0;
                            }
                         
                        }
                        // totalAkhir += totalProfit;
                        $(".dropHere").append(
                            "<tr>" +
                                '<td style="display:none">' +
                                '<input type="text" class="form-control" name="typeDetail[]" value="Service">' +
                                '<input type="text" class="form-control" name="codeDetail[]" value="' +
                                value.code +
                                '">' +
                                '<input type="text" class="form-control" name="totalDetail[]" value="' +
                                totalProfit +
                                '">' +
                                '<input type="text" class="form-control" name="payDetail[]" value="' +
                                payDetail +
                                '">' +
                                "</td>" +
                                "<td>" +
                                '<a href="https://andromartindonesia.com/transaction/service/service/' +
                                value.id +
                                '/show">' +
                                value.code +
                                "</a>" +
                                "</td>" +
                                "<td>" +
                                moment(value.payment_date).format(
                                    "DD MMMM YYYY"
                                ) +
                                "</td>" +
                                "<td>" +
                                value.customer_name +
                                "</td>" +
                                "<td>" +
                                parseInt(totalProfit).toLocaleString("en-US") +
                                "</td>" +
                                "<td>" +
                                pay +
                                "</td>" +
                                "</tr>"
                        );
                    });

                    $.each(
                        data.sharingProfitSaleSales,
                        function (index, value) {
                            if (value.sale.sharing_profit_detail.length == 0) {
                                var pay =
                                    '<div class="badge badge-danger">Belum Bayar</div>';
                                var payDetail = "Belum Bayar";
                                totalAkhir += value.sharing_profit_sales;
                            } else {
                                var pay =
                                    '<div class="badge badge-success">Sudah Dibayarkan</div>';
                                var payDetail = "Sudah Dibayarkan";
                                totalAkhir += 0;
                            }

                            $(".dropHere").append(
                                "<tr>" +
                                    '<td style="display:none">' +
                                    '<input type="text" class="form-control" name="typeDetail[]" value="Penjualan">' +
                                    '<input type="text" class="form-control" name="codeDetail[]" value="' +
                                    value.sale.code +
                                    '">' +
                                    '<input type="text" class="form-control" name="totalDetail[]" value="' +
                                    value.sharing_profit_sales +
                                    '">' +
                                    '<input type="text" class="form-control" name="payDetail[]" value="' +
                                    payDetail +
                                    '">' +
                                    "</td>" +
                                    "<td>" +
                                    '<a href="https://andromartindonesia.com/transaction/sale/sale/' +
                                    value.sale.id +
                                    '">' +
                                    value.sale.code +
                                    "</a>" +
                                    "</td>" +
                                    "<td>" +
                                    moment(value.sale.date).format(
                                        "DD MMMM YYYY"
                                    ) +
                                    "</td>" +
                                    "<td>" +
                                    value.sale.customer_name +
                                    "</td>" +
                                    "<td>" +
                                    parseInt(
                                        value.sharing_profit_sales
                                    ).toLocaleString("en-US") +
                                    "</td>" +
                                    "<td>" +
                                    pay +
                                    "</td>" +
                                    "</tr>"
                            );
                        }
                    );
                    $.each(
                        data.sharingProfitSaleBuyer,
                        function (index, value) {
                            if (value.sale.sharing_profit_detail.length == 0) {
                                var pay =
                                    '<div class="badge badge-danger">Belum Bayar</div>';
                                var payDetail = "Belum Bayar";
                                totalAkhir += value.sharing_profit_buyer;
                            } else {
                                var pay =
                                    '<div class="badge badge-success">Sudah Dibayarkan</div>';
                                var payDetail = "Sudah Dibayarkan";
                                totalAkhir += 0;
                            }
                            $(".dropHere").append(
                                "<tr>" +
                                    '<td style="display:none">' +
                                    '<input type="text" class="form-control" name="typeDetail[]" value="Penjualan">' +
                                    '<input type="text" class="form-control" name="codeDetail[]" value="' +
                                    value.sale.code +
                                    '">' +
                                    '<input type="text" class="form-control" name="totalDetail[]" value="' +
                                    value.sharing_profit_buyer +
                                    '">' +
                                    '<input type="text" class="form-control" name="payDetail[]" value="' +
                                    payDetail +
                                    '">' +
                                    "</td>" +
                                    "<td>" +
                                    '<a href="https://andromartindonesia.com/transaction/sale/sale/' +
                                    value.sale.id +
                                    '">' +
                                    value.sale.code +
                                    "</a>" +
                                    "</td>" +
                                    "<td>" +
                                    moment(value.sale.date).format(
                                        "DD MMMM YYYY"
                                    ) +
                                    "</td>" +
                                    "<td>" +
                                    value.sale.customer_name +
                                    "</td>" +
                                    "<td>" +
                                    parseInt(
                                        value.sharing_profit_buyer
                                    ).toLocaleString("en-US") +
                                    "</td>" +
                                    "<td>" +
                                    pay +
                                    "</td>" +
                                    "</tr>"
                            );
                        }
                    );
                    $(".dropHereTotal").text(
                        parseInt(totalAkhir).toLocaleString("en-US")
                    );
                    $(".dropHereTotalVal").html(
                        '<input type="hidden" class="form-control" name="totalValue" value="' +
                            totalAkhir +
                            '">'
                    );
                    $(".totalSharingProfit").val(
                        parseInt(totalAkhir).toLocaleString("en-US")
                    );
                    hitung();
                }
            }
        },
        error: function (data) {},
    });

    var technicianId = $(".technicianId").find(":selected").val();
    var dateS = $("#startDate").val();
    var dateE = $("#endDate").val();
    $(".dropHereLossTotal").text(0);
    $(".dropHereLossTotalVal").val(0);
    $(".dropHereLoss").empty();
    $.ajax({
        url: "/finance/loss-items/loss-items-load-data-service",
        data: { id: technicianId, dateS: dateS, dateE: dateE },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHereLoss").empty();
                if (data.message == "empty") {
                    $(".dropHereLoss").empty();
                    $(".hiddenFormUpdate").css("display", "none");
                } else {
                    if (data.result.work_status == "Selesai") {
                        $(".hiddenFormUpdate").css("display", "none");
                    } else {
                        $(".hiddenFormUpdate").css("display", "block");
                    }
                    var totalAkhir = 0;
                    $.each(data.result, function (index, value) {
                        var totalLoss2 = 0;
                        var totalLoss = 0;
                        if (value.technician_id == technicianId) {
                            totalLoss = value.total_loss_technician_1;
                        } else {
                            totalLoss = 0;
                        }
                        if (value.technician_replacement_id == technicianId) {
                            totalLoss2 = value.total_loss_technician_2;
                        } else {
                            totalLoss2 = 0;
                        }
                        var totalLossTech = totalLoss + totalLoss2;
                        if(value.technician_replacement_id == null){
                            var totalLossStore = value.total_loss_store;
                            var totalLossALL = totalLossTech + value.total_loss_store;
                            // console.log('teknisi 2 kosong');
                        }else{
                            var totalLossStore = parseInt(value.total_loss_store) / 2;
                            var totalLossALL = parseInt(value.total_loss_store / 2)+totalLossTech;
                            // console.log('teknisi 2 tidak kosong');
                        }

                        if (value.loss_items_detail.length == 0) {
                            var pay =
                                '<div class="badge badge-danger">Belum Bayar</div>';
                            var payDetailLoss = "Belum Bayar";
                            totalAkhir += totalLossTech;
                        } else {
                            var pay =
                                '<div class="badge badge-success">Sudah Dibayarkan</div>';
                            var payDetailLoss = "Sudah Dibayarkan";
                            totalAkhir += 0;
                        }

                        $(".dropHereLoss").append(
                            "<tr>" +
                                '<td style="display:none">' +
                                '<input type="text" class="form-control" name="idDetailLoss[]" value="' +
                                value.id +
                                '">' +
                                '<input type="text" class="form-control" name="totalDetailLoss[]" value="' +
                                totalLossTech +
                                '">' +
                                '<input type="text" class="form-control" name="totalAllLoss[]" value="' +
                                totalLossALL +
                                '">' +
                                '<input type="text" class="form-control" name="totalLossStore[]" value="' +
                                totalLossStore +
                                '">' +
                                '<input type="text" class="form-control" name="payDetailLoss[]" value="' +
                                payDetailLoss +
                                '">' +
                                "</td>" +
                                "<td>" +
                                '<a href="https://andromartindonesia.com/transaction/service/service/"' +
                                value.id +
                                '"/show">' +
                                value.code +
                                "</a>" +
                                "</td>" +
                                "<td>" +
                                moment(value.date).format("DD MMMM YYYY") +
                                "</td>" +
                                "<td>" +
                                value.customer_name +
                                "</td>" +
                                "<td>" +
                                parseInt(totalLossTech).toLocaleString(
                                    "en-US"
                                ) +
                                "</td>" +
                                "<td>" +
                                pay +
                                "</td>" +
                                "</tr>"
                        );
                    });
                    $(".dropHereLossTotal").text(
                        parseInt(totalAkhir).toLocaleString("en-US")
                    );
                    $(".dropHereLossTotalVal").html(
                        '<input type="hidden" class="form-control" name="totalValueLoss" value="' +
                            totalAkhir +
                            '">'
                    );
                    $(".totalLoss").val(
                        parseInt(totalAkhir).toLocaleString("en-US")
                    );
                    hitung();
                }
            }
        },
        error: function (data) {},
    });
}

function saveSharingProfit() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            // var checkLoad = 0;
            $.ajax({
                url: "/finance/sharing-profit/sharing-profit",
                data: $(".form-data").serialize(),
                type: "POST",
                success: function (data) {
                    if (data.status == "success") {
                        // swal("Data Telah Tersimpan", {
                        //     icon: "success",
                        // });
                        $.ajax({
                            url: "/finance/loss-items/loss-items",
                            data: $(".form-data").serialize(),
                            type: "POST",
                            success: function (data) {
                                if (data.status == "success") {
                                    swal("Data Telah Tersimpan", {
                                        icon: "success",
                                    });
                                    // location.reload();
                                }
                            },
                            error: function (data) {},
                        });
                    } else {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }
                },
                error: function (data) {},
            });

            
            // console.log(checkLoad);
            // if (checkLoad == 2) {
            // }else{
            //     swal("Data Tidak Bisa Disimpan", {
            //         icon: "error",
            //     });
            // }

        } else {
            swal("Dibatalkan !");
        }
    });
}
function paymentMethodChange() {
    var value = $(".accountMain").find(":selected").data("name");
    var dataItems = [];
    $(".accountData").empty();
    var testStr;
    $.each($(".accountDataHidden"), function () {
        testStr = $(this).data("maindetailname");
        // console.log(testStr);
        if (testStr.includes(value)) {
            dataItems +=
                '<option value="' +
                this.value +
                '">' +
                $(this).data("code") +
                " - " +
                $(this).data("name") +
                "</option>";
        }
    });
    // console.log(value);
    // console.log(dataItems);
    $(".accountData").append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $(".accountData").append(dataItems);
    // }
    // alert($('.PaymentMethod').val());
}

function hitung() {
    var SharingProfit = $(".totalSharingProfit").val();
    var Loss = $(".totalLoss").val();
    var totalSubtraction = $(".totalSubtraction").val();
    // var str = "JavaScript replace method test";
    // var res = str.replace("test", "success");
    // console.log(str);
    // console.log(res);
    // console.log(SharingProfit.replace(",", ""));
    // console.log(SharingProfit);
    // console.log(Loss);
    // console.log(totalSubtraction);
    // console.log(parseInt(SharingProfit.replace(/,/g, "")));
    // console.log(parseInt(Loss.replace(/,/g, "")));
    // console.log(parseInt(totalSubtraction.replace(/,/g, "")));
    // console.log(parseInt(SharingProfit.replace(/,/g, "")-Loss.replace(/,/g, "")));
    // console.log(parseInt(SharingProfit.replace(/,/g, "")-Loss.replace(/,/g, "")-totalSubtraction.replace(/,/g, "")));
    var total = parseInt(
        SharingProfit.replace(/,/g, "") -
            Loss.replace(/,/g, "") -
            totalSubtraction.replace(/,/g, "")
    );
    $(".total").val(parseInt(total).toLocaleString("en-US"));
}

function jurnal(params) {
    // $('.dropHereJournals').
    $.ajax({
        url: "/finance/sharing-profit/check-journals",
        data: { id: params },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHereJournals").empty();
                $(".dropHereJournalsHpp").empty();
                $(".dropHereJournalsBalikDownPayment").empty();

                // alert('sd');
                $.each(data.jurnal[0].journal_detail, function (index, value) {
                    if (value.debet_kredit == "K") {
                        var dk =
                            "<td>0</td><td>" +
                            parseInt(value.total).toLocaleString("en-US") +
                            "</td>";
                    } else {
                        var dk =
                            "<td>" +
                            parseInt(value.total).toLocaleString("en-US") +
                            "</td><td>0</td>";
                    }
                    $(".dropHereJournals").append(
                        "<tr>" +
                            "<td>" +
                            value.account_data.code +
                            "</td>" +
                            "<td>" +
                            value.account_data.name +
                            "</td>" +
                            dk +
                            "</tr>"
                    );
                });
                if (typeof data.jurnal[1] != "undefined") {
                    $.each(
                        data.jurnal[1].journal_detail,
                        function (index, value) {
                            if (value.debet_kredit == "K") {
                                var dk =
                                    "<td>0</td><td>" +
                                    parseInt(value.total).toLocaleString(
                                        "en-US"
                                    ) +
                                    "</td>";
                            } else {
                                var dk =
                                    "<td>" +
                                    parseInt(value.total).toLocaleString(
                                        "en-US"
                                    ) +
                                    "</td><td>0</td>";
                            }
                            $(".dropHereJournalsPengurangan").append(
                                "<tr>" +
                                    "<td>" +
                                    value.account_data.code +
                                    "</td>" +
                                    "<td>" +
                                    value.account_data.name +
                                    "</td>" +
                                    dk +
                                    "</tr>"
                            );
                        }
                    );
                }
               
            }
            $(".exampleModal").modal("show");
        },
    });
}
