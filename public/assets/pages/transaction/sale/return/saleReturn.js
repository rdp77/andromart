"use strict";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#item").on("change", function () {
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
