/**
 * Created by rocks on 7/30/14.
 */
(function () {
    var ctrlName = "purchase-order"; //define controller name here
    $(document).ready(function () {
        $('#po-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list?fields=id,created_at,po_num,system_sn',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "po_num"},
                {data: "system_sn"},
                {
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/view/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ';
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