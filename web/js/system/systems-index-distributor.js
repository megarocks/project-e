var initScreen = function (user) {
    var ctrlName = "system";

    $('#systems-table').dataTable({
        "deferRender": true,
        "ajax": {
            "url": '/' + ctrlName + '/list',
            "dataSrc": ""
        },
        "columns": [
            {data: "sn"},
            {data: "po_num"},
            {data: "status"},
            {data: "login_code"},
            {data: "init_lock_date"},
            {data: "next_lock_date"},
            {data: "dtpl"},
            {data: "ctpl"},
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
            [ 5, "asc" ]
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
