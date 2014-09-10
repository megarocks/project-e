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
                {data: "sn"},
                {data: "po_num"},
                {data: "status"},
                {data: "next_lock_date"},
                {data: "current_code"},
                {data: "ctpl"},
                {data: "npl"},
                {
                    "data": "id",
                    "sortable": false,
                    "render": function (id) {
                        return '<a href="/system/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-cog"></span></a> '
                    },
                    "class": "text-center"
                }
            ]
        });
    });
}());