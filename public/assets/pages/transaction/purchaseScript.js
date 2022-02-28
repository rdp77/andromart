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
        url: "/transaction/purchasing/purchase",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "date" },
        { data: "code" },
        { data: "done" },
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
        text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data pembelian Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/purchasing/purchase/" + id,
                type: "DELETE",
                success: function () {
                    swal("Pembelian berhasil dihapus", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Pembelian Anda tidak jadi dihapus!");
        }
    });
}

function approve(id) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Menyetujui pembelian ini berarti anda telah melakukan pembayaran ke supplier",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/transaction/purchasing/approve/" + id,
                type: "GET",
                success: function () {
                    swal("Pembelian berhasil disetujui", {
                        icon: "success",
                    });
                    table.draw();
                },
            });
        } else {
            swal("Pembelian Anda tidak jadi disetujui!");
        }
    });
}



function changeDiscount(params) {
    if (params == 'percent') {
        $('#totalDiscountValue').css('pointer-events','none');
        $('#totalDiscountValue').css('background-color','#e9ecef');
        $('#totalDiscountPercent').css('pointer-events','auto');
        $('#totalDiscountPercent').css('background-color','#fff');
        document.getElementById("totalDiscountValue").value = 0;
    } else if (params == 'value') {
        $('#totalDiscountPercent').css('pointer-events','none');
        $('#totalDiscountPercent').css('background-color','#e9ecef');
        $('#totalDiscountValue').css('pointer-events','auto');
        $('#totalDiscountValue').css('background-color','#fff');
        document.getElementById("totalDiscountPercent").value = 0;
    } else {}
}


function printItems() {
    var index = $('.priceDetail').length;
    var dataDetail = $('.dataDetail').length;

    var dataItems = [];
    $.each($('.itemsData'), function(){
        dataItems += '<option data-index="'+(index+1)+'"  data-price="'+$(this).data('price')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    });
    // var dataUnits = [];
    // $.each($('.unitsData'), function(){
    //     dataUnits += '<option data-index="'+(index+1)+'"  data-price="'+$(this).data('price')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    // });
    // data-index="'+(index+1)+'"
    // var dataBranches = [];
    // $.each($('.branchesData'), function(){
    //     dataBranches += '<option data-code="'+$(this).data('code')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    // });
    var dataDet = dataDetail+1;
    // console.log(dataDet);
    $('.dropHereItem').append(
        '<tr class="dataDetail dataDetail_'+(dataDet)+'">'+
            '<td style="display:none">'+
                '<input type="hidden" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="idDetail[]" value="'+(index)+'">'+
            '</td>'+
            '<td>'+
                '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                    '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
                    dataItems+
                '</select>'+
            '</td>'+
            // '<td>'+
            // // '<select class="select2 itemsDetail" name="branchesDetail[]">'+
            // //     '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
            // //     dataBranches+
            // // '</select>'+
            // '<select class="select2 itemsDetail" name="branchesDetail[]">'+
            //     '<option value="-">- Select -</option>'+
            //     dataBranches+
            // '</select>'+
            // '</td>'+
            '<td>'+
                '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control qtyDetail qtyDetail_'+(index+1)+'" name="qtyDetail[]" data-index="'+(index+1)+'" value="1" style="text-align: right;">'+
            '</td>'+
            '<td>'+
                '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
            '</td>'+
        '</tr>' +
         // class="dataDetail dataDetail_'+(dataDet)+'"
        // '<tr class="dataDetail_'+(dataDet)+'">'+
        //     // '<td>'+(index+1)+'</td>'+
        //     // '<td>'+
        //     //     '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
        //     // '</td>'+
        // '</tr>' +
        '<tr class="dataDetail_'+(dataDet)+'" style="border-bottom: solid 2px #ddd; margin-bottom: 5px;">'+
            '<td colspan="5">'+
                '<input type="text" class="form-control desDetail desDetail_'+(index+1)+'" name="desDetail[]" placeholder="Deskripsi">'+
            '</td>'+
        '</tr>' +
        '<tr class="dataDetail_'+(dataDet)+'" height="50px">'+
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

    // var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();
    // sumTotal();
}
function addItem() {
    var index = $('.priceDetail').length;
    var dataDetail = $('.dataDetail').length;

    var dataItems = [];
    $.each($('.itemsData'), function(){
        dataItems += '<option data-index="'+(index+1)+'"  data-price="'+$(this).data('price')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    });
    // var dataUnits = [];
    // $.each($('.unitsData'), function(){
    //     dataUnits += '<option data-index="'+(index+1)+'"  data-price="'+$(this).data('price')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    // });
    // data-index="'+(index+1)+'"
    // var dataBranches = [];
    // $.each($('.branchesData'), function(){
    //     dataBranches += '<option data-code="'+$(this).data('code')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    // });
    var dataDet = dataDetail+1;
    // console.log('coba ' + dataItems);
    // console.log(dataDet);
    $('.dropHereItem').append(
        '<tr class="dataDetail dataDetail_'+(dataDet)+'">'+
            '<td style="display:none">'+
                '<input type="hidden" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="idDetail[]" value="'+(index)+'">'+
            '</td>'+
            '<td>'+
                '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                    '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
                    dataItems+
                '</select>'+
            '</td>'+
            // '<td>'+
            // // '<select class="select2 itemsDetail" name="branchesDetail[]">'+
            // //     '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
            // //     dataBranches+
            // // '</select>'+
            // '<select class="select2 itemsDetail" name="branchesDetail[]">'+
            //     '<option value="-">- Select -</option>'+
            //     dataBranches+
            // '</select>'+
            // '</td>'+
            '<td>'+
                '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" data-index="'+(index+1)+'" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control qtyDetail qtyDetail_'+(index+1)+'" name="qtyDetail[]" data-index="'+(index+1)+'" value="1" style="text-align: right;">'+
            '</td>'+
            '<td>'+
                '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
            '</td>'+
        '</tr>' +
         // class="dataDetail dataDetail_'+(dataDet)+'"
        // '<tr class="dataDetail_'+(dataDet)+'">'+
        //     '<td>'+
        //         '<input type="text" class="form-control qtyDetail qtyDetail_'+(index+1)+'" name="qtyDetail[]" data-index="'+(index+1)+'" value="1" style="text-align: right;">'+
        //     '</td>'+
        //     // '<td>'+(index+1)+'</td>'+
        //     // '<td>'+
        //     //     '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
        //     // '</td>'+
        // '</tr>' +
        '<tr class="dataDetail_'+(dataDet)+'" style="border-bottom: solid 2px #ddd; margin-bottom: 5px;">'+
            '<td colspan="5">'+
                '<input type="text" class="form-control desDetail desDetail_'+(index+1)+'" name="desDetail[]" placeholder="Deskripsi">'+
            '</td>'+
        '</tr>' +
        '<tr class="dataDetail_'+(dataDet)+'" height="50px">'+
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

    // var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();
    // sumTotal();
}
function addItems(branch_id, item_id, qty, price) {
    // console.log("coba", branch_id, item_id, qty, price);
    var total = qty * price;
    var index = $('.priceDetail').length;
    var dataDetail = $('.dataDetail').length;

    var dataItems = [];
    $.each($('.itemsData'), function(){
        if(item_id == this.value){
            dataItems += '<option data-index="'+(index+1)+'" data-price="'+$(this).data('price')+'" value="'+this.value+'" selected>'+$(this).data('name')+'</option>';
        } else {
            dataItems += '<option data-index="'+(index+1)+'" data-price="'+$(this).data('price')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
        }
    });
    // var dataBranches = [];
    // $.each($('.branchesData'), function(){
    //     if(branch_id == this.value){
    //         dataBranches += '<option data-code="'+$(this).data('code')+'" value="'+this.value+'" selected>'+$(this).data('name')+'</option>';
    //     } else {
    //         dataBranches += '<option data-code="'+$(this).data('code')+'" value="'+this.value+'">'+$(this).data('name')+'</option>';
    //     }
    // });
    var dataDet = dataDetail+1;
    // console.log(dataDet);
    $('.dropHereItem').append(
        '<tr class="dataDetail dataDetail_'+(dataDet)+'">'+
            '<td style="display:none">'+
                '<input type="hidden" class="form-control priceDetailSparePart priceDetailSparePart_'+(index+1)+'" name="idDetail[]" value="'+(index)+'">'+
            '</td>'+
            '<td>'+
                '<select class="select2 itemsDetail" name="itemsDetail[]">'+
                    '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
                    dataItems+
                '</select>'+
            '</td>'+
            // '<td>'+
            // // '<select class="select2 itemsDetail" name="branchesDetail[]">'+
            // //     '<option value="-" data-index="'+(index+1)+'">- Select -</option>'+
            // //     dataBranches+
            // // '</select>'+
            // '<select class="select2 itemsDetail" name="branchesDetail[]">'+
            //     '<option value="-">- Select -</option>'+
            //     dataBranches+
            // '</select>'+
            // '</td>'+
            '<td>'+
                '<input type="text" class="form-control cleaveNumeral priceDetail priceDetail_'+(index+1)+'" name="priceDetail[]" data-index="'+(index+1)+'" value="'+price+'" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control qtyDetail qtyDetail_'+(index+1)+'" name="qtyDetail[]" data-index="'+(index+1)+'" value="'+qty+'" style="text-align: right;">'+
            '</td>'+
            '<td>'+
                '<input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="'+total+'" style="text-align: right">'+
            '</td>'+
            '<td>'+
                '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
            '</td>'+
        '</tr>' +
         // class="dataDetail dataDetail_'+(dataDet)+'"
        // '<tr class="dataDetail_'+(dataDet)+'">'+
        //     // '<td>'+(index+1)+'</td>'+
        //     // '<td>'+
        //     //     '<button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button>'+
        //     // '</td>'+
        // '</tr>' +
        '<tr class="dataDetail_'+(dataDet)+'" style="border-bottom: solid 2px #ddd; margin-bottom: 5px;">'+
            '<td colspan="5">'+
                '<input type="text" class="form-control desDetail desDetail_'+(index+1)+'" name="desDetail[]" placeholder="Deskripsi">'+
            '</td>'+
        '</tr>' +
        '<tr class="dataDetail_'+(dataDet)+'" height="50px">'+
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

    // var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();
    sumTotal();
}

// mengganti item
$(document.body).on("change",".itemsDetail",function(){
    var index = $(this).find(':selected').data('index');
    // console.log($(this).val());
    // console.log(index);

    if ($(this).val() == '-') {
        $('.priceDetail_' + index).val(0);
        $('.qtyDetail_' + index).val(0);
        $('.totalPriceDetail_' + index).val(0);
    }else{
        var typeDetail = $('.typeDetail_' + index).find(':selected').val();
        // console.log(typeDetail);
        if (isNaN(parseInt($(this).find(':selected').data('price')))) {
            var itemPrice = 0;
        } else {
            var itemPrice = $(this).find(':selected').data('price');
        }
        // console.log(itemPrice);
        if (isNaN(parseInt($('.qtyDetail_' + index).val()))) {
            var itemQty = 0;
        } else {
            var itemQty = $('.qtyDetail_' + index).val().replace(/,/g, ''), asANumber = +itemQty;
        }
        $('.priceDetail_' + index).val(parseInt(itemPrice).toLocaleString('en-US'));
        var totalItemPrice = itemPrice * itemQty;
        $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
    }
    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();
    sumTotal();
});

// menghapus kolom
$(document.body).on("click",".removeDataDetail",function(){
    $('.dataDetail_'+this.value).remove();
    sumTotal();
});

// merubah qty
$(document.body).on("keyup",".qtyDetail",function(){
    var index = $(this).data('index');
    var typeDetail = $('.typeDetail_'+index).find(':selected').val();
    if(isNaN(parseInt($('.priceDetail_'+index).val()))){
        var itemPrice =  0; 
    }else{
        var itemPrice = $('.priceDetail_'+index).val().replace(/,/g, ''),asANumber = +itemPrice;
    }
    if(isNaN(parseInt(this.value))){
        var itemQty =  0; }else{
        var itemQty = this.value.replace(/,/g, ''),asANumber = +itemQty;
    }
    var totalItemPrice = itemPrice*itemQty;
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
    sumTotal();
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
    $('.totalPriceDetail_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
    if(typeDetail == 'SparePart'){
        $('.priceDetailSparePart_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        $('.priceDetailLoss_'+index).val(0);
    }else{
        $('.priceDetailLoss_'+index).val(parseInt(totalItemPrice).toLocaleString('en-US'));
        $('.priceDetailSparePart_'+index).val(0);
    }
    sumTotal();
});
function sumDiscount() {
    var totalDiscountPercent = $('#totalDiscountPercent').val().replace(/,/g, ''),asANumber = +totalDiscountPercent;
    // console.log(totalDiscountPercent);
    if(totalDiscountPercent > 100){
        document.getElementById("totalDiscountPercent").value = 0;
        alert('Diskon melebihi angka 100%');
    }
    sumTotal();
}
function sumTotal() {
    var totalGrand = 0;
    var totalPriceDetail = 0;
    var totalDiscount = 0;
    $('.totalPriceDetail').each(function(){
        totalPriceDetail += parseInt(this.value.replace(/,/g, ""))
    });
    $('#priceTotal').val(parseInt(totalPriceDetail).toLocaleString('en-US'));

    var checkVerificationDiscount =  $('input[name="typeDiscount"]:checked').val();
    if (checkVerificationDiscount == 'percent') {
        var discountPercent = $('#totalDiscountPercent').val().replace(/,/g, ''),asANumber = +discountPercent;
        var totalDiscount = totalPriceDetail * discountPercent / 100;
    }else{
        var discountValue = $('#totalDiscountValue').val().replace(/,/g, ''),asANumber = +discountValue;
        if (discountValue > totalPriceDetail) {
            $('#totalDiscountValue').val(0);
            alert('Diskon lebih besar dari harga beli');
        } else {
            var totalDiscount = discountValue;
        }
    }
    $('#discountTotal').val(parseInt(totalDiscount).toLocaleString('en-US'));
    // $('#discountTotal').val(checkVerificationDiscount);

    var totalGrand = totalPriceDetail - totalDiscount;
    $('#grandTotal').val(parseInt(totalGrand).toLocaleString('en-US'));
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
            // swal("Belum Disimpan !");
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
                url: "/transaction/purchasing/purchase",
                data: $(".form-data").serialize(),
                type: 'POST',
                // contentType: false,
                // processData: false,
                success: function(data) {
                    if (data.status == 'success'){
                        swal(data.message, {
                            icon: "success",
                        });
                        // location.reload();
                    }
                },
                error: function(data) {
                    // edit(id);
                }
            });

        } else {
            swal("Belum Disimpan !");
        }
    });
}

function paymentMethodChange() {
    var branch = $('.branchId').val();
    var value = $('.PaymentMethod').val();
    var dataItems = [];
    $('.account').empty();
    $.each($('.accountDataHidden'), function(){
        if (value == 'Cash') {
            if ($(this).data('maindetailname') == 'Kas Kecil' && branch == $(this).data('branch')) {
                dataItems += '<option value="'+this.value+'">'+$(this).data('code') +' - '+ $(this).data('name')+'</option>';
            }else if($(this).data('maindetailname') == 'Kas Besar' && branch == $(this).data('branch')){
                dataItems += '<option value="'+this.value+'">'+$(this).data('code') +' - '+ $(this).data('name')+'</option>';

            }
        }else if(value == 'Debit' || value == 'Transfer'){
            if ($(this).data('maindetailname') == 'Kas Bank' && branch == $(this).data('branch')) {
                dataItems += '<option value="'+this.value+'">'+$(this).data('code') +' - '+ $(this).data('name')+'</option>';
            }
        }else{

        }
    });
    
    $('.account').append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $('.account').append(dataItems);
    // }
    // alert($('.PaymentMethod').val());
}

function branchChange() {
    var branch = $('.branchId').val();
    var value = $('.PaymentMethod').val();
    var dataItems = [];
    $('.account').empty();
    $.each($('.accountDataHidden'), function(){
        if (value == 'Cash') {
            if ($(this).data('mainname') == 'Kas' && branch == $(this).data('branch')) {
                dataItems += '<option value="'+this.value+'">'+$(this).data('code') +' - '+ $(this).data('name')+'</option>';
            }
        }
    });

    $('.account').append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $('.account').append(dataItems);
    // }
    // alert($('.PaymentMethod').val());
}

function jurnal(params) {
    $('.dropHereJournals').empty();
    // $('.dropHereJournals').
    $.ajax({
        url: "/transaction/service/check-journals",
        data: {id:params},
        type: 'POST',
        success: function(data) {
            if (data.status == 'success'){
                $.each(data.jurnal.journal_detail, function(index,value){
                    if (value.debet_kredit == 'K') {
                        var dk = '<td>0</td><td>'+parseInt(value.total).toLocaleString('en-US')+'</td>';
                    }else{
                        var dk = '<td>'+parseInt(value.total).toLocaleString('en-US')+'</td><td>0</td>';
                    }
                    $('.dropHereJournals').append(
                            '<tr>'+
                                '<td>'+value.account_data.code+'</td>'+
                                '<td>'+value.account_data.name+'</td>'+
                                dk+
                            '</tr>'
                    );
                });
            }
            $('#exampleModal').modal('show')

        },
    });
}