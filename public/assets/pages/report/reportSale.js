$(".filter_name").on("keyup", function () {
    table.search($(this).val()).draw();
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// fungsi cek data Sale
function checkData() {
    var dateS = $('#startDate').val();
    var dateE = $('#endDate').val();
    // $('.dropHereTotal').text(0);
    // $('.dropHereTotalVal').val(0);

    // var jurnalDetailD = []
    // var jurnalDetailK = []
    // var jurnalDetailTransaksi = []
    var saleDetail = []
    var totalKotor = 0;
    var totalBersih = 0;
    // var totalPengeluaran = 0;
    // var totalPendapatan = 0;
    $('.dropHere').empty();
    $.ajax({
        url: "/report/report/report-sale",
        data: {dateS:dateS,dateE:dateE},
        type: 'POST',
        success: function(data) {
            if (data.status == 'success'){
                $('.dropHere').empty();
                if(data.message == 'empty'){
                    $('.dropHere').empty();
                }else{
                    $.each(data.result, function(index,value){
                        // if (value.code.includes("KK")) {
                        //     totalPengeluaran+=value.total;
                        // }else{
                        //     totalPendapatan+=value.total;
                        // }
                        // $.each(value.journal_detail, function(index1,value1){
                        //     jurnalDetailTransaksi[index] =
                        //     '<b>'+value.journal_detail[0].account_data.code+'</b><br>'+
                        //     value.journal_detail[0].account_data.name;
                        //     if (value.code.includes("DD")) {
                        //         jurnalDetailD[index] =
                        //         ' Rp. '+parseInt(value.journal_detail[0].total).toLocaleString('en-US');
                        //     }else{
                        //         jurnalDetailK[index] =
                        //         ' Rp. '+parseInt(value.journal_detail[0].total).toLocaleString('en-US');
                        //     }
                        // })

                        // if (jurnalDetailD[index] == undefined) {
                        //     var jurnalDetailDReal = '';
                        // }else{
                        //     var jurnalDetailDReal = jurnalDetailD[index];
                        // }

                        // if (jurnalDetailK[index] == undefined) {
                        //     var jurnalDetailKReal = '';
                        // }else{
                        //     var jurnalDetailKReal = jurnalDetailK[index];
                        // }

                        $('.dropHere').append(
                            '<tr>'+
                                '<td><b>'+
                                    value.code+'</b><br>'+
                                    value.id+
                                '</td>'+
                                // '<td><b>'+
                                //     moment(value.date).format('DD MM YYYY')+
                                // '</b></td>'+
                                // '<td><b>'+
                                //     value.ref+'</b><br>'+
                                //     value.description+
                                // '</td>'+
                                // '<td>'+
                                //     jurnalDetailTransaksi[index]+
                                // '</td>'+
                                // '<td><b>'+
                                //     jurnalDetailDReal+
                                // '</b></td>'+
                                // '<td><b>'+
                                //     jurnalDetailKReal+
                                // '</b></td>'+
                                // '<td style="vertical-align: top;"><b> Rp. '+
                                //     parseInt(value.total).toLocaleString('en-US')+
                                // '</b></td>'+
                            '</tr>'
                        );

                        // $('.dropHere').append(
                        //     '<tr>' +
                        //         '<td><b>' +value.date+ '</b></td>'+
                        //         '<td><b>' +value.code+ '</b></td>'
                        // );
                    });

                    $('.dropTransaksi').text('Rp. '+parseInt(value.total_price).toLocaleString('en-US'));
                    // $('.dropPengeluaran').text('Rp. '+parseInt(totalPengeluaran).toLocaleString('en-US'));
                    // $('.dropPendapatan').text('Rp. '+parseInt(totalPendapatan).toLocaleString('en-US'));
                    // $('.dropHereTotalVal').html('<input type="hidden" class="form-control" name="totalValue" value="'+totalAkhir+'">');
                }
            }
        },
        error: function(data) {
        }
    });
}
