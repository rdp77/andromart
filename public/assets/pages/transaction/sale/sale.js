"use strict";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var idSaved = '';
function save() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            var validation = 0;
            $(".validation").each(function () {
                if (
                    $(this).val() == "" ||
                    $(this).val() == null ||
                    $(this).val() == 0
                ) {
                    validation++;
                    iziToast.warning({
                        type: "warning",
                        title: $(this).data("name") + " Harus Di isi",
                    });
                } else {
                    validation - 1;
                }
            });
            if (validation != 0) {
                return false;
            }
            $.ajax({
                url: "/transaction/sale/sale",
                data: $(".form-data").serialize(),
                type: "POST",
                // contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, {
                            icon: "success",
                        });
                        // location.reload();
                        $('.tombolSave').css('display','none')
                        $('.tombolPrintKecil').css('display','block');
                        $('.tombolPrintBesar').css('display', 'block');
                        idSaved = data.id;
                    } else {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }
                },
                error: function (data) {
                    // edit(id);
                },
            });
        } else {
            swal("Data Belum Disimpan !");
        }
    });
}

function printBesar(params) {
    window.open(params + '/transaction/sale/salePrint/' + idSaved);
}

function printKecil(params) {
    window.open(params + '/transaction/sale/smallPrint/' + idSaved);
}

function updateData(params) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            var validation = 0;
            $(".validation").each(function () {
                if (
                    $(this).val() == "" ||
                    $(this).val() == null ||
                    $(this).val() == 0
                ) {
                    validation++;
                    iziToast.warning({
                        type: "warning",
                        title: $(this).data("name") + " Harus Di isi",
                    });
                } else {
                    validation - 1;
                }
            });
            if (validation != 0) {
                return false;
            }
            $.ajax({
                url: "/transaction/sale/sale/" + params,
                data: $(".form-data").serialize(),
                type: "PUT",
                // contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, {
                            icon: "success",
                        });
                        location.reload();
                    } else {
                        swal(data.message, {
                            icon: "warning",
                        });
                    }
                },
                error: function (data) {
                    // edit(id);
                },
            });
        } else {
            swal("Data Belum Disimpan !");
        }
    });
}

function customerChange() {
    $("#customerName").val($(".customerId").find(":selected").data("name"));
    $("#customerPhone").val($(".customerId").find(":selected").data("phone"));
    $("#customerAdress").val(
        $(".customerId").find(":selected").data("address")
    );
}

function changeDiscount(params) {
    if (params == "percent") {
        $("#totalDiscountValue").css("pointer-events", "none");
        $("#totalDiscountValue").css("background-color", "#e9ecef");
        $("#totalDiscountPercent").css("pointer-events", "auto");
        $("#totalDiscountPercent").css("background-color", "#fff");
    } else {
        $("#totalDiscountPercent").css("pointer-events", "none");
        $("#totalDiscountPercent").css("background-color", "#e9ecef");
        $("#totalDiscountValue").css("pointer-events", "auto");
        $("#totalDiscountValue").css("background-color", "#fff");
    }
}

function addItem() {
    var index = $(".priceDetail").length;
    var dataDetail = $(".dataDetail").length;

    var dataBuyer = [];
    $.each($(".buyerData"), function () {
        dataBuyer +=
            '<option data-index="' +
            (index + 1) +
            '" value="' +
            this.value +
            '">' +
            $(this).data("name") +
            "</option>";
    });
    var dataItems = [];
    $.each($(".itemsData"), function () {
        if ($(this).data("stock") == null) {
            var stocks = 0;
        } else {
            var stocks = $(this).data("stock");
        }
        dataItems +=
            '<option data-index="' +
            (index + 1) +
            '" data-supplier="' +
            $(this).data("supplier") +
            '" data-price="' +
            $(this).data("price") +
            '" data-profit="' +
            $(this).data("profit") +
            '" data-stock="' +
            stocks +
            '" value="' +
            this.value +
            '">' +
            $(this).data("name") +
            "</option>";
    });

    $(".dropHereItem").append(
        '<tr class="dataDetail dataDetail_' +
            (dataDetail + 1) +
            '">' +
            '<td style="display:none">' +
            '<input type="text" class="form-control priceDetailSparePart priceDetailSparePart_' +
            (index + 1) +
            '" name="priceDetailSparePart[]" value="0">' +
            '<input type="text" class="form-control priceDetailLoss priceDetailLoss_' +
            (index + 1) +
            '" name="priceDetailLoss[]" value="0">' +
            "</td>" +
            "<td>" +
            '<select class="select2 itemsDetail" name="itemsDetail[]">' +
            '<option value="-" data-index="' +
            (index + 1) +
            '">- Select -</option>' +
            dataItems +
            "</select>" +
            '<input type="text" class="form-control supplier supplier_' +
            (index + 1) +
            '" name="supplierDetail[]" data-index="' +
            (index + 1) +
            '" readonly>' +
            "</td>" +
            "<td>" +
            '<input type="text" class="form-control qtyDetail qtyDetail_' +
            (index + 1) +
            '" name="qtyDetail[]" data-index="' +
            (index + 1) +
            '" value="1" style="text-align: right">' +
            '<input type="text" class="form-control stock stock_' +
            (index + 1) +
            '" readonly name="stockDetail[]" data-index="' +
            (index + 1) +
            '" value="0" style="text-align: right">' +
            "</td>" +
            "<td>" +
            '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_' +
            (index + 1) +
            '" name="priceDetail[]" data-index="' +
            (index + 1) +
            '" value="0" style="text-align: right">' +
            '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_' +
            (index + 1) +
            '" name="totalPriceDetail[]" value="0" style="text-align: right">' +
            "</td>" +
            "<td>" +
            '<select class="select2 buyerDetail" name="buyerDetail[]">' +
            '<option value="" data-index="' +
            (index + 1) +
            '">- Pengambil Barang -</option>' +
            dataBuyer +
            "</select>" +
            '<input type="text" class="form-control" name="salesDetail[]" value="Penjual" readonly>' +
            "</td>" +
            "<td>" +
            '<input type="number" class="form-control" name="profitSharingBuyer[]" value="0">' +
            '<input type="number" class="form-control" name="profitSharingSales[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input type="text" class="form-control cleaveNumeral profitDetail profitDetail_' +
            (index + 1) +
            '" name="profitDetail[]" data-index="' +
            (index + 1) +
            '" value="0" style="text-align: right" hidden>' +
            '<input type="text" class="form-control" name="descriptionDetail[]">' +
            "</td>" +
            '<td style="display:none">' +
            '<select class="form-control typeDetail typeDetail_' +
            (index + 1) +
            '" name="typeDetail[]">' +
            '<option selected data-index="' +
            (index + 1) +
            '" value="SparePart">Barang</option>' +
            "</select>" +
            "</td>" +
            "<td>" +
            '<button type="button" class="btn btn-danger removeDataDetail" value="' +
            (index + 1) +
            '" >X</button>' +
            "</td>" +
            "</tr>"
    );
    $(".select2").select2();
    $(".cleaveNumeral")
        .toArray()
        .forEach(function (field) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            });
        });

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
}

// mengganti item
$(document.body).on("change", ".itemsDetail", function () {
    var index = $(this).find(":selected").data("index");
    // console.log($(this).val());
    // console.log(index);

    if ($(this).val() == "-") {
        $(".priceDetail_" + index).val(0);
        $(".profitDetail_" + index).val(0);
        $(".supplier_" + index).val(" ");
        $(".stock_" + index).val(0);
        $(".qtyDetail_" + index).val(0);
        $(".totalPriceDetail_" + index).val(0);
    } else {
        var typeDetail = $(".typeDetail_" + index)
            .find(":selected")
            .val();
        if (isNaN(parseInt($(this).find(":selected").data("price")))) {
            var itemPrice = 0;
        } else {
            var itemPrice = $(this).find(":selected").data("price");
        }
        if (isNaN(parseInt($(".qtyDetail_" + index).val()))) {
            var itemQty = 0;
        } else {
            var itemQty = $(".qtyDetail_" + index)
                    .val()
                    .replace(/,/g, ""),
                asANumber = +itemQty;
        }
        $(".priceDetail_" + index).val(
            parseInt(itemPrice).toLocaleString("en-US")
        );
        // $('.profitDetail_' + index).val(parseInt(itemProfit).toLocaleString('en-US'));
        var totalItemPrice = itemPrice * itemQty;
        $(".profitDetail_" + index).val(
            $(this).find(":selected").data("profit")
        );
        $(".stock_" + index).val($(this).find(":selected").data("stock"));
        $(".supplier_" + index).val($(this).find(":selected").data("supplier"));
        $(".totalPriceDetail_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        if (typeDetail == "SparePart") {
            $(".priceDetailSparePart_" + index).val(
                parseInt(totalItemPrice).toLocaleString("en-US")
            );
            $(".priceDetailLoss_" + index).val(0);
        } else {
            $(".priceDetailLoss_" + index).val(
                parseInt(totalItemPrice).toLocaleString("en-US")
            );
            $(".priceDetailSparePart_" + index).val(0);
        }
    }
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

// menghapus kolom
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

$(document.body).on("click", ".removeDataDetailExisting", function () {
    $(".dropDeletedExistingData").append(
        '<input type="hidden" class="form-control" value="' +
            $(this).data("id") +
            '" name="deletedExistingData[]">'
    );
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

// merubah qty
$(document.body).on("keyup", ".qtyDetail", function () {
    var index = $(this).data("index");
    var typeDetail = $(".typeDetail_" + index)
        .find(":selected")
        .val();
    if (isNaN(parseInt($(".priceDetail_" + index).val()))) {
        var itemPrice = 0;
    } else {
        var itemPrice = $(".priceDetail_" + index)
                .val()
                .replace(/,/g, ""),
            asANumber = +itemPrice;
    }
    if (isNaN(parseInt(this.value))) {
        var itemQty = 0;
    } else {
        var itemQty = this.value.replace(/,/g, ""),
            asANumber = +itemQty;
    }
    var totalItemPrice = itemPrice * itemQty;
    $(".totalPriceDetail_" + index).val(
        parseInt(totalItemPrice).toLocaleString("en-US")
    );

    if (typeDetail == "SparePart") {
        $(".priceDetailSparePart_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        $(".priceDetailLoss_" + index).val(0);
    } else {
        $(".priceDetailLoss_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        $(".priceDetailSparePart_" + index).val(0);
    }
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

// merubah harga
$(document.body).on("keyup", ".priceDetail", function () {
    var index = $(this).data("index");
    var typeDetail = $(".typeDetail_" + index)
        .find(":selected")
        .val();

    if (isNaN(parseInt(this.value))) {
        var itemPrice = 0;
    } else {
        var itemPrice = this.value.replace(/,/g, ""),
            asANumber = +itemPrice;
    }
    if (isNaN(parseInt($(".qtyDetail_" + index).val()))) {
        var itemQty = 0;
    } else {
        var itemQty = $(".qtyDetail_" + index)
                .val()
                .replace(/,/g, ""),
            asANumber = +itemQty;
    }
    var totalItemPrice = itemPrice * itemQty;
    $(".totalPriceDetail_" + index).val(
        parseInt(totalItemPrice).toLocaleString("en-US")
    );
    if (typeDetail == "SparePart") {
        $(".priceDetailSparePart_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        $(".priceDetailLoss_" + index).val(0);
    } else {
        $(".priceDetailLoss_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        $(".priceDetailSparePart_" + index).val(0);
    }
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

// fungsi sum
function sum() {
    var priceDetailSparePart = 0;
    $(".priceDetailSparePart").each(function () {
        priceDetailSparePart += parseInt(this.value.replace(/,/g, ""));
    });
    $("#totalSparePart").val(
        parseInt(priceDetailSparePart).toLocaleString("en-US")
    );
    var priceDetailLoss = 0;
    $(".priceDetailLoss").each(function () {
        priceDetailLoss += parseInt(this.value.replace(/,/g, ""));
    });
    $("#totalLoss").val(parseInt(priceDetailLoss).toLocaleString("en-US"));
}

// fungsi rubah tipe
$(document.body).on("change", ".typeDetail", function () {
    var value = this.value;
    var index = $(this).find(":selected").data("index");
    if (isNaN(parseInt($(".priceDetail_" + index).val()))) {
        var itemPrice = 0;
    } else {
        var itemPrice = $(".priceDetail_" + index)
                .val()
                .replace(/,/g, ""),
            asANumber = +itemPrice;
    }
    if (isNaN(parseInt($(".qtyDetail_" + index).val()))) {
        var itemQty = 0;
    } else {
        var itemQty = $(".qtyDetail_" + index)
                .val()
                .replace(/,/g, ""),
            asANumber = +itemQty;
    }
    var totalItemPrice = itemPrice * itemQty;
    if (value == "SparePart") {
        $(".priceDetailSparePart_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        $(".priceDetailLoss_" + index).val(0);
    } else {
        $(".priceDetailLoss_" + index).val(
            parseInt(totalItemPrice).toLocaleString("en-US")
        );
        $(".priceDetailSparePart_" + index).val(0);
    }
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

function sumDiscont() {
    if (isNaN(parseInt($("#totalSparePart").val()))) {
        var totalSparePart = 0;
    } else {
        var totalSparePart = $("#totalSparePart").val().replace(/,/g, ""),
            asANumber = +totalSparePart;
    }

    if (isNaN(parseInt($("#totalDiscountPercent").val()))) {
        var totalDiscountPercent = 0;
    } else {
        var totalDiscountPercent = $("#totalDiscountPercent")
                .val()
                .replace(/,/g, ""),
            asANumber = +totalDiscountPercent;
    }

    if (totalDiscountPercent <= 100) {
        var sumTotalPrice =
            (parseInt(totalDiscountPercent) / 100) * parseInt(totalSparePart);
        $("#totalDiscountValue").val(
            parseInt(sumTotalPrice).toLocaleString("en-US")
        );
        $("#totalDiscountPercent").val(totalDiscountPercent);
    } else {
        $("#totalDiscountPercent").val(0);
        $("#totalDiscountValue").val(0);
        var sumTotalPrice = (100 / 100) * parseInt(totalSparePart);
    }
    sumTotal();
}

function sumDiscontValue() {
    if (isNaN(parseInt($("#totalSparePart").val()))) {
        var totalSparePart = 0;
    } else {
        var totalSparePart = $("#totalSparePart").val().replace(/,/g, ""),
            asANumber = +totalSparePart;
    }
    if (isNaN(parseInt($("#totalService").val()))) {
        var totalService = 0;
    } else {
        var totalService = $("#totalService").val().replace(/,/g, ""),
            asANumber = +totalService;
    }

    if (isNaN(parseInt($("#totalDiscountValue").val()))) {
        var totalDiscountValue = 0;
    } else {
        var totalDiscountValue = $("#totalDiscountValue")
                .val()
                .replace(/,/g, ""),
            asANumber = +totalDiscountValue;
    }
    var totalValue = parseInt(totalSparePart);

    if (totalDiscountValue <= totalValue) {
        console.log(totalDiscountValue);
        console.log(totalValue);
        var sumTotalPrice = (parseInt(totalDiscountValue) / totalValue) * 100;
    } else {
        var sumTotalPrice = 100;
    }
    if (isNaN(parseInt(sumTotalPrice))) {
        $("#totalDiscountPercent").val(0);
    } else {
        $("#totalDiscountPercent").val(
            parseFloat(sumTotalPrice).toLocaleString("en-US")
        );
    }
    sumTotal();
}

function sumTotal() {
    var checkVerificationPrice = $(
        'input[name="verificationPrice"]:checked'
    ).val();

    if (isNaN(parseInt($("#totalSparePart").val()))) {
        var totalSparePart = 0;
    } else {
        var totalSparePart = $("#totalSparePart").val().replace(/,/g, ""),
            asANumber = +totalSparePart;
    }

    if (isNaN(parseInt($("#totalDiscountValue").val()))) {
        var totalDiscountValue = 0;
    } else {
        var totalDiscountValue = $("#totalDiscountValue")
                .val()
                .replace(/,/g, ""),
            asANumber = +totalDiscountValue;
    }

    if (checkVerificationPrice == "Y") {
        var sumTotal = 0;
    } else {
        var sumTotal = parseInt(totalSparePart) - parseInt(totalDiscountValue);
    }

    var totalValue = parseInt(totalSparePart);

    if (totalDiscountValue <= totalValue) {
        $("#totalPrice").val(parseInt(sumTotal).toLocaleString("en-US"));
    } else {
        $("#totalPrice").val(totalValue);
        $("#totalDiscountValue").val(0);
    }
}

function paymentMethodChange() {
    var branch = $(".branchId").val();
    var value = $(".PaymentMethod").val();
    var dataItems = [];
    $(".account").empty();
    $.each($(".accountDataHidden"), function () {
        if (value == "Cash") {
            if (
                $(this).data("maindetailname") == "Kas Kecil" &&
                branch == $(this).data("branch")
            ) {
                dataItems +=
                    '<option value="' +
                    this.value +
                    '">' +
                    $(this).data("code") +
                    " - " +
                    $(this).data("name") +
                    "</option>";
            } else if (
                $(this).data("maindetailname") == "Kas Besar" &&
                branch == $(this).data("branch")
            ) {
                dataItems +=
                    '<option value="' +
                    this.value +
                    '">' +
                    $(this).data("code") +
                    " - " +
                    $(this).data("name") +
                    "</option>";
            }
        } else if (value == "Debit" || value == "Transfer") {
            if (
                $(this).data("maindetailname") == "Kas Bank" &&
                branch == $(this).data("branch")
            ) {
                dataItems +=
                    '<option value="' +
                    this.value +
                    '">' +
                    $(this).data("code") +
                    " - " +
                    $(this).data("name") +
                    "</option>";
            }
        } else {
        }
    });

    $(".account").append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $(".account").append(dataItems);
    // }
    // alert($('.PaymentMethod').val());
}

function jurnal(params) {
    $(".dropHereJournals").empty();
    // $('.dropHereJournals').
    $.ajax({
        url: "/transaction/service/check-journals",
        data: { id: params },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                if (data.jurnal[0].type.includes("Transfer")) {
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
                } else {
                    $.each(
                        data.jurnal[0].journal_detail,
                        function (index, value) {
                            if (value.debet_kredit == "K") {
                                var dk =
                                    "<td>0</td><td>" +
                                    parseInt(value.total).toLocaleString(
                                        "en-US"
                                    ) +
                                    "</td>";
                            } else {
                                var dk =
                                    "<td>" +
                                    parseInt(value.total).toLocaleString(
                                        "en-US"
                                    ) +
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
                        }
                    );
                }
            }
            $("#exampleModal").modal("show");
        },
    });
}

// function jurnal(params) {
//     $(".dropHereJournals").empty();
//     // $('.dropHereJournals').
//     $.ajax({
//         url: "/transaction/sale/check-journals",
//         data: { id: params },
//         type: "POST",
//         success: function (data) {
//             if (data.status == "success") {
//                 $.each(data.jurnal.journal_detail, function (index, value) {
//                     if (value.debet_kredit == "K") {
//                         var dk =
//                             "<td>0</td><td>" +
//                             parseInt(value.total).toLocaleString("en-US") +
//                             "</td>";
//                     } else {
//                         var dk =
//                             "<td>" +
//                             parseInt(value.total).toLocaleString("en-US") +
//                             "</td><td>0</td>";
//                     }
//                     $(".dropHereJournals").append(
//                         "<tr>" +
//                             "<td>" +
//                             value.account_data.code +
//                             "</td>" +
//                             "<td>" +
//                             value.account_data.name +
//                             "</td>" +
//                             dk +
//                             "</tr>"
//                     );
//                 });
//             }
//             $("#exampleModal").modal("show");
//         },
//     });
// }
