$(document).ready(function (e) {
    if ($("#contact-manage-table").length > 0) {
        window.contactManageTable = $("#contact-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#contact-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
});