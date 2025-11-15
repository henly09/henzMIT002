let activityTable;
let selectedTimeframe = null;
let selectedLibrary = null;

function filterActivityTable(timeframe, library) {
  let url = "activities_pagination.php";
  if (timeframe) {
    url += `?timeframe=${timeframe}`;
  }
  if (library) {
    url += (timeframe ? "&" : "?") + `selectedLibrary=${library}`;
  }
  activityTable.ajax.url(url).load();
}

$(document).ready(function () {
  activityTable = $("#activity-table").DataTable({
    order: [[5, "desc"]],
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
      url: "activities_pagination.php",
      type: "POST",
      data: function(d) {
        d.startDate = $('#startDate').val();
        d.endDate = $('#endDate').val();
        d.library = $('#sessionRole').text().trim();
      }
    },
    columns: [
      {
        data: "STUDENTID",
        render: function (data) {
          return data ? String(data) : "";
        }, orderSequence: ["asc", "desc"]
      },
      { data: "FIRSTNAME", orderSequence: ["asc", "desc"] },
      { data: "SECTION", orderSequence: ["asc", "desc"] },
      { data: "LIBRARY", orderSequence: ["asc", "desc"] },
      { data: "TIMEIN", orderSequence: ["asc", "desc"] },
      { data: "TIMEOUT", orderSequence: ["asc", "desc"] },
      { data: "LOGDATE", orderSequence: ["asc", "desc"] },
      { data: "STATUS", orderSequence: ["asc", "desc"] },
    ],
  });
});

  $('#startDate, #endDate').on('change', function () {
    activityTable.ajax.reload();
  });