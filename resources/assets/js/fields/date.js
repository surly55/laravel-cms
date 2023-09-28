Fields.date = {
    init: function(id, options) {
        options = options || {};
        $('#' + id).datepicker(options);
    }
}