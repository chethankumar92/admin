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
});

$(document).on("submit", "form[data-parsley-validate]", function (e) {
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
    