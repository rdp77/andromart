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
        { data: "code" },
        { data: "dataDateOperator" },
        { data: "dataCustomer" },
        { data: "dataItem" },
        { data: "finance" },
        { data: "sharingProfit" },
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

// function del(id) {
//     swal({
//         title: "Apakah Anda Yakin?",
//         text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data pengguna Anda.",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     }).then((willDelete) => {
//         if (willDelete) {
//             $.ajax({
//                 url: "/users/" + id,
//                 type: "DELETE",
//                 success: function () {
//                     swal("Data pengguna berhasil dihapus", {
//                         icon: "success",
//                     });
//                     table.draw();
//                 },
//             });
//         } else {
//             swal("Data pengguna Anda tidak jadi dihapus!");
//         }
//     });
// }

function addItem() {
    var index = $('.priceDetail').length;
    var dataDetail = $('.dataDetail').length;
    $('.dropHereItem').append(
        '<tr class="dataDetail dataDetail_'+(dataDetail+1)+'">'+
            '<td style="display:none">'+
                '<input type="text" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="priceDetailSparePart[]" value="0">'+
                '<input type="text" class="form-control priceDetailLoss priceDetailLoss_'+(index+1)+'" name="priceDetailLoss[]" value="0">'+
            '</td>'+
            '<td>'+
            '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                '<option value="">- Select -</option>'+
                '<option data-index="'+(index+1)+'" data-price="10000" value="Lcd">Lcd</option>'+
                '<option data-index="'+(index+1)+'" data-price="20000" value="Monitor">Monitor</option>'+
            '</select>'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" value="0">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control qtyDetail qtyDetail_'+(index+1)+'" name="qtyDetail[]" data-index="'+(index+1)+'" value="1">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control" name="descriptionDetail[]">'+
            '</td>'+
            '<td>'+
                '<select class="form-control typeDetail typeDetail_'+(index+1)+'" name="typeDetail[]">'+
                    '<option selected data-index="'+(index+1)+'" value="SparePart">SparePart</option>'+
                    '<option data-index="'+(index+1)+'" value="Loss">Loss</option>'+
                '</select>'+
            '</td>'+
            '<td>'+
                '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
            '</td>'+
        '</tr>'
    );
    $('.select2').select2();
    hitung();
}

// mengganti item
$(document.body).on("change",".itemsDetail",function(){
    var index = $(this).find(':selected').data('index');
    var typeDetail = $('.typeDetail_'+index).find(':selected').val();
    var itemPrice = parseInt($(this).find(':selected').data('price'));
    $('.priceDetail_'+index).val(itemPrice);
    $('.totalPriceDetail_'+index).val(itemPrice);
    console.log(typeDetail);
    if(typeDetail == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(itemPrice);
    }else{
        $('.priceDetailLoss_'+index).val(itemPrice);
    }

    hitung();
});

// menghapus kolom
$(document.body).on("click",".removeDataDetail",function(){
    $('.dataDetail_'+this.value).remove();
    hitung();
});

// merubah qty
$(document.body).on("keyup",".qtyDetail",function(){
    var index = $(this).data('index');
    var itemPrice = parseInt($('.priceDetail_'+index).val());
    var itemQty = parseInt(this.value);
    var totalItemPrice = itemPrice*itemQty;
    $('.totalPriceDetail_'+index).val(totalItemPrice);
    hitung();
});

// merubah harga jasa
$(document.body).on("keyup",".priceServiceDetail",function(){
    $('.totalPriceServiceDetail').val(this.value);
    $('#totalService').val(this.value);
    
});

// fungsi hitung
function hitung() {
    var priceDetailSparePart = 0;
    $('.priceDetailSparePart').each(function(){
        priceDetailSparePart += parseFloat(this.value);
    });
    $('#totalSparePart').val(priceDetailSparePart); 

    var priceDetailLoss = 0;
    $('.priceDetailLoss').each(function(){
        priceDetailLoss += parseFloat(this.value);
    });
    $('#totalLoss').val(priceDetailLoss); 
}
       
$(document.body).on("change",".typeDetail",function(){
    var value = this.value;
    var index = $(this).find(':selected').data('index');
    var itemPrice = parseInt($('.priceDetail_'+index).val());
    var itemQty = parseInt($('.qtyDetail_'+index).val());
    var totalItemPrice = itemPrice*itemQty;
    if(value == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(totalItemPrice);
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(totalItemPrice);
        $('.priceDetailSparePart_'+index).val(0);
    }
    hitung();
});
