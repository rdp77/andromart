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
                        swal("Data Pengajuan Pinjaman Disimpan", {
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

function addItem() {
    var index = $('.priceDetail').length;
    var dataDetail = $('.dataDetail').length;

    var dataItems = [];
    $.each($('.itemsData'), function(){
        dataItems += '<option data-index="'+(index+1)+'" data-price="'+$(this).data('price')+'" data-stock="'+$(this).data('supplier')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    });

    $('.dropHereItem').append(
        '<tr class="dataDetail dataDetail_'+(dataDetail+1)+'">'+
            '<td style="display:none">'+
                '<input type="text" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="priceDetailSparePart[]" value="0">'+
                '<input type="text" class="form-control priceDetailLoss priceDetailLoss_'+(index+1)+'" name="priceDetailLoss[]" value="0">'+
            '</td>'+
            '<td>'+
            '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                '<option value="">- Select -</option>'+
                dataItems+
            '</select>'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control qtyDetail qtyDetail_'+(index+1)+'" name="qtyDetail[]" data-index="'+(index+1)+'" value="1" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control stock stock_'+(index+1)+'" name="" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control" name="descriptionDetail[]">'+
            '</td>'+
            // '<td>'+
            //     '<select class="form-control typeDetail typeDetail_'+(index+1)+'" name="typeDetail[]">'+
            //         '<option selected data-index="'+(index+1)+'" value="SparePart">SparePart</option>'+
            //         '<option data-index="'+(index+1)+'" value="Loss">Loss</option>'+
            //     '</select>'+
            // '</td>'+
            '<td>'+
                '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
            '</td>'+
        '</tr>'
    );
    $('.select2').select2();
    $(".cleaveNumeral")
    .toArray()
    .forEach(function (field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand",
        });
    });
    sum();
    sumTotal();
    sumDiscont();
}

// mengganti item
$(document.body).on("change",".itemsDetail",function(){
    var index = $(this).find(':selected').data('index');
    var typeDetail = $('.typeDetail_'+index).find(':selected').val();
    if(isNaN(parseInt($(this).find(':selected').data('price')))){
        var itemPrice =  0; }else{
        var itemPrice = $(this).find(':selected').data('price');}
    if(isNaN(parseInt($('.qtyDetail_'+index).val()))){
        var itemQty =  0; }else{
        var itemQty = $('.qtyDetail_'+index).val().replace(/,/g, ''),asANumber = +itemQty;}
    $('.priceDetail_'+index).val(parseInt(itemPrice).toLocaleString());
    var totalItemPrice = itemPrice*itemQty;
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString());
    if(typeDetail == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailSparePart_'+index).val(0);
    }
    sum();
    sumTotal();
    sumDiscont();
});

// menghapus kolom
$(document.body).on("click",".removeDataDetail",function(){
    $('.dataDetail_'+this.value).remove();
    sum();
    sumTotal();
    sumDiscont();
});

// merubah qty
$(document.body).on("keyup",".qtyDetail",function(){
    var index = $(this).data('index');
    var typeDetail = $('.typeDetail_'+index).find(':selected').val();
    if(isNaN(parseInt($('.priceDetail_'+index).val()))){
        var itemPrice =  0; }else{
        var itemPrice = $('.priceDetail_'+index).val().replace(/,/g, ''),asANumber = +itemPrice;}
    if(isNaN(parseInt(this.value))){
        var itemQty =  0; }else{
        var itemQty = this.value.replace(/,/g, ''),asANumber = +itemQty;}
    var totalItemPrice = itemPrice*itemQty;
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString());
    if(typeDetail == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailSparePart_'+index).val(0);
    }
    sum();
    sumTotal();
    sumDiscont();
});

// merubah harga
$(document.body).on("keyup",".priceDetail",function(){
    var index = $(this).data('index');
    var typeDetail = $('.typeDetail_'+index).find(':selected').val();
    if(isNaN(parseInt(this.value))){
        var itemPrice =  0; }else{
        var itemPrice = this.value.replace(/,/g, ''),asANumber = +itemPrice;}
    if(isNaN(parseInt($('.qtyDetail_'+index).val()))){
        var itemQty =  0; }else{
        var itemQty = $('.qtyDetail_'+index).val().replace(/,/g, ''),asANumber = +itemQty;}
    var totalItemPrice = itemPrice*itemQty;
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString());
    if(typeDetail == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailSparePart_'+index).val(0);
    }
    sum();
    sumTotal();
    sumDiscont();
});

// merubah harga jasa
$(document.body).on("keyup",".priceServiceDetail",function(){
    $('.totalPriceServiceDetail').val(this.value);
    $('#totalService').val(this.value);
    sumTotal();
    sumDiscont();
});

// fungsi sum
function sum() {
    var priceDetailSparePart = 0;
    $('.priceDetailSparePart').each(function(){
        priceDetailSparePart += parseInt(this.value.replace(/,/g, ""));
    });
    $('#totalSparePart').val(parseInt(priceDetailSparePart).toLocaleString());
    var priceDetailLoss = 0;
    $('.priceDetailLoss').each(function(){
        priceDetailLoss += parseInt(this.value.replace(/,/g, ""))
    });
    $('#totalLoss').val(parseInt(priceDetailLoss).toLocaleString());
}

// fungsi rubah tipe
$(document.body).on("change",".typeDetail",function(){
    var value = this.value;
    var index = $(this).find(':selected').data('index');
    if(isNaN(parseInt($('.priceDetail_'+index).val()))){
        var itemPrice =  0; }else{
        var itemPrice = $('.priceDetail_'+index).val().replace(/,/g, ''),asANumber = +itemPrice;}
    if(isNaN(parseInt($('.qtyDetail_'+index).val()))){
        var itemQty =  0; }else{
        var itemQty = $('.qtyDetail_'+index).val().replace(/,/g, ''),asANumber = +itemQty;}
    var totalItemPrice = itemPrice*itemQty;
    if(value == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString());
        $('.priceDetailSparePart_'+index).val(0);
    }
    sum();
    sumTotal();
    sumDiscont();
});

function sumDiscont() {
    if(isNaN(parseInt($('#totalSparePart').val()))){
        var totalSparePart =  0;
    }else{
        var totalSparePart = $('#totalSparePart').val().replace(/,/g, ''),asANumber = +totalSparePart;}
    if(isNaN(parseInt($('#totalService').val()))){
        var totalService =  0;
    }else{
        var totalService = $('#totalService').val().replace(/,/g, ''),asANumber = +totalService;}
    if(isNaN(parseInt($('#totalDownPayment').val()))){
        var totalDownPayment =  0;
    }else{
        var totalDownPayment = $('#totalDownPayment').val().replace(/,/g, ''),asANumber = +totalDownPayment;}
    if(isNaN(parseInt($('#totalDiscountPercent').val()))){
        var totalDiscountPercent =  0;
    }else{
        var totalDiscountPercent = $('#totalDiscountPercent').val().replace(/,/g, ''),asANumber = +totalDiscountPercent;}
    if(totalDiscountPercent <= 100){
        var sumTotalPrice = (parseInt(totalDiscountPercent)/100)*(parseInt(totalService)+parseInt(totalSparePart)-parseInt(totalDownPayment));
    }else{
        var sumTotalPrice = (100/100)*(parseInt(totalService)+parseInt(totalSparePart)-parseInt(totalDownPayment));}
    $('#totalDiscountValue').val(parseInt(sumTotalPrice).toLocaleString());
    sumTotal();
}

function sumTotal() {
    var checkVerificationPrice =  $('input[name="verificationPrice"]:checked').val();
    if(isNaN(parseInt($('#totalSparePart').val()))){
        var totalSparePart =  0;
    }else{
        var totalSparePart = $('#totalSparePart').val().replace(/,/g, ''),asANumber = +totalSparePart;}
    if(isNaN(parseInt($('#totalService').val()))){
        var totalService =  0;
    }else{
        var totalService = $('#totalService').val().replace(/,/g, ''),asANumber = +totalService;}
    if(isNaN(parseInt($('#totalDownPayment').val()))){
        var totalDownPayment =  0;
    }else{
        var totalDownPayment = $('#totalDownPayment').val().replace(/,/g, ''),asANumber = +totalDownPayment;}
    if(isNaN(parseInt($('#totalDiscountValue').val()))){
        var totalDiscountValue =  0;
    }else{
        var totalDiscountValue = $('#totalDiscountValue').val().replace(/,/g, ''),asANumber = +totalDiscountValue;}
    if(checkVerificationPrice == 'Y'){
        var sumTotal = 0;
    }else{
        var sumTotal = parseInt(totalService)+parseInt(totalSparePart)-parseInt(totalDownPayment)-parseInt(totalDiscountValue);}
    $('#totalPrice').val(parseInt(sumTotal).toLocaleString());
}



// fungsi update status
function choseService() {
    var serviceId = $('.serviceId').find(':selected').val();
    $('.activities').empty();
    $.ajax({
        url: "/transaction/service/service-form-update-status-load-data",
        data: {id:serviceId},
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
                    $.each(data.result.service_status_mutation, function(index,value){
                        $('.activities').append(
                            '<div class="activity">'+
                                '<div class="activity-icon bg-primary text-white shadow-primary">'+
                                    '<i class="fas fa-archive"></i>'+
                                '</div>'+
                                '<div class="activity-detail">'+
                                    '<div class="mb-2">'+
                                        '<span class="text-job text-primary">'+moment(value.created_at).format('DD MMMM YYYY')+'</span>'+
                                        '<span class="bullet"></span>'+
                                        '<a class="text-job" href="#" type="button">[ '+value.status+' ]</a>'+
                                        '</div>'+
                                    '<p>'+value.description+'</p>'+
                                '</div>'+
                            '</div>'
                        );
                    });
                }
            }
        },
        error: function(data) {
        }
    });
}
function changeStatusService() {

    var value = $('.status').find(':selected').val();
    if(value == 'Mutasi'){
        $('.technicianFields').css('display','block');
    }else{
        $('.technicianFields').css('display','none');
    }
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
