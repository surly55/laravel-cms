function getMenus(site, locale) {
    $.get('/menu', { site: site, locale: locale }, function(data) {
        $('#widgetMenu').find('option').remove();
        if(data.menus.length == 0) {
            $('#widgetMenu').hide();
            $('.widget-menu p.no-menus').show();
        } else {
            for(var i = 0; i < data.menus.length; i++) {
                $('#widgetMenu').append('<option value="' + data.menus[i]['_id'] + '">' + data.menus[i]['title'] + '</option>');
                if(data.menus[i]['_id'] == $('#widgetMenu').data('menu')) {
                    $('#widgetMenu').val(data.menus[i]['_id']);
                }
            }
            $('.widget-menu p.no-menus').hide();
            $('#widgetMenu').show();
        }
    });
}
$(function() {
    getMenus($('#site_id').val(), $('#locale').val());

    $('#site_id, #locale').on('change', function() {
        getMenus($('#site_id').val(), $('#locale').val());
    });
});