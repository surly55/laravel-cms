$(function() {
    $('#formPageType').on('submit', function(e, force) {
        if(typeof force === 'undefined') {
            if($('input[name^=fields]').length === 0) {
                e.preventDefault();
                $('#modalNoFields').modal('show');
            }
        }
    });

    $('#modalNoFields #btnContinue').on('click', function(e) {
        $('form#formPageType').trigger('submit', [ true ]);
    });

    $('button#addField').on('click', function() {
        var field = $('#field').val();
        var fieldName = $('#field option:selected').text();
        var fieldLabel = $('#fieldLabel').val().trim();
        var fieldId = $('#fieldId').val().trim();
        var fieldRequired = $('#fieldRequired').is(':checked') | 0;
        var fieldRequiredText = $('#fieldRequired').is(':checked') ? 'yes' : 'no';

        if(fieldLabel !== '' && fieldId !== '') {
            $('#tableFields tbody').append('<tr>'
                + '<td><i class="fa fa-arrows-v handle"></i> ' + fieldName + '<input name="fields[' + fieldId + '][field]" type="hidden" value="' + field + '"></td>'
                + '<td>' + fieldLabel + '<input name="fields[' + fieldId + '][label]" type="hidden" value="' + fieldLabel + '"></td>'
                + '<td>' + fieldId + '</td>'
                + '<td>' + fieldRequiredText + '<input name="fields[' + fieldId + '][required]" type="hidden" value="' + fieldRequired + '"></td>'
                + '<td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td>'
                + '</tr>');
            $('#fieldLabel, #fieldId').val('');
            $('#fieldRequired').attr('checked', false);
        }
    });

    $('#tableFields').on('click', 'button.btn-remove', function() {
        $(this).parents('tr').remove();
    });

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    $('#tableFields tbody').sortable({
        handle: '.handle',
        helper: fixHelper,
    });

    // Widgets
    $('#widgetLocale').on('change', function() {
        $('#widgetWidget').typeahead('val', '');
    });

    // Autocomplete for widgets
    var widgets = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/widget/lookup/%QUERY',
            wildcard: '%QUERY',
            replace: function(url, uriEncodedQuery) {
                var siteId = $('#site_id').val();
                var locale = $('#widgetLocale').val();
                return url.replace('%QUERY', uriEncodedQuery) + '?site=' + encodeURIComponent(siteId) + '&locales=' + encodeURIComponent(locale);
            }
        }
    });
    widgets.initialize();

    $('#widgetLookup.typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    }, {
        name: 'widgets',
        display: 'name',
        source: widgets.ttAdapter(),
        limit: 10,
    });
    $('#widgetLookup.typeahead').on('typeahead:selected', function(el, selection, dataset) {
        $('#widgetWidget').val(selection._id);
    });

    $('#addWidget').on('click', function() {
      
        var locale = $('#widgetLocale').val();
        var localeName = $('#widgetLocale option:selected').text();
        var template = $('#widgetTemplate').val();
        var templateName = $('#widgetTemplate option:selected').text();
        var region = $('#widgetRegion').val();
        var regionName = $('#widgetRegion option:selected').text();
        var widget = $('#widgetWidget').val();
        var widgetName = $('#widgetLookup').val();
        var weight = $('#widgetWeight').val();

        $('#tableWidgets').append('<tr> \
            <td>' + localeName + '<input name="widgets[locale][]" type="hidden" value="' + locale + '"></td> \
            <td>' + templateName + '<input name="widgets[template][]" type="hidden" value="' + template + '"></td> \
            <td>' + regionName + '<input name="widgets[region][]" type="hidden" value="' + region + '"></td> \
            <td>' + widgetName + '<input name="widgets[widget][]" type="hidden" value="' + widget + '"></td> \
            <td>' + weight + '<input name="widgets[weight][]" type="hidden" value="' + weight + '"></td> \
            <td> \
                <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
            </td> \
        <tr>')
    });

    $('#tableWidgets').on('click', 'button.btn-remove', function() {
        $(this).parents('tr').remove();
    });

    $('button.btn-select-all-locales').on('click', function() {
        $('#locales option').prop('selected', true);
        $('#locales').trigger('change');
    });

    $('#locales').on('change', function() {
        var locales = $(this).val();
        if(locales.length == 0) {
            $('.alert-no-locale').show();
            $('#widgetForm').hide();
        } else {
            $('.alert-no-locale').hide();
            $('#widgetForm').show();
            // Update locales
            $('#widgetLocale option').remove();
            for(var i = 0; i < locales.length; i++) {
                $('#widgetLocale').append('<option value="' + locales[i] + '">' + $('#locales option[value="' + locales[i] + '"]').text() + '</option>');
            }
        }
    });

    $('#templates').on('change', function() {
        var templates = $(this).val();
        if(templates.length == 0) {
            $('.alert-no-locale').show();
            $('#widgetForm').hide();
        } else {
            $('.alert-no-locale').hide();
            $('#widgetForm').show();
            // Update templates
            $('#widgetTemplate option').remove();
            for(var i = 0; i < templates.length; i++) {
                $('#widgetTemplate').append('<option value="' + templates[i] + '">' + $('#templates option[value="' + templates[i] + '"]').text() + '</option>');
            }
            $('#widgetTemplate').trigger('change');
        }
    });

    $('#widgetTemplate').on('change', function() {
        $('#widgetRegion option').remove();
        var template_id = $(this).val();
        for(var i = 0; i < templates[template_id].regions.length; i++) {
            $('#widgetRegion').append('<option value="' + templates[template_id].regions[i].id + '">' + templates[template_id].regions[i].name + '</option>');
        }
    });
});
