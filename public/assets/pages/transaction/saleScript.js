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
                url: "/transaction/sale/sale",
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
        dataItems += '<option data-index="'+(index+1)+'" data-price="'+$(this).data('price')+'" data-stock="'+$(this).data('stock')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    });

    $('.dropHereItem').append(
        '<tr class="dataDetail dataDetail_'+(dataDetail+1)+'">'+
            '<td style="display:none">'+
                '<input type="text" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="priceDetailSparePart[]" value="0">'+
                '<input type="text" class="form-control priceDetailLoss priceDetailLoss_'+(index+1)+'" name="priceDetailLoss[]" value="0">'+
            '</td>'+
            '<td>'+
            '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
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
                '<input type="text" class="form-control stock stock_'+(index+1)+'" readonly name="stockDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control" name="descriptionDetail[]">'+
            '</td>'+
            '<td hidden>'+
                '<select class="form-control typeDetail typeDetail_'+(index+1)+'" name="typeDetail[]">'+
                    '<option selected data-index="'+(index+1)+'" value="SparePart">Barang</option>'+
                    // '<option data-index="'+(index+1)+'" value="Loss">Loss</option>'+
                '</select>'+
            '</td>'+
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
$(document.body).on("change", ".itemsDetail", function () {
    var index = $(this).find(':selected').data('index');
    console.log($(this).val());
    console.log(index);

    if ($(this).val() == '-') {
        $('.priceDetail_' + index).val(0);
        $('.stock_' + index).val(0);
        $('.qtyDetail_' + index).val(0);
        $('.totalPriceDetail_' + index).val(0);
    }else{
        var typeDetail = $('.typeDetail_' + index).find(':selected').val();
        if (isNaN(parseInt($(this).find(':selected').data('price')))) {
            var itemPrice = 0;
        } else {
            var itemPrice = $(this).find(':selected').data('price');
        }
        if (isNaN(parseInt($('.qtyDetail_' + index).val()))) {
            var itemQty = 0;
        } else {
            var itemQty = $('.qtyDetail_' + index).val().replace(/,/g, ''), asANumber = +itemQty;
        }
        $('.priceDetail_' + index).val(parseInt(itemPrice).toLocaleString('en-US'));
        var totalItemPrice = itemPrice * itemQty;
        $('.stock_' + index).val($(this).find(':selected').data('stock'));
        $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        if(typeDetail == 'SparePart'){
            $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
            $('.priceDetailLoss_'+index).val(0);
        }else{
            $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
            $('.priceDetailSparePart_'+index).val(0);
        }
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
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));

    if (typeDetail == 'SparePart') {
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
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

    if (isNaN(parseInt(this.value))) {
        var itemPrice =  0; }else{
        var itemPrice = this.value.replace(/,/g, ''),asANumber = +itemPrice;}
    if(isNaN(parseInt($('.qtyDetail_'+index).val()))){
        var itemQty =  0; }else{
        var itemQty = $('.qtyDetail_'+index).val().replace(/,/g, ''),asANumber = +itemQty;}
    var totalItemPrice = itemPrice*itemQty;
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
    if(typeDetail == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
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
    $('#totalSparePart').val(parseInt(priceDetailSparePart).toLocaleString('en-US'));
    var priceDetailLoss = 0;
    $('.priceDetailLoss').each(function(){
        priceDetailLoss += parseInt(this.value.replace(/,/g, ""))
    });
    $('#totalLoss').val(parseInt(priceDetailLoss).toLocaleString('en-US'));
}

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
    $('#totalDiscountValue').val(parseInt(sumTotalPrice).toLocaleString('en-US'));
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
    $('#totalPrice').val(parseInt(sumTotal).toLocaleString('en-US'));
}
