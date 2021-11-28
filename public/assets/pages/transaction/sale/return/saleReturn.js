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
            $("#itemData").append(data.result.table);
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

function add() {
    var idItem = $("#item").find(":selected").val();
    $.ajax({
        url: addURL,
        type: "GET",
        data: {
            saleDetail: idItem,
        },
        dataType: "json",
        success: function (data) {
            $("#itemData").append(data.result);
            $(".select2").select2();
        },
    });
}

function remove_item(argument) {
    $(".data_" + argument).remove();
}

$(document.body).on("click", ".removeDataDetail", function () {
    $(".dataDetail_" + this.value).remove();
    var checkVerificationDiscount = $(
        'input[name="typeDiscount"]:checked'
    ).val();

    sum();
    sumTotal();
    if (checkVerificationDiscount == "percent") {
        sumDiscont();
    } else {
        sumDiscontValue();
    }
});

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
            }
        },
    });
}
