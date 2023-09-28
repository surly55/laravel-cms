$(function() {
    $('#widgetTemplate').on('change', function() {
        switch($(this).val()) {
            case 'grid':
                $('#templateOptionsSlider').hide();
                $('#templateOptionsGrid').show();
                break;
            case 'slider':
                $('#templateOptionsGrid').hide();
                $('#templateOptionsSlider').show();
                break;
        }
    });
});