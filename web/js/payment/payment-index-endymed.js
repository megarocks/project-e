var initScreen = function (user) {
    var ctrlName = "payment";

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
            {data: "currency_code"},
            {data: "payer_email"},
            {data: "method"},
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
        if ((options.view) && (user.can('view' + ctrlName.capitalize()))) {
            iconsHtmlString += '<a href="/' + ctrlName + '/' + entryId + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp';
        }
        if ((options.update) && (user.can('update' + ctrlName.capitalize()))) {
            iconsHtmlString += '<a href="/' + ctrlName + '/update?id=' + entryId + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp';
        }
        if ((options.delete) && (user.can('delete' + ctrlName.capitalize()))) {
            iconsHtmlString += '<a href="#" title="Delete" requestLink="/' + ctrlName + '/delete/' + entryId + '"><span class="delete-button glyphicon glyphicon-trash"></span></a>';
        }
        return iconsHtmlString;
    }

};
