var initScreen = function (user) {
    var ctrlName = "end-user";

    $('#end-users-table').dataTable({
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
                    return actionIcons(user, id, {
                        "view": true,
                        "update": true,
                        "delete": true
                    });
                },
                "orderable": false,
                "class": "text-center"
            }
        ],
        "order": [
            [ 0, "desc" ]
        ]
    });

    function actionIcons(user, entryId, options) {
        var iconsHtmlString = "";
        if ((options.view) && (user.can('viewEndUser'))) {
            iconsHtmlString += '<a href="/' + ctrlName + '/' + entryId + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp';
        }
        if ((options.update) && (user.can('updateEndUser'))) {
            iconsHtmlString += '<a href="/' + ctrlName + '/update?id=' + entryId + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp';
        }
        if ((options.delete) && (user.can('deleteEndUser'))) {
            iconsHtmlString += '<a href="#" title="Delete" requestLink="/' + ctrlName + '/delete/' + entryId + '"><span class="delete-button glyphicon glyphicon-trash"></span></a>';
        }
        return iconsHtmlString;
    }

};
