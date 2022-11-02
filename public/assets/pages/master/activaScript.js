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
        url: "/finance/activa/activa",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "DT_RowIndex", searchable: false },
        { data: "code" },
        { data: "itemsReal" },
        { data: "branch.name" },
        { data: "date_finished" },
        { data: "account" },
        // { data: "total_depreciation" },
        { data: "activa_group.name" },
        { data: "asset.name" },
        { data: "val" },
        { data: "description" },
        { data: "stat" },
        { data: "action", orderable: false, searchable: true },
    ],
    columnDefs:
    [
     
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
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data finance Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/finance/activa/activa/" + id,
                type: "DELETE",
                success: function (data) {
                    if (data.status == 'success') {
                        swal(data.message, {
                            icon: "success",
                        });
                        table.draw();
                    }else if (data.status == 'restricted') {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }else {
                        swal(data.message, {
                            icon: "error"
                        });
                    }
                },
            });
        } else {
            swal("Data finance Anda tidak jadi dihapus!");
        }
    });
}

function calc(params) {
    var depreciation_rate = $("#depreciation_rate").val();
    var estimate_age = $("#estimate_age").val();
    var total_acquisition = $("#total_acquisition").val().replace(/[^0-9\-]+/g, "") * 1;

    var temp = (total_acquisition * 1) * (depreciation_rate / 100) / 12

    $('#total_depreciation').val(parseInt(temp).toLocaleString('en-US'));
}
function changeSelectItems(params) {
    var with_items = $('#with_items').val();

    if (with_items == 'Y') {
        $('.hiddenItems').css('display', 'none');
        $('.hiddenItemsId').css('display', 'block');
    } else {
        $('.hiddenItems').css('display', 'block');
        $('.hiddenItemsId').css('display', 'none');
    }
}

function changeReason(params) {
    var reason = $('#reason').find(':selected').val();
    // Broken
    // Sell
    // Mutasi
    if (reason == 'Sell') {
        $('.branch_id').css('display', 'none');
        $('.sell_price').css('display', 'block');
    } else if(reason == 'Mutasi') {
        $('.branch_id').css('display', 'block');
        $('.sell_price').css('display', 'none');
    }else{
        $('.branch_id').css('display', 'none');
        $('.sell_price').css('display', 'none');
    }
}

function appendValue(params) {
    
    $('#estimate_age').val($('#activa_group_id').find(':selected').data('estimate'));
    $('#depreciation_rate').val($('#activa_group_id').find(':selected').data('depreciation'));

    calc();
}
function showData(params) {
    $.ajax({
        url: "/finance/activa/activa/check-accumulated?&id=" + params,
        type: "POST",
        success: function (data) {
            if (data.status == 'success') {
                swal(data.message, {
                    icon: "success",
                });
                table.draw();
            }else {
                swal(data.message, {
                    icon: "error"
                });
            }
        },
    });
}
function changeStatus(params) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghentikan penyusutan dari saat ini",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/finance/activa/activa/change-status?&id=" + params,
                type: "get",
                success: function (data) {
                    if (data.status == 'success') {
                        swal(data.message, {
                            icon: "success",
                        });
                        table.draw();
                    }else if (data.status == 'restricted') {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }else {
                        swal(data.message, {
                            icon: "error"
                        });
                    }
                },
            });
        } else {
            swal("Data Anda tidak jadi dihapus!");
        }
    });
}

function stopStoreActive(params) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghentikan penyusutan dari saat ini",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/finance/activa/activa/stop-store-activa?&id=" + params,
                type: "get",
                success: function (data) {
                    if (data.status == 'success') {
                        swal(data.message, {
                            icon: "success",
                        });
                        table.draw();
                    }else if (data.status == 'restricted') {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }else {
                        swal(data.message, {
                            icon: "error"
                        });
                    }
                },
            });
        } else {
            swal("Data Anda tidak jadi dihapus!");
        }
    });
}
function jurnal(params) {
    $('.dropHereJournals').empty();
    // $('.dropHereJournals').
    $.ajax({
        url: "/finance/activa/activa/check-journals",
        data: {id:params},
        type: 'get',
        success: function(data) {

            if (data.status == 'success'){
                $.each(data.jurnal.journal_detail, function(index,value){
                    if (value.debet_kredit == 'K') {
                        var dk = '<td>0</td><td>'+parseInt(value.total).toLocaleString('en-US')+'</td>';
                    }else{
                        var dk = '<td>'+parseInt(value.total).toLocaleString('en-US')+'</td><td>0</td>';
                    }
                    $('.dropHereJournals').append(
                            '<tr>'+
                                '<td>'+value.account_data.code+'</td>'+
                                '<td>'+value.account_data.name+'</td>'+
                                dk+
                            '</tr>'
                    );
                });
            }
            $('#exampleModal').modal('show')

        },
    });
}