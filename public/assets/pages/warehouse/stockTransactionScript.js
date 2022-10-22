"use strict";
var typeIndex = $('.typeIndex').val();
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
        url: "/warehouse/stock-transaction/stockTransaction",
        type: "GET",
    },
    order: [[1, "desc"]],
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "date" },
        { data: "branchCheck" },
        { data: "item.name" },
        { data: "qty" },
        { data: "item.stock[0].unit.name" },
        { data: "typeInOut" },
        { data: "reason" },
        { data: "description" },
        { data: "action", orderable: false, searchable: true },
    ],
    'columnDefs': [
    {
        "targets": 0, // First Column
        "className": "text-center",
        "width": "10%"
    },
    {
        "targets": [ 1, 2, 3, 4, 5, 6, 7 ],
        "className": "text-center",
    }

    ],
    // columnDefs: [ {
    //     targets: 2,
    //     render: $.fn.dataTable.render.moment( 'MM/DD/YYYY' )
    // }],
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
        text: "Aksi ini tidak dapat dikembalikan Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/warehouse/stock-transaction/stockTransaction/" + id,
                type: "DELETE",
                success: function (data) {
                    if(data.status == 'success'){
                        swal(data.message, {
                            icon: "success",
                        });
                        table.draw();
                    }else{
                        swal(data.message, {
                            icon: "error",
                        });
                    }
                    
                },
            });
        } else {
            swal("Data tidak jadi dihapus!");
        }
    });
}
function save(argument) {
    console.log($('.stockSaatIni').val());
    console.log($('.qty').val());
    console.log($('.checkType').find(':selected').val());
    if ($('.stockSaatIni').val() == 0 && $('.checkType').find(':selected').val() != 'In') {
        iziToast.warning({
            type: 'warning',
            title: 'Stock 0 tidak dapat di keluarkan / Mutasi'
        });
        return '';
    }
    if ($('.stockSaatIni').val() < $('.qty').val() && $('.checkType').find(':selected').val() != 'In') {
        iziToast.warning({
            type: 'warning',
            title: 'Qty tidak boleh lebih dari Stock Saat Ini'
        });
        return '';
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
            $('.validation').each(function(){
                if ($(this).val() == '' || $(this).val() == null || $(this).val() == 0) {
                    validation++;
                    iziToast.warning({
                        type: 'warning',
                        title: $(this).data('name') +' Harus Di isi'
                    });
                }else{
                    validation-1;
                }
            });
            if (validation != 0) {
                return false;
            }
            $.ajax({
                url: "/warehouse/stock-transaction/stockTransaction",
                data: $(".form-data").serialize(),
                type: 'POST',
                success: function(data) {
                    if(data.status == 'success'){
                        swal("Data Berhasil Disimpan", {
                            icon: "success",
                        });
                        location.reload();
                    }else{
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
            swal("Dibatalkan!");
        }
    });

}

function category() {
    var dataItems = [];
    $('.brand').empty();

    var params = $('.type').find(':selected').val();
    $.each($('.brandData'), function(){
        if (params == $(this).data('category')) {
            dataItems += '<option value="'+this.value+'">'+$(this).data('name')+'</option>';
        }
    });
    $('.brand').append('<option value="">- Select -</option>');
    $('.brand').append(dataItems);
    // Reset Series
    $('.item').empty();
    $('.item').append('<option value="">- Select -</option>');
}

$(document.body).on("change",".brand",function(){
    var dataItems = [];
    $('.item').empty();
    var params = $('.brand').find(':selected').val();
    $.each($('.itemData'), function(){
        if (params == $(this).data('brand')) {
            dataItems += '<option value="'+this.value+'">'+$(this).data('supplier')+' - '+$(this).data('name')+'</option>';
        }
    });
    $('.item').append('<option value="">- Select -</option>');
    $('.item').append(dataItems);
});

$(document.body).on("change",".type",function(){
    if (this.value == 'In') {
        $('.hiddenReason').css('display','block');
        $('.hiddenBranch').css('display','none');
        $('.reason').empty();
        $('.reason').append('<option value="">- Select -</option>');
        $('.reason').append('<option value="Penambahan">Penambahan Stock</option>');
    }else if(this.value == 'Out'){
        $('.hiddenReason').css('display','block');
        $('.hiddenBranch').css('display','none');
        $('.reason').empty();
        $('.reason').append('<option value="">- Select -</option>');
        $('.reason').append('<option value="Rusak">Barang Rusak</option>');
        $('.reason').append('<option value="Hilang">Barang Hilang</option>');
        $('.reason').append('<option value="Salah Input">Salah Input</option>');
    }else if(this.value == 'Mutation'){
        $('.hiddenReason').css('display','none');
        $('.hiddenBranch').css('display','flex');
        $('.reason').empty();
    }else{
        $('.hiddenReason').css('display','none');
        $('.hiddenBranch').css('display','none');
        $('.reason').empty();
        $('.reason').append('<option value="">- Select -</option>');
    }
});

function checkStock() {
    var item = $('.item').val();
    $.ajax({
        url: "/warehouse/stock-transaction/check-stock",
        type: "get",
        data: {id:item},
        success: function (data) {
            if(data.data == null){
                $('.stockSaatIni').val('Data Stock Tidak Ditemukan');
                $('.price').val('0');
                sum();
            }else{
                $('.stockSaatIni').val(data.data.stock);
                $('.price').val(parseInt(data.data.item.buy).toLocaleString("en-US"));
                sum();
            }
        },
    });
}
function sum() {
    var price = $('.price').val();
    var qty = $('.qty').val();
    var parsePrice = parseInt(price.replace(/,/g, ""));
    $('.total').val(parseInt(parsePrice*qty).toLocaleString("en-US"));
}
function jurnal(params) {
    // $('.dropHereJournals').
    $.ajax({
        url: "/warehouse/stock-transaction/check-journals",
        data: { id: params },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHereJournals").empty();
                $(".dropHereJournalsHpp").empty();
                $(".dropHereJournalsBalikDownPayment").empty();
                
                // alert('sd');
                $.each(data.jurnal[0].journal_detail, function (index, value) {
                    if (value.debet_kredit == "K") {
                        var dk =
                            "<td>0</td><td>" +
                            parseInt(value.total).toLocaleString("en-US") +
                            "</td>";
                    } else {
                        var dk =
                            "<td>" +
                            parseInt(value.total).toLocaleString("en-US") +
                            "</td><td>0</td>";
                    }
                    $(".dropHereJournals").append(
                        "<tr>" +
                            "<td>" +
                            value.account_data.code +
                            "</td>" +
                            "<td>" +
                            value.account_data.name +
                            "</td>" +
                            dk +
                            "</tr>"
                    );
                });
                if (typeof data.jurnal[1] != 'undefined') {
                    $.each(data.jurnal[1].journal_detail, function (index, value) {
                        if (value.debet_kredit == "K") {
                            var dk =
                                "<td>0</td><td>" +
                                parseInt(value.total).toLocaleString("en-US") +
                                "</td>";
                        } else {
                            var dk =
                                "<td>" +
                                parseInt(value.total).toLocaleString("en-US") +
                                "</td><td>0</td>";
                        }
                        $(".dropHereJournalsHpp").append(
                            "<tr>" +
                                "<td>" +
                                value.account_data.code +
                                "</td>" +
                                "<td>" +
                                value.account_data.name +
                                "</td>" +
                                dk +
                                "</tr>"
                        );
                    });
                }
         

            }
            $(".exampleModal").modal("show");
        },
    });
}