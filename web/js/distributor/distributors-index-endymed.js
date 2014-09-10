/**
 * Created by rocks on 7/30/14.
 */
(function () {
    var ctrlName = "distributor"; //define controller name here
    $(document).ready(function () {
        $('#distributors-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "title"},
                {data: "email"},
                {data: "country"},
                {
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> ';
                    },
                    "orderable": false,
                    "class": "text-center"
                }
            ],
            "order": [
                [ 0, "desc" ]
            ]
        });
    });
}());