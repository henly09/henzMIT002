let table;
let selectedTimeframe = null;
let selectedLibrary = null;

function filterTable(timeframe, library) {
  let url = "top_students_pagination.php";
  if (timeframe) {
    url += `?timeframe=${timeframe}`;
  }
  if (library) {
    url += (timeframe ? "&" : "?") + `selectedLibrary=${library}`;
  }
  table.ajax.url(url).load();
}

$(document).ready(function () {
  table = $("#top-students-table").DataTable({
    order: [[1, "desc"]],
  lengthMenu: [
    [10, 25, 50, -1],
    [10, 25, 50, "All"]
  ],
    layout: {
      topStart: {
        buttons: [
    {
        extend: 'copy',
        className: 'btn btn-secondary',
        text: '<i class="bi bi-clipboard" title="Copy"></i>'
    },
    {
        extend: 'excel',
        className: 'btn btn-success',
        text: '<i class="bi bi-file-earmark-excel" title="Excel"></i>'
    },
    {
        extend: 'pdf',
        className: 'btn btn-danger',
        text: '<i class="bi bi-file-earmark-pdf" title="PDF"></i>'
    },
    {
        extend: 'print',
        className: 'btn btn-info',
        text: '<i class="bi bi-printer" title="Print"></i>'
    },
        ],
      },
      bottomStart: "pageLength",
      responsive: true,
    },
    pageResize: true,
    serverSide: true,
    processing: true,
    ajax: {
      url: "top_students_pagination.php",
      type: "POST",
            data: function (d) {
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
        d.library = $('#sessionRole').text().trim();
            }
    },
    columns: [
      { data: "FIRSTNAME", title: "Full Name", orderSequence: ["asc", "desc"] },
      { data: "visit_count", title: "Visits", orderSequence: ["asc", "desc"] },
    ],
  });

  table.button(6).addClass('active');

});

    $('#startDate, #endDate').on('change', function () {
        table.ajax.reload();
    });