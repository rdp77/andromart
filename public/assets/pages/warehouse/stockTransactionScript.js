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
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "date" },
        { data: "item.stock[0].branch.name" },
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
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data dana kredit Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/credit-funds/creditFunds/" + id,
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
function save(argument) {

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
                        swal("Data "+argument+" Berhasil Disimpan", {
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

function updateData(argument) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan mengupdate data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            $.ajax({
                url: "/transaction/credit-funds/creditFunds/"+argument,
                data: $(".form-data").serialize(),
                type: 'post',
                success: function(data) {
                    swal("Data Dana Kredit PDL Berhasil Disimpan", {
                        icon: "success",
                    });
                    location.reload();
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
        $('.reason').empty();
        $('.reason').append('<option value="">- Select -</option>');
        $('.reason').append('<option value="Penambahan">Penambahan Stock</option>');
    }else if(this.value == 'Out'){
        $('.reason').empty();
        $('.reason').append('<option value="">- Select -</option>');
        $('.reason').append('<option value="Rusak">Barang Rusak</option>');
        $('.reason').append('<option value="Hilang">Barang Hilang</option>');
        $('.reason').append('<option value="Salah Input">Salah Input</option>');
    }else{
        $('.reason').empty();
        $('.reason').append('<option value="">- Select -</option>');
    }
});



