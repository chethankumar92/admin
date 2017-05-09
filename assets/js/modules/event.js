$(document).ready(function (e) {
    if ($("#dZUpload").length > 0) {
        var dzData = $("#dZUpload").data();
        Dropzone.autoDiscover = false;
        window.eventImages = {};

        window.eventDz = $("#dZUpload").dropzone({
            url: dzData.upload,
            uploadMultiple: true,
            parallelUploads: 25,
            maxFiles: 25,
            maxFilesize: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function () {
                var _ref = this;
                var mockFiles = $('[name=images]').data("images");
                $.each(mockFiles, function (index, mockFile) {
                    window.eventImages[mockFile.name] = {
                        file_name: mockFile.name,
                        file_id: mockFile.eiid
                    };
                    $('[name=images]').val(JSON.stringify(window.eventImages));
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
                    window.eventImages[result.data.file_name] = {
                        file_name: result.data.file_name
                    };
                    $('[name=images]').val(JSON.stringify(window.eventImages));
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
                        delete window.eventImages[file.name];
                        $('[name=images]').val(JSON.stringify(window.eventImages));
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

    if ($("#event-manage-table").length > 0) {
        window.eventManageTable = $("#event-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#event-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
});