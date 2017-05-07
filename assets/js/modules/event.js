$(document).ready(function (e) {
    if ($(".dropzone").length > 0) {
        Dropzone.autoDiscover = false;
        window.eventImages = {};

        window.eventDz = $("#dZUpload").dropzone({
            url: "http://127.0.0.1/admin/index.php/Events/upload",
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
                    window.eventImages[mockFile.name, mockFile]
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
                }
            },
            removedfile: function (file) {
                $.post("http://127.0.0.1/admin/index.php/Events/remove", {
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