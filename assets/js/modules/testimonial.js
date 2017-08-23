$(document).ready(function (e) {
    if ($("#dZUpload").length > 0) {
        var dzData = $("#dZUpload").data();
        Dropzone.autoDiscover = false;
        window.testimonialImages = {};

        window.testimonialDz = $("#dZUpload").dropzone({
            url: dzData.upload,
            uploadMultiple: false,
            maxFilesize: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function () {
                var _ref = this;
                var mockFiles = $('[name=images]').data("images");
                $.each(mockFiles, function (index, mockFile) {
                    window.testimonialImages[mockFile.name] = {
                        file_name: mockFile.name
                    };
                    $('[name=images]').val(JSON.stringify(window.testimonialImages));
                    _ref.emit("addedfile", mockFile);
                    _ref.files.push(mockFile);
                    _ref.createThumbnailFromUrl(mockFile, mockFile.url, function () {
                        _ref.emit("complete", mockFile);
                    }, "dropzoneInit");
                });
            },
            success: function (file, response) {
                var result = JSON.parse(response);
                if (result.success) {
                    window.testimonialImages[result.data.file_name] = {
                        file_name: result.data.file_name
                    };
                    $('[name=images]').val(JSON.stringify(window.testimonialImages));
                } else {
                    file.previewElement.remove();
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
            },
            removedfile: function (file) {
                $.post(dzData.remove, {
                    image: {
                        file_name: file.name,
                        file_id: file.eiid
                    }
                }, function (response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        file.previewElement.remove();
                        delete window.testimonialImages[file.name];
                        $('[name=images]').val(JSON.stringify(window.testimonialImages));
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
                });
            }
        });
    }
});