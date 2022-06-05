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
                        var total = 0;

    $.ajax({
        url: "/report/report/search-report-cash-balance",
        data: { dateS: dateS },
        type: "POST",
        success: function (data) {
            var total = 0;

            if (data.status == "success") {
                $(".dropHere").empty();
                $(".dropMonth").empty();
                if (data.message == "empty") {
                    $(".dropHere").empty();
                    $(".dropMonth").empty();
                } else {
                        $(".dropMonth").html(data.date);
                        $.each(data.data, function (index, value) {
                        total+=value.total;
                        $(".dropHere").append(
                                "<tr>" +
                                    "<td><b>" +
                                    value.namaAkun +
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
                        $('.dropTotal').html("<div class='card-header' style='background-color: #ffffdc; color:black'><h3>Total Kas : Rp. "+parseInt(total).toLocaleString("en-US")+"</h3></div>")
                }
            }
        },
        error: function (data) {},
    });
}
