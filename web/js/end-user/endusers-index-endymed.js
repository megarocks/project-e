/**
 * Created by rocks on 7/30/14.
 */
(function () {
    $(document).ready(function () {
        $('#end-users-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/end-user/list',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "title"},
                {data: "email"},
                {data: "country"}
            ],
            "columnDefs": [
                {
                    "targets": 4,
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/end-user/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/end-user/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
                        //'<a href="/ensusers/delete?id=' + id + '" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>'
                    }
                }
            ]
        });
    });
}());