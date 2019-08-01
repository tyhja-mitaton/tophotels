"use strict";

if (typeof document.app === 'undefined') {
    document.app = {};
}

document.app.ColumnList = new (function () {
    /**
     *
     * @param project
     * @param callback
     */
    this.getAll = function(project, callback) {
        $.ajax({
            async: true,
            url: '//' + document.location.hostname + '/map/columns/json-' + project,
            data: {},
            type: "POST",
            success: function(data) {
                callback(data);
            }
        });
    };
})();

