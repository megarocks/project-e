(function () {
    var ctrlName = "payment"; //define controller name here
    $(document).ready(function () {
        $('#payments-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "po_num"},
                {data: "periods"},
                {data: "amount"},
                {data: "currency"},
                {data: "payer_email"},
                {data: "method"},
                {
                    "data": "id",
                    "orderable": false,
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/view/' + id + '" title="View Details" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update?id=' + id + '" title="Delete" data-pjax="0"><span class="glyphicon glyphicon-remove"></span></a>';
                    }

                }
            ]
        });
    });
}());