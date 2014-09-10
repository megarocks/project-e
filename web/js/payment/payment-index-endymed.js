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
                    return actionIcons(user, id);
                },
                "class": "text-center"

            }
        ],
        "order": [
            [ 0, "desc" ]
        ]
    });

    function actionIcons(user, entryId) {
        var iconsHtmlString = "";
        if (user.can('view') + ctrlName.capitalize) {
            iconsHtmlString += '<a href="/' + ctrlName + '/' + entryId + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp';
        }
        if (user.can('update') + ctrlName.capitalize) {
            iconsHtmlString += '<a href="/' + ctrlName + '/update?id=' + entryId + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp';
        }
        if (user.can('delete') + ctrlName.capitalize) {
            iconsHtmlString += '<a href="/' + ctrlName + '/delete?id=' + entryId + '" title="Delete" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>';
        }
        return iconsHtmlString;
    }

};
