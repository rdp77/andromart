"use strict";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#item").on("change", function () {
    var idItem = this.value;
    $.ajax({
        url: getdata,
        type: "GET",
        data: {
            item_id: idItem,
        },
        dataType: "json",
        success: function (data) {
            $("#saleDate").text(data.result.date);
            $("#qty").val(data.result.qty);
            $("#price").val(data.result.price);
            $("#total").val(data.result.total);
            $("#operator").val(data.result.operator);
        },
    });
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
            }
        },
    });
}
