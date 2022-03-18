"use strict";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#saleId").on("change", function () {
    var idItem = this.value;
    $("#dv").addClass("d-none");
    $("#dp").addClass("d-none");
    $("#customerData").empty();
    $("#itemData").empty();
    $.ajax({
        url: getdata,
        type: "GET",
        data: {
            item_id: idItem,
        },
        dataType: "json",
        success: function (data) {
            $("#saleDate").text(data.result.date);
            $("#total").val(data.result.total);
            $("#operator").val(data.result.operator);
            $("#sale_id").val(data.result.sale);
            $("#item_id_create").val(data.result.item);
            $("#sp_taker").val(data.result.sp_taker);
            $("#sp_seller").val(data.result.sp_seller);
            $("#taker").val(data.result.taker);
            $("#seller").val(data.result.seller);
            $("#customerData").append(data.result.customer);
            $("#itemData").append(data.result.data);
            if (data.result.discount_type == "percent") {
                $("#discount_percent").val(data.result.discount);
                $("#dp").removeClass("d-none");
            } else {
                $("#discount_value").val(data.result.discount);
                $("#dv").removeClass("d-none");
            }
        },
    });
});

function saleId() {
    var dataSale = [];
    $.each($('.saleData'), function () {

    });
}

function addItem() {
    var index = $('.priceDetail').length;
    var dataDetail = $('.dataDetail').length;

    var dataBuyer = [];
    $.each($('.buyerData'), function(){
        dataBuyer += '<option data-index="'+(index+1)+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    });
    var dataItems = [];
    $.each($('.itemsData'), function(){
        if ($(this).data('stock') == null) {
            var stocks = 0;
        }else{
            var stocks = $(this).data('stock');
        }
        dataItems += '<option data-index="'+(index+1)+'" data-supplier="'+$(this).data('supplier')+'" data-price="'+$(this).data('price')+'" data-profit="'+$(this).data('profit')+'" data-stock="'+stocks+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
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
                '</select>' +
                '<input type="text" class="form-control supplier supplier_'+(index+1)+'" name="supplierDetail[]" data-index="'+(index+1)+'" readonly>'+
            '</td>'+
            '<td>' +
                '<input type="text" class="form-control qtyDetail qtyDetail_' + (index + 1) + '" name="qtyDetail[]" data-index="' + (index + 1) + '" value="1" style="text-align: right">' +
                '<input type="text" class="form-control stock stock_'+(index+1)+'" readonly name="stockDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
            '</td>'+
            '<td>' +
                '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
                '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">'+
            '</td>'+
            // '<td>'+
            //     '<select class="select2 buyerDetail" name="buyerDetail[]">'+
            //         '<option value="" data-index="'+(index+1)+'">- Select Buyer -</option>'+
            //         dataBuyer+
            //     '</select>' +
            //     '<input type="text" class="form-control" name="salesDetail[]" value="Sales" readonly>'+
            // '</td>'+
            // '<td>'+
            //     '<input type="number" class="form-control" name="profitSharingBuyer[]" value="0">'+
            //     '<input type="number" class="form-control" name="profitSharingSales[]" value="0">'+
            // '</td>'+
            '<td>'+
                // '<input type="text" class="form-control cleaveNumeral profitDetail profitDetail_'+(index+1)+'" name="profitDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right" hidden>'+
                '<input type="text" class="form-control" name="descriptionDetail[]">' +
            '</td>'+
            '<td>'+
                '<select class="select2 typeDetail typeDetail_'+(index+1)+'" name="typeDetail[]">'+
                    '<option selected data-index="'+(index+1)+'" value="SparePart">Ganti Barang</option>'+
                    '<option data-index="'+(index+1)+'" value="Loss">Barang Loss</option>'+
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

    var checkVerificationDiscount = $('input[name="typeDiscount"]:checked').val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }
}

// mengganti item
$(document.body).on("change", ".itemsDetail", function () {
    var index = $(this).find(':selected').data('index');
    // console.log($(this).val());
    // console.log(index);

    if ($(this).val() == '-') {
        $('.priceDetail_' + index).val(0);
        $('.profitDetail_' + index).val(0);
        $('.supplier_' + index).val(' ');
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
        // $('.profitDetail_' + index).val(parseInt(itemProfit).toLocaleString('en-US'));
        var totalItemPrice = itemPrice * itemQty;
        $('.profitDetail_' + index).val($(this).find(':selected').data('profit'));
        $('.stock_' + index).val($(this).find(':selected').data('stock'));
        $('.supplier_' + index).val($(this).find(':selected').data('supplier'));
        $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        if(typeDetail == 'SparePart'){
            $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
            $('.priceDetailLoss_'+index).val(0);
        }else{
            $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
            $('.priceDetailSparePart_'+index).val(0);
        }
    }
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }

});

// menghapus kolom
$(document.body).on("click",".removeDataDetail",function(){
    $('.dataDetail_'+this.value).remove();
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }
});

$(document.body).on("click",".removeDataDetailExisting",function(){
    $('.dropDeletedExistingData').append('<input type="hidden" class="form-control" value="'+$(this).data('id')+'" name="deletedExistingData[]">');
    $('.dataDetail_'+this.value).remove();
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();
    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }
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
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }
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
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }
});

// fungsi sum
function sum() {
    var priceDetailSparePart = 0;
    $('.priceDetailSparePart').each(function () {
        priceDetailSparePart += parseInt(this.value.replace(/,/g, ""));
    });
    $('#totalSparePart').val(parseInt(priceDetailSparePart).toLocaleString('en-US'));
    var priceDetailLoss = 0;
    $('.priceDetailLoss').each(function(){
        priceDetailLoss += parseInt(this.value.replace(/,/g, ""))
    });
    $('#totalLoss').val(parseInt(priceDetailLoss).toLocaleString('en-US'));
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
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        $('.priceDetailLoss_' + index).val(0);

    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        $('.priceDetailSparePart_'+index).val(0);
    }
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == 'percent') {
        sumDiscont();
    }else{
        sumDiscontValue();
    }
});

function sumDiscont() {
    if(isNaN(parseInt($('#totalSparePart').val()))){
        var totalSparePart =  0;
    }else{
        var totalSparePart = $('#totalSparePart').val().replace(/,/g, ''),asANumber = +totalSparePart;}

    if(isNaN(parseInt($('#totalDiscountPercent').val()))){
        var totalDiscountPercent =  0;
    }else{
        var totalDiscountPercent = $('#totalDiscountPercent').val().replace(/,/g, ''),asANumber = +totalDiscountPercent;}

    if(totalDiscountPercent <= 100){
        var sumTotalPrice = (parseInt(totalDiscountPercent)/100)*(parseInt(totalSparePart));
        $('#totalDiscountValue').val(parseInt(sumTotalPrice).toLocaleString('en-US'));
        $('#totalDiscountPercent').val(totalDiscountPercent);
    }else{
        $('#totalDiscountPercent').val(0);
        $('#totalDiscountValue').val(0);
        var sumTotalPrice = (100/100)*(parseInt(totalSparePart));}
    sumTotal();
}

// function sumDiscontValue() {
//     if(isNaN(parseInt($('#totalSparePart').val()))){
//         var totalSparePart =  0;
//     }else{
//         var totalSparePart = $('#totalSparePart').val().replace(/,/g, ''),asANumber = +totalSparePart;}
//     if(isNaN(parseInt($('#totalService').val()))){
//         var totalService =  0;
//     }else{
//         var totalService = $('#totalService').val().replace(/,/g, ''),asANumber = +totalService;}

//     if(isNaN(parseInt($('#totalDiscountValue').val()))){
//         var totalDiscountValue =  0;
//     }else{
//         var totalDiscountValue = $('#totalDiscountValue').val().replace(/,/g, ''),asANumber = +totalDiscountValue;}
//         var totalValue = parseInt(totalSparePart);

//         if(totalDiscountValue <= totalValue){
//             console.log(totalDiscountValue);
//             console.log(totalValue);
//             var sumTotalPrice = (parseInt(totalDiscountValue)/totalValue)*100;
//         }else{
//             var sumTotalPrice = 100;
//         }
//     if (isNaN(parseInt(sumTotalPrice))) {
//         $('#totalDiscountPercent').val(0);
//     }else{
//         $('#totalDiscountPercent').val(parseFloat(sumTotalPrice).toLocaleString('en-US'));
//     }
//     sumTotal();
// }

function sumTotal() {
    var item_price_old = $('#item_price_old').val();;
    var item_price = 0;
    var totalPriceDetail = 0;

    $('.totalPriceDetail').each(function(){
        totalPriceDetail += parseInt(this.value.replace(/,/g, ""))
    });
    $('#item_price').val(parseInt(totalPriceDetail).toLocaleString('en-US'));

    var total = item_price_old - totalPriceDetail;
    $('#total').val(parseInt(total).toLocaleString('en-US'));
    // $('#total').val(-200);
}

// function add() {
//     var idItem = $("#item").find(":selected").val();
//     var dataParent = $(".dataParent").length;
//     $.ajax({
//         url: addURL,
//         type: "GET",
//         data: {
//             sale: idItem,
//         },
//         dataType: "json",
//         success: function (data) {
//             var dataItems = [];
//             $.each(data.result, function (index, value) {
//                 dataItems +=
//                     '<option value="' +
//                     value.id_item +
//                     '">' +
//                     value.name_item +
//                     "</option>";
//             });
//             $("#itemData").append(
//                 '<tr class="dataParent remove_' +
//                     (dataParent + 1) +
//                     '">' +
//                     '<td> <select class="form-control selectric" name="items[]" id="item_data">' +
//                     '<option value="">- Select -</option>' +
//                     dataItems +
//                     '</select> </td><td> <select class="form-control selectric" name="type[]"> <option value="">- Select -</option>' +
//                     '<option value="1">Service Barang</option><option value="2">Ganti Baru</option><option value="3">Tukar Tambah</option>' +
//                     '<option value="4">Ganti Uang</option><option value="5">Ganti Barang Lain</option></select> </td>' +
//                     '<td> <button type="button" onclick="remove_item(\'' +
//                     (dataParent + 1) +
//                     '\')" class="btn btn-danger mt-2 mt-1 btn-block"> <i class="fa fa-times"></i> </button>' +
//                     '<button type="button" onclick="dataModal()" class="btn btn-primary mt-1 mb-2 btn-block"> <i class="fa fa-eye"></i> </button> </td></tr>'
//             );
//             $(".selectric").selectric();
//         },
//     });
// }

// function remove_item(argument) {
//     $(".remove_" + argument).remove();
// }

function dataModal() {
    var sale = $("#item").find(":selected").val();
    var idItem = $("#item_data").find(":selected").val();
    $.ajax({
        url: getDetailURL,
        type: "GET",
        data: {
            sale: sale,
            item_id: idItem,
        },
        dataType: "json",
        success: function (data) {
            $("#total_price").text(data.result.total);
            $("#taker").text(data.result.taker);
            $("#seller").text(data.result.seller);
            $("#sp_taker").text(data.result.sp_taker);
            $("#sp_seller").text(data.result.sp_seller);
            $("#desc").text(data.result.desc);
            $("#qty").text(data.result.qty);
            $("#exampleModal").modal("show");
        },
    });
}

function save() {
    var form = $("#stored");
    var formdata = new FormData(form[0]);
    $.ajax({
        url: url,
        data: formdata ? formdata : form.serialize(),
        type: "POST",
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status == "success") {
                swal(data.data, {
                    icon: "success",
                }).then(function () {
                    window.location = index;
                });
            } else if (data.status == "error") {
                for (var number in data.data) {
                    iziToast.error({
                        title: "Error",
                        message: data.data[number],
                    });
                }
            } else if (data.status == "service") {
                $("#exampleModal").modal("show");
            }
        },
    });
}

function itemIdChange() {
    var value = $('.saleId').val();
    var dataBarang = [];
    $('.barang').empty();
    $.each($('.barangDataHidden'), function(){
        if ($(this).data('id') == value) {
            dataBarang += '<option value="'+$(this).data('value')+'">'+$(this).data('item') +' - '+ $(this).data('brand')+'</option>';
        }else {

        }
    });
    
    $('.barang').append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $('.barang').append(dataBarang);
    // }
    // alert($('.PaymentMethod').val());
}
function barangChange() {
    var valueBarang = $('.barang').val();
    $.each($('.barangDataHidden'), function(){
        if ($(this).data('value') == valueBarang) {
            $('#item_price_old').val($(this).data('old'));
            $('#qty').val($(this).data('qty'));
        }
    });
}

function returnType() {
    var form = $("#return");
    $("#sale").val($("#sale_id").val());
    $("#item_id").val($("#item_id_create").val());
    var formdata = new FormData(form[0]);
    $.ajax({
        url: returnURL,
        data: formdata ? formdata : form.serialize(),
        type: "POST",
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status == "loss") {
                swal(data.data, {
                    icon: "info",
                }).then(function () {
                    window.location = service;
                });
            } else if (data.status == "new") {
                swal(data.data, {
                    icon: "info",
                }).then(function () {
                    window.location = index;
                });
            } else if (data.status == "money") {
                swal(data.data, {
                    icon: "info",
                }).then(function () {
                    window.location = index;
                });
            } else if (data.status == "att") {
                swal(data.data, {
                    icon: "info",
                }).then(function () {
                    window.location = buy;
                });
            } else if (data.status == "error") {
                for (var number in data.data) {
                    iziToast.error({
                        title: "Error",
                        message: data.data[number],
                    });
                }
            } else if (data.status == "success") {
                swal(data.data, {
                    icon: "success",
                }).then(function () {
                    window.location = index;
                });
            }
        },
    });
}
