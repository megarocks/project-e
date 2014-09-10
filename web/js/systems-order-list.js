/**
 * Created by rocks on 7/30/14.
 */
(function () {
    var ctrlName = "system"; //define controller name here
    $(document).ready(function () {
        $('#systems-po-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/purchase-order/list?fields=id,created_at,po_num,system_sn',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "po_num"},
                {data: "system_sn"},
                {
                    "data": "id",
                    "sortable": false,
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/view-order/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update-order?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>'
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