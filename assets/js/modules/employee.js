    $(document).ready(function (e) {
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

    $(document).on("submit", "#employee-add-form", function (e) {
        e.preventDefault();

        var data = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr("action"),
            data: data,
            contentType: false,
            processData: false,
            type: $(this).attr("method"),
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    window.location.href = result.url;
                }
            }
        });
    });