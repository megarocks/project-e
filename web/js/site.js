$(document).ready(function () {
    $.post("/site/permissions-json", function (data) {
        user.permissions = data;
        if (typeof (initScreen) == "function") {
            initScreen(user);
        }
    });

    var user = {
        permissions: [],
        can: function (permissionName) {
            return this.permissions.indexOf(permissionName) > -1;
        }
    }
});

String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}


