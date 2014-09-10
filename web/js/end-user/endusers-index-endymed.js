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
                    return actionIcons(user, id);
                },
                "orderable": false,
                "class": "text-center"
            }
        ],
        "order": [
            [ 0, "desc" ]
        ]
    });

    function actionIcons(user, entryId) {
        var iconsHtmlString = "";
        if (user.can('viewEndUser')) {
            iconsHtmlString += '<a href="/' + ctrlName + '/' + entryId + '" title="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp';
        }
        if (user.can('updateEndUser')) {
            iconsHtmlString += '<a href="/' + ctrlName + '/update?id=' + entryId + '" title="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp';
        }
        if (user.can('deleteEndUser')) {
            iconsHtmlString += '<a href="/' + ctrlName + '/delete?id=' + entryId + '" title="Delete" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>';
        }
        return iconsHtmlString;
    }

};
