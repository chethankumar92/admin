    $(document).ready(function (e) {
        $('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $(document).on("submit", "#login-form", function (e) {
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