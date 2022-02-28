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
        url: "/transaction/payment/payment",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "date" },
        { data: "cost.name" },
        { data: "branch.name" },
        { data: "cash.name" },
        { data: "price" },
        { data: "description" },
        { data: "action", orderable: false, searchable: true },
    ],
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
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data master Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/payment/payment/" + id,
                type: "DELETE",
                success: function () {
                    swal("Data master berhasil dihapus", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Data master Anda tidak jadi dihapus!");
        }
    });
}

function save(params) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            var validation = 0;
            $(".validation").each(function () {
                if (
                    $(this).val() == "" ||
                    $(this).val() == null ||
                    $(this).val() == 0
                ) {
                    validation++;
                    // alert($(this).data("name"));
                    // alert($(".type_id").val());
                    if ($(".type_id").val() == "Pengeluaran") {
                        validation--;
                        // alert('pengeluaran');
                        if ($(this).data("name") != "Transfer Harus Di isi") {
                        validation++;
                        iziToast.warning({
                                type: "warning",
                                title: $(this).data("name"),
                            });
                        }
                        // alert('cek data...');
                    } else {
                        // alert($(this).data("name"));
                        // alert('transfer');
                        iziToast.warning({
                            type: "warning",
                            title: $(this).data("name"),
                        });
                    }
                    // alert('lewatttt..');
                } else {
                    validation - 1;
                }
            });
            console.log('cek total validasi '+validation);

            if (validation != 0) {
                return false;
            }
            console.log('melewati');
            $.ajax({
                url: "/transaction/payment/payment",
                data: $(".form-data").serialize(),
                type: "POST",
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, {
                            icon: "success",
                        });
                        location.reload();
                    } else {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }
                },
                error: function (data) {
                    // edit(id);
                },
            });
        } else {
            swal("diCancel!");
        }
    });
}

function updateData(params) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            var validation = 0;
            $(".validation").each(function () {
                if (
                    $(this).val() == "" ||
                    $(this).val() == null ||
                    $(this).val() == 0
                ) {
                    validation++;
                    // alert($(this).data('name'));
                    if ($(".type_id").val() == "Pengeluaran") {
                        if ($(this).data("name") != "Transfer Harus Di isi") {
                            iziToast.warning({
                                type: "warning",
                                title: $(this).data("name"),
                            });
                        }
                    } else {
                        iziToast.warning({
                            type: "warning",
                            title: $(this).data("name"),
                        });
                    }
                } else {
                    validation - 1;
                }
            });
            if (validation != 0) {
                return false;
            }
            console.log(validation);
            $.ajax({
                url: "/transaction/payment/payment/" + id,
                data: $(".form-data").serialize(),
                type: "PUT",
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, {
                            icon: "success",
                        });
                        // location.reload();
                        // window.location.href = transaction/payment/payment
                    } else {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }
                },
                error: function (data) {
                    // edit(id);
                },
            });
        } else {
            swal("diCancel!");
        }
    });
}

function dropValueCost() {
    var costValue = $(".costValue").find(":selected").data("cost");
    // alert(costValue);
    $("#rupiah").val(parseInt(costValue).toLocaleString("en-US"));
}

function branchChange() {
    var dataItems = [];
    $(".cost").empty();

    var params = $(".branch").find(":selected").val();
    $.each($(".accountData"), function () {
        if (params == $(this).data("branch")) {
            var selected = "";
            if ($(this).data("selected") == "selected") {
                var selected = "selected";
            }

            dataItems +=
                "<option " +
                selected +
                ' value="' +
                this.value +
                '">' +
                $(this).data("name") +
                "</option>";
        }
    });
    $(".cost").append('<option value="">- Select -</option>');
    $(".cost").append(dataItems);
    // Reset Series
}

function typeChange() {
    if ($(".type_id").val() == "Transfer") {
        $(".checkTransfer").css("display", "block");
    } else {
        $(".checkTransfer").css("display", "none");
    }
}

function jurnal(params) {
    $(".dropHereJournals").empty();
    // $('.dropHereJournals').
    $.ajax({
        url: "/transaction/payment/check-journals",
        data: { id: params },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                if (data.jurnal[0].type.includes("Transfer")) {
                    $.each(
                        data.jurnal[0].journal_detail,
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
                        }
                    );

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
                        }
                    );
                } else {
                    $.each(
                        data.jurnal[0].journal_detail,
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
                        }
                    );
                }
            }
            $("#exampleModal").modal("show");
        },
    });
}
