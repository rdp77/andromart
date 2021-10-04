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
        url: "/transaction/service/service-payment",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "created_by" },
        { data: "informationService" },
        { data: "dateData" },
        { data: "currentStatus" },
        { data: "description" },
        { data: "totalValue" },
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
function alertNotification(params) {
    return iziToast.warning({
        title: 'Peringatan',
        message: params,
        position: 'topRight',
    });
}
function save() {
    // alert('asd');
    var totalPrice = $('#totalPrice').val().replace(/,/g, ''),asANumber = +totalPrice;
    var totalPayment = $('#totalPayment').val().replace(/,/g, ''),asANumber = +totalPayment;
    var totalPriceHidden = $('#totalPriceHidden').val();
    var type = $('.type').val();
    var checkDp = $('#checkDpData').val();

    if (parseInt(totalPayment) > parseInt(totalPriceHidden)) {
        return alertNotification('Pembayaran Lebih Dari Sisa Pembayaran');
    }
    if ((checkDp != 0) && (type == 'DownPayment')) {
        return alertNotification('Sudah Pernah DP. Harus Pilih Pembayaran Lunas');
    }
    if ((checkDp != 0) && (type == 'Lunas') && (parseInt(totalPrice) != 0)) {
        return alertNotification('Sudah Pernah DP. Tidak Boleh ada sisa di total');
    }
    if (type == 'DownPayment') {
        if (parseInt(totalPrice) == 0) {
          return alertNotification('Pembayaran Tidak Boleh 0 karena Pembayaran DP');
        }
    }else{
        if (parseInt(totalPrice) != 0) {
          return alertNotification('Total Bayar Tidak Boleh sisa karena Pemabayaran Lunas');
        }
    }

    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            var validation = 0;
            console.log(validation);
            $('.validation').each(function(){
                if ($(this).val() == '' || $(this).val() == null || $(this).val() == 0) {
                    validation++;
                    // alert($(this).data('name'));
                    iziToast.warning({
                        type: 'warning',
                        title: $(this).data('name'),
                    });
                }else{
                    validation-1;
                }
            });
            if (validation != 0) {
                return false;
            }
            $.ajax({
                url: "/transaction/service/service-payment",
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

function sumTotal() {
    if(isNaN(parseInt($('#totalSparePart').val()))){
        var totalSparePart =  0;
    }else{
        var totalSparePart = $('#totalSparePart').val().replace(/,/g, ''),asANumber = +totalSparePart;}

    if(isNaN(parseInt($('#totalService').val()))){
        var totalService =  0;
    }else{
        var totalService = $('#totalService').val().replace(/,/g, ''),asANumber = +totalService;}

    if(isNaN(parseInt($('#totalPayment').val()))){
        var totalPayment =  0;
    }else{
        var totalPayment = $('#totalPayment').val().replace(/,/g, ''),asANumber = +totalPayment;}

    if(isNaN(parseInt($('#totalDiscountValue').val()))){
        var totalDiscountValue =  0;
    }else{
        var totalDiscountValue = $('#totalDiscountValue').val().replace(/,/g, ''),asANumber = +totalDiscountValue;}
        
    var sumTotal = parseInt(totalService)+parseInt(totalSparePart)-parseInt(totalDiscountValue)-parseInt(totalPayment);

    if (sumTotal < 0) {
        $('#totalPrice').val(parseInt(0).toLocaleString('en-US'));
    }else{
        $('#totalPrice').val(parseInt(sumTotal).toLocaleString('en-US'));
    }
}



// fungsi update status
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

function paymentMethodChange() {
    var branch = $('.branchId').val();
    var value = $('.PaymentMethod').val();
    var dataItems = [];
    $('.account').empty();
    $.each($('.accountDataHidden'), function(){
        if (value == 'Cash') {
            if ($(this).data('mainname') == 'Kas' && branch == $(this).data('branch')) {
                dataItems += '<option value="'+this.value+'">'+$(this).data('code') +' - '+ $(this).data('name')+'</option>';
            }
        }
    });
    
    $('.account').append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $('.account').append(dataItems);
    // }
    // alert($('.PaymentMethod').val());
}
function jurnal(params) {
    $('.dropHereJournals').empty();
    // $('.dropHereJournals').
    $.ajax({
        url: "/transaction/service/check-journals",
        data: {id:params},
        type: 'POST',
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