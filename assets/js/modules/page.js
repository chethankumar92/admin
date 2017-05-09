$(document).ready(function (e) {
    if ($("#page-manage-table").length > 0) {
        window.adminUserManageTable = $("#page-manage-table").DataTable({
            dom: '<"col-sm-6"l><"col-sm-6"f><"col-sm-6"i><"col-sm-6"p>rTt',
            serverSide: true,
            ajax: {
                url: $("#page-manage-table").data("render-url"),
                type: 'POST'
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            "aoColumnDefs": [{
                    mRender: function (data, type, row) {
                        var parser = new DOMParser();
                        var dom = parser.parseFromString(data, 'text/html');
                        return dom.body.textContent;
                    },
                    "aTargets": [2]
                }
            ]
        });
    }
});