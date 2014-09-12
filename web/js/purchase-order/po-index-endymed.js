var initScreen = function (user) {
    var ctrlName = "purchase-order";

    $('#po-table').dataTable({
        "deferRender": true,
        "ajax": {
            "url": '/' + ctrlName + '/list?fields=id,created_at,po_num,system_sn,ctpl,dtpl,nop,cnpl,dnpl,country,distributor,endUser',
            "dataSrc": ""
        },
        "columns": [
            {data: "created_at"},
            {data: "po_num"},
            {data: "system_sn"},
            {data: "ctpl"},
            {data: "dtpl"},
            {data: "nop"},
            {data: "cnpl"},
            {data: "dnpl"},
            {
                data: "country",
                "render": function (country) {
                    return (country) ? country.name : null;
                }
            },
            {
                "data": "distributor",
                "render": function (distributor) {
                    return (distributor) ? distributor.title : null;
                }
            },
            {
                "data": "endUser",
                "render": function (endUser) {
                    return (endUser) ? endUser.title : null;
                }
            },
            {
                "data": "id",
                "orderable": false,
                "render": function (id) {
                    return actionIcons(user, id, {
                        "view": true,
                        "update": false,
                        "delete": false
                    });
                },
                "class": "text-center"

            }
        ],
        "order": [
            [ 0, "desc" ]
        ]
    });

    function actionIcons(user, entryId, options) {
        var iconsHtmlString = "";
        if ((options.view) && (user.can('viewPurchaseOrder'))) {
            iconsHtmlString += '<a href="/' + ctrlName + '/' + entryId + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp';
        }
        if ((options.update) && (user.can('updatePurchaseOrder'))) {
            iconsHtmlString += '<a href="/' + ctrlName + '/update?id=' + entryId + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp';
        }
        if ((options.delete) && (user.can('deletePurchaseOrder'))) {
            iconsHtmlString += '<a href="#" title="Delete" requestLink="/' + ctrlName + '/delete/' + entryId + '"><span class="delete-button glyphicon glyphicon-trash"></span></a>';
        }
        return iconsHtmlString;
    }
};
