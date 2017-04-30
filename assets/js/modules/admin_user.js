$(document).ready(function (e) {
    if ($("#admin-user-manage-table").length > 0) {
        window.adminUserManageTable = $("#admin-user-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#admin-user-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
});