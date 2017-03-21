    $(document).ready(function (e) {
        
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
    