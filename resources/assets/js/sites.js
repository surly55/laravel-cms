var updateRow;

$(function() {
    // Options
    $('#optionActions button[data-action="add"], #optionActions button[data-action="save"]').on('click', function() {
        var action = $(this).data('action');
        var name = $('#optionName').val().trim();
        var locale = $('#optionLocale').val();
        var localeName = $('#optionLocale option:selected').text();
        var value = $('#optionValue').val().trim();

        if(name.length == 0 || value.length == 0) {
            return;
        }

        var optionRow = '<tr> \
            <td>' + name + '<input type="hidden" name="options[name][]" value="' + name + '" data-name="name"></td> \
            <td>' + localeName + '<input type="hidden" name="options[locale][]" value="' + locale + '" data-name="locale"></td> \
            <td>' + value + '<input class="form-control" type="hidden" name="options[value][]" value="' + value + '" data-name="value"></td> \
            <td> \
                <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
            </td> \
        </tr>';

        $('#tableOptions tr.no-options').hide();
        if(action == 'add') {
            $('#tableOptions').append(optionRow);
        } else if(action == 'save') {
            updateRow.replaceWith(optionRow);
        }

        $('#optionName, #optionValue').val('');
        $('#optionLocale').prop('selectedIndex', 0);
        $('#optionName').focus();

        if(action == 'save') {
            $('#optionActions button[data-action="save"], #optionActions button[data-action="reset"]').hide();
            $('#optionActions button[data-action="add"]').show();
            $('#tableOptions .btn-remove, #tableOptions .btn-edit').attr('disabled', false);
        }
    });

    $('#optionActions button[data-action="reset"]').on('click', function() {
        updateRow = null;
        $('#optionName, #optionValue').val('');
        $('#optionLocale').prop('selectedIndex', 0);
        $('#optionName').focus();
        $('#optionActions button[data-action="save"], #optionActions button[data-action="reset"]').hide();
        $('#optionActions button[data-action="add"]').show();
        $('#tableOptions .btn-remove, #tableOptions .btn-edit').attr('disabled', false);
    });

    $('#tableOptions').on('click', 'button.btn-edit', function() {
        if(updateRow) {
            $('.btn-edit', updateRow).attr('disabled', false);
        }
        updateRow = $(this).closest('tr');
        updateRow.find('input').each(function() {
            var name = $(this).data('name');
            if(name !== undefined) {
                switch(name) {
                    case 'name':
                        $('#optionName').val($(this).val());
                        break;
                    case 'locale':
                        $('#optionLocale').val($(this).val());
                        break;
                    case 'value':
                        $('#optionValue').val($(this).val());
                        break;
                }
            }
        });
        $('#optionActions button[data-action="add"]').hide();
        $('#optionActions button[data-action="save"], #optionActions button[data-action="reset"]').show();
        $('#tableOptions .btn-remove').attr('disabled', true);
        $('.btn-edit', updateRow).attr('disabled', true);
    });

    $('#regionName').on('input', function() {
        var regionId = $(this).val().trim();
        if(regionId.length > 0) {
            regionId = regionId.toLowerCase().replace(/[^a-z0-9_]/gi, '_').replace(/_+/g, '_').replace(/^_|_$/g, '');
        }
        $('#regionId').val(regionId);
    });

    $('#addRegion').on('click', function() {
        $('.box-site-layout .form-region .form-group').removeClass('has-error');

        var regionName = $('#regionName').val().trim();
        if(regionName.length == 0) {
            console.log('Region name is missing!');
            $('#regionName').val('').focus().tooltip({
                title: 'Region name is required!',
                delay: { 'hide': 100 }
            }).tooltip('show').parent().addClass('has-error');
            return;
        }

        var regionId = $('#regionId').val().trim();
        if(regionId.length == 0) {
            console.log('Region ID is missing!');
            $('#regionId').val('').focus().tooltip({
                title: 'Region ID is required!',
                delay: { 'hide': 100 }
            }).tooltip('show').parent().addClass('has-error');
            return;
        }

        if(!/^[a-z0-9_]+$/i.test(regionId)) {
            console.log('Region ID is incorrect!');
            $('#regionId').val('').focus().tooltip({
                title: 'Region ID can only contain alphanumeric characters and underscores!',
                delay: { 'hide': 100 }
            }).tooltip('show').parent().addClass('has-error');
            return;
        }

        $('#tableRegions tr.no-regions').hide();
        $('#tableRegions').append('<tr> \
            <td><input class="form-control" type="hidden" name="layout[regions][name][]" value="' + regionName + '">' + regionName + '</td> \
            <td><input class="form-control" type="hidden" name="layout[regions][id][]" value="' + regionId + '">' + regionId + '</td> \
            <td><button type="button" class="btn btn-xs btn-default btn-update" data-action="edit">Edit</button> <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td> \
        </tr>');

        $('#regionName, #regionId').val('');
        $('#regionName').focus();
    });

    $('#tableOptions, #tableRegions, #tableWidgets, #tableLocales').on('click', 'button.btn-remove', function() {
        $(this).closest('tr').remove();
    });

    $('#tableRegions').on('click', 'button.btn-update', function() {
        $(this).toggleClass('btn-default btn-success');
        switch($(this).data('action')) {
            case 'edit':
                $(this).text('Save').data('action', 'save').closest('tr').find('input').each(function() {
                    $(this).closest('td').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                    $(this).attr('type', 'text');
                });
                break;
            case 'save':
                $(this).text('Edit').data('action', 'edit').closest('tr').find('input').each(function() {
                    $(this).attr('type', 'hidden').closest('td').append($(this).val());
                });
        }
    });

    // Widgets
    var widgets = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/widget/lookup/%QUERY',
            wildcard: '%QUERY'
        }
    });
    widgets.initialize();

    $('#widgetLookup.typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    }, {
        name: 'widgets',
        displayKey: 'name',
        source: widgets.ttAdapter(),
        limit: 10,
    });
    $('#widgetLookup.typeahead').on('typeahead:selected', function(el, selection, dataset) {
        $('#widgetId').val(selection._id);
    });

    $('#widgetActions button[data-action="add"], #widgetActions button[data-action="save"]').on('click', function() {
        var action = $(this).data('action');
        var id = $('#widgetId').val();
        var name = $('#widgetLookup').val().trim();
        var locale = $('#widgetLocale').val();
        var localeName = $('#widgetLocale option:selected').text();
        var region = $('#widgetRegion').val();
        var regionName = $('#widgetRegion option:selected').text();
        var weight = $('#widgetWeight').val();

        var widgetRow = '<tr> \
            <td>' + name + '<input type="hidden" name="widgets[widget][]" value="' + id + '" data-name="widget" data-widget="' + name + '"></td> \
            <td>' + localeName + '<input type="hidden" name="widgets[locale][]" value="' + locale + '" data-name="locale"></td> \
            <td>' + regionName + '<input type="hidden" name="widgets[region][]" value="' + region + '" data-name="region"></td> \
            <td>' + weight + '<input class="form-control" type="hidden" name="widgets[weight][]" value="' + weight + '" data-name="weight"></td> \
            <td> \
                <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
            </td> \
        </tr>';

        $('#tableWidgets tr.no-widgets').hide();
        if(action == 'add') {
            $('#tableWidgets').append(widgetRow);
        } else if(action == 'save') {
            updateRow.replaceWith(widgetRow);
        }

        $('#widgetLookup').typeahead('val', '');
        $('#widgetId').val('');
        $('#widgetLocale, #widgetRegion').prop('selectedIndex', 0);
        $('#widgetWeight').val('50');        
        $('#widgetLookup').focus();

        if(action == 'save') {
            $('#widgetActions button[data-action="save"], #widgetActions button[data-action="reset"]').hide();
            $('#widgetActions button[data-action="add"]').show();
            $('#tableWidgets .btn-remove, #tableWidgets .btn-edit').attr('disabled', false);
        }
    });

    $('#widgetActions button[data-action="reset"]').on('click', function() {
        updateRow = null;
        $('#widgetLookup').typeahead('val', '');
        $('#widgetId').val('');
        $('#widgetLocale, #widgetRegion').prop('selectedIndex', 0);
        $('#widgetWeight').val('50');        
        $('#widgetLookup').focus();
        $('#widgetActions button[data-action="save"], #widgetActions button[data-action="reset"]').hide();
        $('#widgetActions button[data-action="add"]').show();
        $('#tableWidgets .btn-remove, #tableWidgets .btn-edit').attr('disabled', false);
    });

    $('#tableWidgets').on('click', 'button.btn-edit', function() {
        if(updateRow) {
            $('.btn-edit', updateRow).attr('disabled', false);
        }
        updateRow = $(this).closest('tr');
        updateRow.find('input').each(function() {
            var name = $(this).data('name');
            if(name !== undefined) {
                switch(name) {
                    case 'widget':
                        $('#widgetId').val($(this).val());
                        $('#widgetLookup').typeahead('val', $(this).data('widget'));
                        break;
                    case 'locale':
                        $('#widgetLocale').val($(this).val());
                        break;
                    case 'region':
                        $('#widgetRegion').val($(this).val());
                        break;
                    case 'weight':
                        $('#widgetWeight').val($(this).val());
                        break;
                }
            }
        });
        $('#widgetActions button[data-action="add"]').hide();
        $('#widgetActions button[data-action="save"], #widgetActions button[data-action="reset"]').show();
        $('#tableWidgets .btn-remove').attr('disabled', true);
        $('.btn-edit', updateRow).attr('disabled', true);
    });

    // Locales
    $('#localeLocale').on('change', function() {
        if($(this).val() != '0') {
            var selected = $('option:selected', this);
            $('#localeName').val(selected.data('name'));
            $('#localeId').val(selected.data('code'));
        }
    });

    $('#localeActions button[data-action="add"]').on('click', function() {
        var locale = $('#localeLocale').val();
        var localeName = $('#localeLocale option:selected').text();
        var name = $('#localeName').val();
        var type = $('#localeType').val();
        var typeName = $('#localeType option:selected').text();
        var id = $('#localeId').val();
        var active = $('#localeActive').is(':checked') ? 1 : 0;
        var activeText = active ? 'yes' : 'no';

        $('#tableLocales tr.no-locales').hide();
        $('#tableLocales').append('<tr> \
            <td><input class="form-control" type="hidden" name="locales[name][]" value="' + name + '" data-name="name">' + name + '</td> \
            <td><input class="form-control" type="hidden" name="locales[locale][]" value="' + locale + '" data-name="locale">' + localeName + '</td> \
            <td><input class="form-control" type="hidden" name="locales[type][]" value="' + type + '" data-name="type">' + typeName + '</td> \
            <td><input class="form-control" type="hidden" name="locales[id][]" value="' + id + '" data-name="id">' + id + '</td> \
            <td><input class="form-control" type="hidden" name="locales[active][]" value="' + active + '" data-name="active">' + activeText + '</td> \
            <td> \
                <button type="button" class="btn btn-xs btn-default btn-edit" data-action="edit">Edit</button> \
                <button type="button" class="btn btn-xs btn-danger btn-remove" data-action="remove">Remove</button> \
            </td> \
        </tr>');

        $('#localeLocale').val('0');
        $('#localeType').val('url_prefix');
        $('#localeName, #localeId').val('');
    });

    $('#localeActions button[data-action="save"]').on('click', function() {
        var locale = $('#localeLocale').val();
        var localeName = $('#localeLocale option:selected').text();
        var name = $('#localeName').val();
        var type = $('#localeType').val();
        var typeName = $('#localeType option:selected').text();
        var id = $('#localeId').val();
        var active = $('#localeActive').is(':checked') ? 1 : 0;
        var activeText = active ? 'yes' : 'no';

        $(updateRow).replaceWith('<tr> \
            <td><input class="form-control" type="hidden" name="locales[name][]" value="' + name + '" data-name="name">' + name + '</td> \
            <td><input class="form-control" type="hidden" name="locales[locale][]" value="' + locale + '" data-name="locale">' + localeName + '</td> \
            <td><input class="form-control" type="hidden" name="locales[type][]" value="' + type + '" data-name="type">' + typeName + '</td> \
            <td><input class="form-control" type="hidden" name="locales[id][]" value="' + id + '" data-name="id">' + id + '</td> \
            <td><input class="form-control" type="hidden" name="locales[active][]" value="' + active + '" data-name="active">' + activeText + '</td> \
            <td> \
                <button type="button" class="btn btn-xs btn-default btn-edit" data-action="edit">Edit</button> \
                <button type="button" class="btn btn-xs btn-danger btn-remove" data-action="remove">Remove</button> \
            </td> \
        </tr>');

        $('#localeLocale').val('0');
        $('#localeType').val('url_prefix');
        $('#localeName, #localeId').val('');
        $('#localeActions button[data-action="save"], #localeActions button[data-action="reset"]').hide();
        $('#localeActions button[data-action="add"]').show();
        $('#tableLocales .btn-remove, #tableLocales .btn-edit').show();
    });

    $('#localeActions button[data-action="reset"]').on('click', function() {
        updateRow = null;
        $('#localeLocale').val('0');
        $('#localeType').val('url_prefix');
        $('#localeName, #localeId').val('');
        $('#localeActions button[data-action="save"], #localeActions button[data-action="reset"]').hide();
        $('#localeActions button[data-action="add"]').show();
        $('#tableLocales .btn-remove, #tableLocales .btn-edit').show();
    });

    $('#tableLocales').on('click', 'button.btn-edit', function() {
        updateRow = $(this).closest('tr');
        updateRow.find('input').each(function() {
            var name = $(this).data('name');
            if(name !== undefined) {
                switch(name) {
                    case 'name':
                        $('#localeName').val($(this).val());
                        break;
                    case 'locale':
                        $('#localeLocale').val($(this).val());
                        break;
                    case 'type':
                        $('#localeType').val($(this).val());
                        break;
                    case 'id':
                        $('#localeId').val($(this).val());
                        break;
                    case 'active':
                        if($(this).val() == '1') {
                            $('#localeActive').prop('checked', true);
                        } else {
                            $('#localeActive').prop('checked', false);
                        }
                        break;
                }
            }
        });
        $('#localeActions button[data-action="add"]').hide();
        $('#localeActions button[data-action="save"], #localeActions button[data-action="reset"]').show();
        $('#tableLocales .btn-remove').hide();
        $('.btn-edit', updateRow).hide();
    });
});