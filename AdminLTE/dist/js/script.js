
let table2 = new DataTable('#activity-table', {
    layout: {
        topStart: {
            buttons: [
                'copy', 'excel', 'pdf', 'print',
            ]
        },
        bottomStart: 'pageLength',
        responsive: true,
    },
    order: [
        [1, 'asc']
    ]
});