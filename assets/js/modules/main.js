$(document).ready(function (e) {
    if ($("form[data-parsley-validate]").length > 0) {
        $("form[data-parsley-validate]").parsley();
    }

    if ($('.datepicker').length > 0) {
        $('.datepicker').datepicker({
            clearBtn: true,
            format: "yyyy-mm-dd"
        });
    }
    if ($('.selectpicker').length > 0) {
        $('.selectpicker').selectpicker();
    }

    if ($('.summernote').length > 0) {
        $('.summernote').summernote({
            minHeight: 100
        });
    }

    if ($("[id$='-manage-table']").length > 0) {
        $.each($("[id$='-manage-table']"), function (index, table) {
            var tableIndex = camelize(table.id);
            window[tableIndex] = $(table).DataTable({
                dom: '<"col-sm-4"l><"col-sm-4"B><"col-sm-4"f><"col-sm-6"i><"col-sm-6"p>rTt',
                serverSide: true,
                ajax: {
                    url: $(table).data("render-url"),
                    type: 'POST'
                },
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                fnDrawCallback: function (oSettings) {
                    $(table).find('.dropdown-toggle').dropdown();
                }
            });

            $(document).on("click", "#" + table.id + " .change-status", function (e) {
                e.preventDefault();

                var id = $(this).data("id");
                var status = $(this).data("status");
                var statusKey = $(table).data("status-key");

                var inputOptions = [];
                var statuses = $(table).data("statuses");
                statuses.forEach(function (stat, index) {
                    inputOptions.push({
                        text: stat.name,
                        value: stat[statusKey]
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
                                url: $(table).data("status-action"),
                                data: data,
                                contentType: false,
                                processData: false,
                                type: $(table).data("status-method"),
                                success: function (response) {
                                    var result = JSON.parse(response);
                                    if (result.success) {
                                        window[tableIndex].draw();
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
        });
    }
});

function camelize(str) {
    return str.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function (match, index) {
        if (+match === 0)
            return ""; // or if (/\s+/.test(match)) for white spaces
        return index === 0 ? match.toLowerCase() : match.toUpperCase();
    }).replace(/-/g, '');
}

$(document).on("submit", "form[data-parsley-validate]", function (e) {
    e.preventDefault();

    var l = Ladda.create($(this).find('button[type=submit]')[0]);
    l.start();

    var data = new FormData($(this)[0]);
    $.ajax({
        url: $(this).attr("action"),
        data: data,
        contentType: false,
        processData: false,
        type: $(this).attr("method"),
        success: function (response) {
            try {
                var result = JSON.parse(response);
                if (result.success) {
                    window.location.href = result.url;
                } else {
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
            } catch (exception) {
                $.notify("You are logged out of the portal!<br>Please use a new tab to login and try again.", {
                    type: "warning",
                    allow_dismiss: true,
                    showProgressbar: false,
                    placement: {
                        from: "bottom",
                        align: "right"
                    }
                });
            }
        },
        complete: function () {
            l.stop();
        }
    });
});

$(document).on("click", "#logout", function (e) {
    e.preventDefault();

    $.ajax({
        url: $(this).data("action"),
        contentType: false,
        processData: false,
        type: $(this).data("method"),
        success: function (response) {
            var result = JSON.parse(response);
            if (result.success) {
                window.location.href = result.url;
            }
        }
    });
});
    