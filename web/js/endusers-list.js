/**
 * Created by rocks on 7/30/14.
 */
(function () {
    $(document).ready(function () {
        $('#end-users-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/rest/endusers',
                "dataSrc": ""
            },
            "columns": [
                {data: "title"},
                {data: "email"}
            ],
            "columnDefs": [
                {
                    "targets": 2,
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/ensusers/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/ensusers/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> ' +
                            '<a href="/ensusers/delete?id=' + id + '" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post"                         data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>'
                    }
                }
            ]
        });
    });
}());