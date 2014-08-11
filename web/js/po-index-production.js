/**
 * Created by rocks on 7/30/14.
 */
(function () {
    var ctrlName = "purchase-order"; //define controller name here
    $(document).ready(function () {
        $('#systems-po-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list?fields=id,created_at,po_num,system_sn',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "po_num"},
                {data: "system_sn"}
            ],
            "columnDefs": [
                {
                    "targets": 3,
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/view/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>'
                    }
                }
            ]
        });
    });
}());