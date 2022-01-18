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
        url: "/report/report/search-report-cash-balance",
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
                        $.each(data.result, function (index, value) {
                        $(".dropHere").append(
                            "<tr>" +
                                "<td><b>" +
                                value.nama +
                                "</b>" +
                                "</td>" +
                                "<td style='text-align: right'><b>" +
                                "Rp. " +
                                parseInt(value.total).toLocaleString("en-US") +
                                "</b>" +
                                "</b></td>" +
                                "</tr>"
                        );
                    });
                }
            }
        },
        error: function (data) {},
    });
}
