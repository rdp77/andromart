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
        { data: "informationService" },
        { data: "dateData" },
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
                    if(data.status == 'success'){
                        swal("Data pengguna berhasil dihapus", {
                            icon: "success",
                        });
                        table.draw();
                    }else if(data.status == 'restricted'){
                        swal(data.message, {
                            icon: "warning",
                        });
                    }else{
                        swal('DATA EROR HUBUNGI DEVELOPER', {
                            icon: "error",
                        });
                    }
                },
            });
        } else {
            swal("Data master Anda tidak jadi dihapus!");
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

    if(isNaN(parseInt($('#totalDownPayment').val()))){
        var totalDownPayment =  0;
    }else{
        var totalDownPayment = $('#totalDownPayment').val().replace(/,/g, ''),asANumber = +totalDownPayment;}
        
    var sumTotal = parseInt(totalService)+parseInt(totalSparePart)-parseInt(totalDiscountValue);

    if (sumTotal < 0) {
        $('#totalPrice').val(parseInt(0).toLocaleString('en-US'));
    }else{
        $('#totalPrice').val(parseInt(sumTotal).toLocaleString('en-US'));
    }
}

function choseService() {
    var serviceId = $('.serviceId').find(':selected').val();
    $('.dropHereItem').empty();
    $('.dropHereDataService').empty();
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
                    $('#totalPayment').val(0);
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
                    $('#totalPayment').val(parseInt(data.result.total_downpayment+data.result.total_payment).toLocaleString('en-US'));
                    if (data.result.downpayment_date != null){
                        $('.DownPaymentHidden').css('display','block');
                    }else{
                        $('.DownPaymentHidden').css('display','none');
                    }

                    $.each(data.result.service_detail, function(index,value){
                        if (value.type == 'SparePart' || value.type == 'Jasa') {
                            if (value.type == 'Jasa') {
                                var SparePart = '<select class="form-control" name="perlakuan[]" readonly>'+
                                    '<option selected value="-">-</option>'+
                                '</select>';
                            }else{
                                var SparePart = '<select class="form-control" name="perlakuan[]">'+
                                    '<option selected value="Masuk Stock">Masuk Stock</option>'+
                                    '<option value="Loss">Loss</option>'+
                                '</select>';

                            }
                            $('.dropHereItem').append(
                                '<tr class="dataDetail">'+
                                    '<td>'+
                                        '<input type="hidden" class="itemsDetail" name="itemsDetail[]" value="'+value.items.id+'">'+value.items.name+
                                    '</td>'+
                                    '<td>'+
                                        '<input type="hidden" class="form-control cleaveNumeral priceDetail" name="priceDetail[]" value="'+value.price+'" style="text-align: right">'+parseInt(value.price).toLocaleString('en-US')+
                                    '</td>'+
                                    '<td>'+
                                        '<input type="hidden" class="form-control qtyDetail" name="qtyDetail[]" value="'+value.qty+'" style="text-align: right">'+parseInt(value.qty).toLocaleString('en-US')+
                                    '</td>'+
                                    '<td>'+
                                        '<input readonly type="hidden" class="form-control totalPriceDetail" name="totalPriceDetail[]" value="'+value.total_price+'" style="text-align: right">'+parseInt(value.total_price).toLocaleString('en-US')+
                                    '</td>'+
                                    '<td>'+
                                        '<input type="hidden" class="form-control" name="descriptionDetail[]" value="'+value.description+'">'+value.description+
                                    '</td>'+
                                    '<td>'+
                                        '<input type="hidden" class="form-control" name="typeDetail[]" value="'+value.type+'">'+value.type+
                                    '</td>'+
                                    '<td>'+
                                        SparePart+
                                    '</td>'+
                                '</tr>'
                            );
                        }
                    });

                    if (serviceId != '') {
                        $('.dropHereDataService').append(
                            '<div class="row">'+
                                '<div class="form-group col-12 col-md-6 col-lg-6">'+
                                    '<label for="date">Nama Customer</label>'+
                                    '<p>'+$('.serviceId').find(':selected').data('customername')+'</p>'+
                                '</div>'+
                                '<div class="form-group col-12 col-md-6 col-lg-6">'+
                                    '<label for="type">Alamat & No Tlp Customer</label>'+
                                    '<p>'+$('.serviceId').find(':selected').data('customeradress')+' [ '+$('.serviceId').find(':selected').data('customerphone')+' ] </p>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="form-group col-12 col-md-6 col-lg-6">'+
                                    '<label for="date">Barang Yang Di Service</label>'+
                                    '<p>'+$('.serviceId').find(':selected').data('brand')+' '+$('.serviceId').find(':selected').data('type')+' </p>'+
                                '</div>'+
                                '<div class="form-group col-12 col-md-6 col-lg-6">'+
                                    '<label for="type">Teknisi</label>'+
                                    '<p>'+$('.serviceId').find(':selected').data('technician')+'</p>'+
                                '</div>'+
                            '</div>'
                        );
                    }
                    
                sumTotal();

            }
            }
        },
        error: function(data) {
        }
    });
}

function save() {
    var status = $('.type').find(':selected').val();
    var phone = $('.serviceId').find(':selected').data('phone');
    console.log(phone);
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            // var validation = 0;
            // console.log(validation);
            // $('.validation').each(function(){
            //     if ($(this).val() == '' || $(this).val() == null || $(this).val() == 0) {
            //         validation++;
            //         // alert($(this).data('name'));
            //         iziToast.warning({
            //             type: 'warning',
            //             title: $(this).data('name'),
            //         });
            //     }else{
            //         validation-1;
            //     }
            // });
            // if (validation != 0) {
            //     return false;
            // }
            $.ajax({
                url: "/transaction/service-return/service-return",
                data: $(".form-data").serialize(),
                type: 'POST',
                success: function(data) {
                    if(data.status == 'success'){
                        swal(data.message, {
                            icon: "success",
                        });
                        if (status == 'Cancel') {
                            swal({
                                title: "Apakah Anda Ingin Mengkonfirmasi WA Customer ?",
                                text: "Aksi ini membuat anda akan berpindah halaman.",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            }).then((red) => {
                                if (red) {
                                    let str = phone;
 
                                    str = str.substr(1);
                                    // console.log(str);

                                    // window.open("https://wa.me/62"+str+"?text=Barang%20yang%20anda%20service%20telah%20SELESAI%0A");
                                    window.open("https://api.whatsapp.com/send?phone=62"+str+"&text=Hallo%2C%20Sobat%20Andromart%0D%0AKami%20informasikan%20ke%20Teknisi%20kami%20untuk%20merakit%20unitnya%20kembali%0D%0ATidak%20dikenakan%20biaya%20kak%2C%20Bisa%20diambil%20di%20Counter%20kami%20Paling%20lama%201%20Hari%20Kerja%20sejak%20Konfirmasi%20Cancel%0D%0ATerimakasih%20%3B%29");
                                    
                                }
                            });
                        }
                        location.reload;
                    }else{
                        console.log(data);
                        swal(data.message, {
                            icon: "warning",
                        });
                    }
                },
                error: function(data) {
                    // edit(id);
                }
            });

        } else {
            swal("Data Tidak Jadi Dihapus!");
        }
    });


}
// function dropValueCost() {
//     var costValue = $('.costValue').find(':selected').data('cost');
//     // alert(costValue);
//     $('#rupiah').val(parseInt(costValue).toLocaleString('en-US'));
// }


