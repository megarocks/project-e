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
                {data: "title"},
                {data: "email"},
                {data: "country"}
            ],
            "columnDefs": [
                {
                    "targets": 3,
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> ' +
                            '<a href="/' + ctrlName + '/delete?id=' + id + '" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>'
                    }
                }
            ]
        });
    });
}());