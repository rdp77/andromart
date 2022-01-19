$(".filter_name").on("keyup", function () {
    table.search($(this).val()).draw();
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// fungsi update status
function searchData() {
    var dateS = $(".dtpickermnth").val();
    $(".dropHere").empty();
    $(".dropMonth").empty();

    $.ajax({
        url: "/report/report/search-report-periodic",
        data: { dateS: dateS },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHere").empty();
                $(".dropMonth").empty();
                if (data.message == "empty") {
                    $(".dropHere").empty();
                    $(".dropMonth").empty();
                } else {
                    $(".dropMonth").html(data.date);
                    var main = [];
                    $.each(data.result, function (index, value) {
                        var mainDetail = [];

                        $.each(value.main_detail, function (index1, value1) {
                            var jurnal = [];
                            $.each(value1.jurnal, function (index2, value2) {
                                jurnal[index2] =
                                    '<table><tr><td style="padding-left:100px">' +
                                    value2.code + 
                                    '</td><td style="padding-left:100px">' +
                                    value2.ref + 
                                    '</td><td style="padding-left:100px">' +
                                    value2.type + 
                                    '</td><td style="padding-left:100px">' +
                                    value2.total + 
                                    '</td></tr></table>';
                            });
                            mainDetail[index1] =
                                '<tr><th><h5>' +
                                value1.detail+'</h5>' + jurnal.join(' ')+
                                '</th></tr>';
                        });
                        main[index] =
                            '<tr><th style="background-color:antiquewhite;padding:0px;text-align:center"><b>' +
                            value.main +
                            '</b><br><br>' +
                            mainDetail.join(' ') +
                            '</th></tr><br>';
                    });
                    $(".dropHere").append(main);
                }
            }
        },
        error: function (data) {},
    });
}
