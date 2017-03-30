$(document).ready(function (e) {
    $("#employee-add-form").parsley();

    if ($("#employee-manage-table").length > 0) {
        window.employeeManageTable = $("#employee-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#employee-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
});