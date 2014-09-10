var initScreen = function (user) {
    var ctrlName = "user"; //define controller name here
    $(document).ready(function () {
        $('#users-table').dataTable({
            "deferRender": true,
            "ajax": {
                "url": '/' + ctrlName + '/list',
                "dataSrc": ""
            },
            "columns": [
                {data: "created_at"},
                {data: "first_name"},
                {data: "last_name"},
                {data: "email"},
                {data: "role"},
                {
                    "data": "id",
                    "sortable": false,
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
}