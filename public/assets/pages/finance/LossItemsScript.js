
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
        url: "/finance/loss-items/loss-items",
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    columns: [
        { data: "code" },
        { data: "created_by" },
        { data: "dateFormat" },
        { data: "dateRange" },
        { data: "technician.name" },
        { data: "totalValue" },
        { data: "action", orderable: false, searchable: true },
    ],
    order: [[0, 'desc']],
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
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
function jurnal(params) {
    // $('.dropHereJournals').
    $.ajax({
        url: "/finance/loss-items/check-journals",
        data: { id: params },
        type: "POST",
        success: function (data) {
            if (data.status == "success") {
                $(".dropHereJournals").empty();
                $(".dropHereJournalsToko").empty();
                
                // alert('sd');
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
                if (typeof data.jurnal[1] != 'undefined') {
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
                        $(".dropHereJournalsToko").append(
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
                }

                $('.dropTeknisi').html(parseInt(data.jurnal[0].journal_detail[0].total).toLocaleString("en-US"));
                $('.dropTotal').html(parseInt(data.jurnal[1].journal_detail[0].total).toLocaleString("en-US"));
                $('.dropToko').html(parseInt(data.jurnal[1].journal_detail[0].total-data.jurnal[0].journal_detail[0].total).toLocaleString("en-US"));
                console.log(data.jurnal[0].journal_detail[0].total);
                console.log(data.jurnal[1].journal_detail[0].total);
                

            }
            $(".exampleModal").modal("show");
        },
    });
}