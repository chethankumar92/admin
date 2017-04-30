jQuery.each(["get", "post", "put", "delete"], function (i, method) {
    jQuery[method] = function (url, data, callback, type) {
        if (jQuery.isFunction(data)) {
            type = type || callback;
            callback = data;
            data = undefined;
        }

        return jQuery.ajax({
            url: url,
            type: method,
            dataType: type,
            data: data,
            success: function (response) {
                try {
                    var data = jQuery.parseJSON(response);
                    callback(data);
                } catch (exception) {
                    console.log(exception);
                }
            }
        });
    };
});