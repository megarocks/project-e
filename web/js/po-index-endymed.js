(function () {
    var ctrlName = "purchase-order"; //define controller name here
    $(document).ready(function () {
        $('#po-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list?fields=id,created_at,po_num,system_sn,ctpl,dtpl,nop,npl,country,distributor,endUser',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "po_num"},
                {data: "system_sn"},
                {data: "ctpl"},
                {data: "dtpl"},
                {data: "nop"},
                {data: "npl"}
            ],
            "columnDefs": [
                {
                    "targets": 10,
                    "data": "id",
                    "render": function (id) {
                        return '<a href="/' + ctrlName + '/view/' + id + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> ' +
                            '<a href="/' + ctrlName + '/update?id=' + id + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>' +
                            '<a href="/' + ctrlName + '/delete?id=' + id + '" title="Delete" data-pjax="0"><span class="glyphicon glyphicon-remove"></span></a>';
                    }
                },
                {
                    "targets": 7,
                    "data": "country",
                    "render": function (country) {
                        return (country) ? country.name : null;
                    }
                },
                {
                    "targets": 8,
                    "data": "distributor",
                    "render": function (distributor) {
                        return (distributor) ? distributor.title : null;
                    }
                },
                {
                    "targets": 9,
                    "data": "endUser",
                    "render": function (endUser) {
                        return (endUser) ? endUser.title : null;
                    }
                }

            ]
        });
    });
}());