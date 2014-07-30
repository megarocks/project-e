/**
 * Created by rocks on 7/30/14.
 */
(function () {
    $(document).ready(function () {
        $('#example-table').dataTable({
            "ajax": {
                "url": '/rest/systems',
                "dataSrc": ""
            },
            "columns": [
                {data: "sn"},
                {data: "po"},
                {data: "email"},
                {data: "status"},
                {data: "next_lock_date"},
                {data: "distributortitle"},
            ]
        });
    });
}());