$(document).ready(function (e) {
    if ($("#page-manage-table").length > 0) {
        window.pageManageTable = $("#page-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#page-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            fnDrawCallback: function (oSettings) {
                $('#page-manage-table .dropdown-toggle').dropdown();
            }
        });
    }
});

$(document).on("click", ".change-status", function (e) {
    e.preventDefault();

    var id = $(this).data("id");
    var status = $(this).data("status");

    var inputOptions = [];
    var statuses = $("#page-manage-table").data("statuses");
    statuses.forEach(function (stat, index) {
        inputOptions.push({
            text: stat.name,
            value: stat.psid
        });
    });

    bootbox.prompt({
        title: "Please select the status",
        inputType: 'select',
        value: status,
        inputOptions: inputOptions,
        callback: function (output) {
            if (output && output != status) {
                var data = new FormData();
                data.append('id', id);
                data.append('status', output);
                $.ajax({
                    url: $("#page-manage-table").data("status-action"),
                    data: data,
                    contentType: false,
                    processData: false,
                    type: $("#page-manage-table").data("status-method"),
                    success: function (response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            window.pageManageTable.draw();
                        }
                        $.notify(result.message, {
                            type: result.type || "error",
                            allow_dismiss: true,
                            showProgressbar: false,
                            placement: {
                                from: "bottom",
                                align: "right"
                            }
                        });
                    }
                });
            }
        }
    });

    $('.bootbox-prompt select').selectpicker();
});