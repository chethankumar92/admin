$(document).ready(function (e) {

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
    