/**
 * Created by rocks on 7/30/14.
 */
(function () {
    $(document).ready(function () {
        $('#systems-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/rest/systems',
                "dataSrc": ""
            },
            "columns": [
                {data: "sn"},
                {data: "po"},
                {data: "email"},
                {data: "status"},
                {data: "next_lock_date"},
                {data: "distributortitle"},
                {data: "endusertitle"},
            ],
            "columnDefs": [
                {
                    "targets": 7,
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/systems/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/systems/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> ' +
                            '<a href="/systems/delete?id=' + id + '" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>'
                    }
                }
            ]
        });
    });
}());