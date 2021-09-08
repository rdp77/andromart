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
        url: "/transaction/service/service",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        // { data: "code" },
        { data: "Informasi" },
        { data: "dataCustomer" },
        { data: "dataItem" },
        { data: "finance" },
        { data: "currentStatus" },
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
                url: "/transaction/service/service/" + id,
                type: "DELETE",
                success: function () {
                    swal("Data pengguna berhasil dihapus", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Data pengguna Anda tidak jadi dihapus!");
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
                type: 'POST',
                success: function(data) {
                    if (data.status == 'success'){
                        swal(data.message, {
                            icon: "success",
                        });
                        location.reload();
                    }
                },
                error: function(data) {
                    // edit(id);
                }
            });
            
        } else {
            swal("Data Dana Kredit PDL Berhasil Dihapus!");
        }
    });
    
}


// fungsi update status
function checkEmploye() {
    var technicianId = $('.technicianId').find(':selected').val();
    var dateS = $('#startDate').val();
    var dateE = $('#endDate').val();
    $('.dropHere').empty();
    $.ajax({
        url: "/finance/sharing-profit/sharing-profit-load-data-service",
        data: {id:technicianId,dateS:dateS,dateE:dateE},
        type: 'POST',
        success: function(data) {
            if (data.status == 'success'){
                if(data.message == 'empty'){
                    $(".hiddenFormUpdate").css("display", "none");
                }else{
                    if(data.result.work_status == 'Selesai'){
                        $(".hiddenFormUpdate").css("display", "none");
                    }else{
                        $(".hiddenFormUpdate").css("display", "block");
                    }
                    var totalAkhir = 0;
                    $.each(data.result, function(index,value){
                        if (value.technician_id == technicianId) {
                            var totalProfit = value.sharing_profit_technician_1;
                        }else{
                            var totalProfit = value.sharing_profit_technician_2;
                        }
                        if (value.sharing_profit_status == 'Belum') {
                            var pay = '<div class="badge badge-danger">Belum Bayar</div>';
                        }else{
                            var pay = '<div class="badge badge-success">Sudah Dibayarkan</div>';
                        }
                        totalAkhir+=totalProfit;
                        $('.dropHere').append(
                            '<tr>'+
                                '<td style="display:none">'+
                                    '<input type="text" class="form-control" name="priceDetailSparePart[]" value="0">'+
                                    '<input type="text" class="form-control" name="priceDetailLoss[]" value="0">'+
                                '</td>'+
                                '<td>'+
                                    moment(value.date).format('DD MMMM YYYY')+
                                '</td>'+
                                '<td>'+
                                    value.customer_name+
                                '</td>'+
                                '<td>'+
                                    parseInt(totalProfit).toLocaleString()+
                                '</td>'+
                                '<td>'+
                                    pay+
                                '</td>'+
                            '</tr>'
                        );
                    });
                    $('.dropHereTotal').text(parseInt(totalAkhir).toLocaleString());
                }
            }
        },
        error: function(data) {
        }
    });
}

function updateStatusService() {
    var serviceId = $('.serviceId').find(':selected').val();
    var status = $('.status').find(':selected').val();
    var technicianId = $('.technicianId').find(':selected').val();
    var description = $('.description').val();
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            $.ajax({
                url: "/transaction/service/service-form-update-status-save-data",
                data: {id:serviceId,status:status,description:description,technicianId:technicianId},
                type: 'POST',
                success: function(data) {
                    if (data.status == 'success'){
                        swal("Data Telah Tersimpan", {
                            icon: "success",
                        });
                        $('.activities').append(
                            '<div class="activity">'+
                                '<div class="activity-icon bg-primary text-white shadow-primary">'+
                                    '<i class="fas fa-archive"></i>'+
                                '</div>'+
                                '<div class="activity-detail">'+
                                    '<div class="mb-2">'+
                                        '<span class="text-job text-primary">'+moment().format('DD MMMM YYYY')+'</span>'+
                                        '<span class="bullet"></span>'+
                                        '<a class="text-job" href="#" type="button">[ '+status+' ]</a>'+
                                        '</div>'+
                                    '<p>'+description+'</p>'+
                                '</div>'+
                            '</div>'
                        );
                    }
                },
                error: function(data) {
                }
            });
        } else {
            swal("Data Dana Kredit PDL Berhasil Dihapus!");
        }
    });
}