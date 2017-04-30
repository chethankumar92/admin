$(document).ready(function (e) {
    if ($("#event-manage-table").length > 0) {
        window.eventManageTable = $("#event-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#event-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
});