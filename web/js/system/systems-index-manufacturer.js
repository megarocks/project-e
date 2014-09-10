/**
 * Created by rocks on 7/30/14.
 */
(function () {
    $(document).ready(function () {
        $('#systems-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/system/list',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "sn"},
                {data: "po_num"},
                {data: "status"},
                {
                    "data": "id",
                    "orderable": false,
                    "render": function (id) {
                        return '<a href="/system/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-cog"></span></a> '
                    },
                    "class": "text-center"
                }

            ],
            "order": [
                [ 0, "desc" ]
            ]
        });
    });
}());