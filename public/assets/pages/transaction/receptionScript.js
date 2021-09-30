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
        url: "/transaction/purchasing/reception",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "date" },
        { data: "code" },
        { data: "done" },
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
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data peraturan Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/purchasing/reception/" + id,
                type: "DELETE",
                success: function () {
                    swal("Penerimaan berhasil dihapus", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Penerimaan Anda tidak jadi dihapus!");
        }
    });
}

function checkQty(length) {
    var qtyOld = $('.qtyOld_' + length).val();
    var qtyNew = $('.qtyNew_' + length).val();
    var intOld = parseInt(qtyOld);
    var intNew = parseInt(qtyNew);
    if(intNew > intOld) {
        $('.qtyNew_' + length).val(0);
        alert("Jumlah yang diambil lebih banyak");
    }
}
var loading = `-- sedang memuat data --`;
function historys(token, url, target, id, history) {
    console.log(token);
    $(target).html(loading);
    $.post(url, {
        _token: token,
        id,
        history
    },
    function (data) {
        console.log(data);
        $(target).html(data);
    });
}

function deleted(id) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data barang Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/purchasing/reception/" + id,
                type: "DELETE",
                success: function () {
                    swal("Data barang berhasil dihapus", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Data barang Anda tidak jadi dihapus!");
        }
    });
}

// function edited(token, id, history, length) {
function edited(token, id, history) {
    var qtyEdit = $('.qtyEdit_' + history).val();

    console.log(id);
    console.log(history);
    console.log(qtyEdit);
    swal({
        title: "Apakah Anda Yakin?",
        text: "Mengubah data penerimaan barang",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            // $.get("/transaction/purchasing/reception/updated/" + id + "/" + history + "/" + qtyEdit);
            $.ajax({
                url: "/transaction/purchasing/reception/updated/" + id + "/" + history + "/" + qtyEdit,
                type: "GET",
                success: function () {
                    swal("Data barang berhasil diubah", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Data barang Anda tidak jadi diubah!");
        }
    });
}
