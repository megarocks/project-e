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
                    "data": "country",
                    "render": function (country) {
                        return (country) ? country.name : null;
                    }
                },
                {
                    "data": "distributor",
                    "render": function (distributor) {
                        return (distributor) ? distributor.title : null;
                    }
                },
                {
                    "data": "endUser",
                    "render": function (endUser) {
                        return (endUser) ? endUser.title : null;
                    }
                },
                {
                    "data": "id",
                    "orderable": false,
                    "render": function (id) {
                        return '<a href="/system/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-cog"></span></a> '
                    }
                }

            ]
        });
    });
}());