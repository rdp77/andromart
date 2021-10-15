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
        url: "/transaction/service-return/service-return",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "description" },
        { data: "description" },
        { data: "description" },
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


function choseService() {
    var serviceId = $('.serviceId').find(':selected').val();
    $('.dropHereItem').empty();
    $.ajax({
        url: "/transaction/service/service-form-update-status-load-data",
        data: {id:serviceId},
        type: 'POST',
        success: function(data) {
            if (data.status == 'success'){
                if(data.message == 'empty'){
                    $('.DownPaymentHidden').css('display','none');
                    $('#totalService').val(0);
                    $('#totalSparePart').val(0);
                    $('#totalPriceHidden').val(0);
                    $('#totalDiscountPercent').val(0);
                    $('#totalDiscountValue').val(0);
                    $('#checkDpData').val('');
                    $('.dropHereItem').empty();
                }else{
                    $('#totalService').val(parseInt(data.result.total_service).toLocaleString('en-US'));
                    $('#totalSparePart').val(parseInt(data.result.total_part).toLocaleString('en-US'));
                    $('#totalDownPayment').val(parseInt(data.result.total_downpayment).toLocaleString('en-US'));
                    $('#totalDiscountPercent').val(parseFloat(data.result.discount_percent).toLocaleString('en-US'));
                    $('#totalDiscountValue').val(parseInt(data.result.discount_price).toLocaleString('en-US'));
                    $('#totalPriceHidden').val(data.result.total_service+data.result.total_part);
                    $('#checkDpData').val(data.result.total_downpayment);
                    if (data.result.downpayment_date != null){
                        $('.DownPaymentHidden').css('display','block');
                    }else{
                        $('.DownPaymentHidden').css('display','none');
                    }

                    

                    $.each(data.result.service_detail, function(index,value){
                        $('.dropHereItem').append(
                                '<tr>'+
                                    '<td>'+value.items.name+'</td>'+
                                    '<td>'+parseInt(value.price).toLocaleString('en-US')+'</td>'+
                                    '<td>'+parseInt(value.qty).toLocaleString('en-US')+'</td>'+
                                    '<td>'+parseInt(value.total_price).toLocaleString('en-US')+'</td>'+
                                    '<td>'+value.description+'</td>'+
                                    '<td>'+value.type+'</td>'+
                                '</tr>'
                            );
                        });
                    }
                sumTotal();

            }
        },
        error: function(data) {
        }
    });
}
// function dropValueCost() {
//     var costValue = $('.costValue').find(':selected').data('cost');
//     // alert(costValue);
//     $('#rupiah').val(parseInt(costValue).toLocaleString('en-US'));
// }


