/**
 * Created by rocks on 8/14/14.
 */
(function () {
    var ctrlName = "user"; //define controller name here
    $(document).ready(function () {
        $('#users-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "first_name"},
                {data: "last_name"},
                {data: "email"},
                {data: "role"},
                {
                    "data": "id",
                    "sortable": false,
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/view/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>'
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