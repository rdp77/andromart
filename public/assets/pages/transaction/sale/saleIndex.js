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
        url: "/transaction/sale/sale",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "dataDateOperator" },
        { data: "dataCustomer" },
        { data: "dataItem" },
        { data: "finance" },
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
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data pengguna Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/sale/sale/" + id,
                type: "DELETE",
                success: function () {
                    swal("Data pengguna berhasil dihapus", {
                        icon: "success",
                    });
                    location.reload();
                    table.draw();
                },
            });
        } else {
            swal("Data pengguna Anda tidak jadi dihapus!");
        }
    });
}

function jurnal(params) {
    // $('.dropHereJournals').
    $.ajax({
        url: "/transaction/service/check-journals",
        data: { id: params },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHereJournals").empty();
                $(".dropHereJournalsHpp").empty();

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
                if (typeof data.jurnal[1] != 'undefined') {
                    $.each(data.jurnal[1].journal_detail, function (index, value) {
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
                        $(".dropHereJournalsHpp").append(
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
                }

            }
            $("#exampleModal").modal("show");
        },
    });
}
