Fields = {};
var _templates = {};
var lastSelectedPageType = null;

function loadFields(pageType, page)
{
    console.log('Loading fields for ' + pageType);
    $.get(routeURL.replace('_id_', pageType), function(data) {
        if(data.error) {
            $('fieldset.fields').html(data.message);
            return;
        } else {
            $('fieldset.fields').html('');
            var requires = [];
            data.fields.forEach(function(f) {
                if(f.globals) {
                    for(k in f.globals) {
                        if(!window[k]) {
                            window[k] = f.globals[k];
                        }
                    }
                }
                requires = requires.concat(f.requires || []);
                if(f.style) {
                    for(var i = 0; i < f.style.length; i++) {
                        if(loadedStyles.indexOf(f.style[i]) < 0) {
                            $('head').append('<link rel="stylesheet" href="/css/' + f.style[i] + '.css">');
                            loadedStyles.push(f.style[i]);
                        }
                    }
                }
                $('fieldset.fields').append(f.html);
            });
            var trueRequires = requires.uniq().filter(function(r) { return loadedScripts.indexOf(r) < 0 });
            $.when.apply(null, trueRequires.map(function(r) { return $.getScriptCached('/js/' + r) })).done(function() {
                loadedScripts = loadedScripts.concat(trueRequires);
                data.fields.forEach(function(f) {
                    if(f.init) Fields[f.init].init(f.id, f.options || {});
                });
            });
        }
    });
}

var widgets = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/widget/lookup/%QUERY',
        wildcard: '%QUERY'
    }
});
widgets.initialize();

var pages = new Bloodhound({
    identify: function(obj) { return obj.url; },
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/page/lookup/?s=%QUERY',
        wildcard: '%QUERY'
    }
});
pages.initialize();

$(function() {
    if(typeof pageId === 'undefined') pageId = null;
    loadFields($('#type_id').val(), pageId);

    $('body.page-create #title').on('input', function() {
        $('#url').val(slugify($(this).val()));
    });

    $('body.model-edit #type_id').on('change', function() {
        $('#modalWarningType').modal('show');
    });

    $('body.model-create #type_id').on('change', function() {
        var site = $('#site_id').val();
        var locale = $('#locale').val();
        var pageType = $(this).val();
        loadFields(pageType, pageId);
        $('#template_id option').remove();
        for(var i = 0; i < sites[site].page_types.length; i++) {
            if(sites[site].page_types[i]._id == pageType) {
                for(var j = 0; j < sites[site].page_types[i].templates.length; j++) {
                    $('#template_id').append('<option value="' + sites[site].page_types[i].templates[j]._id + '">' + sites[site].page_types[i].templates[j].name + '</option>');
                }
                var template = $('#template_id').val();
                if(typeof sites[site].page_types[i].attached_widgets !== 'undefined' && sites[site].page_types[i].attached_widgets.length > 0) {
                    $('#tableWidgets tbody tr').remove();
                    for(var j = 0; j < sites[site].page_types[i].attached_widgets.length; j++) {
                        if(sites[site].page_types[i].attached_widgets[j].site_locale_id == locale && sites[site].page_types[i].attached_widgets[j].template_id == template) {
                            $('#tableWidgets tbody').append('<tr> \
                                <td><span class="widget-name">' + sites[site].page_types[i].attached_widgets[j].widget_name + '</span><input data-attr="id" name="widgets[' + sites[site].page_types[i].attached_widgets[j].widget_id + '][id]" type="hidden" value="' + sites[site].page_types[i].attached_widgets[j].widget_id + '"></td> \
                                <td>' + sites[site].page_types[i].attached_widgets[j].region_name + '<input data-attr="region" name="widgets[' + sites[site].page_types[i].attached_widgets[j].widget_id + '][group]" type="hidden" value="' + sites[site].page_types[i].attached_widgets[j].region + '"></td> \
                                <td>' + sites[site].page_types[i].attached_widgets[j].weight + '<input data-attr="weight" name="widgets[' + sites[site].page_types[i].attached_widgets[j].widget_id + '][weight]" type="hidden" value="' + sites[site].page_types[i].attached_widgets[j].weight + '"></td> \
                                <td> \
                                    <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                                    <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
                                </td> \
                            </tr>');
                        }
                    }
                }
                $('#template_id').trigger('change');
                break;
            }
        }
        /*$.get('/page-type/' + pageTypeId)
            .done(function(pageType) {
                for(var i = 0; i < pageType.templates.length; i++) {
                    $('#template_id').append('<option value="' + pageType.templates[i].id + '">' + pageType.templates[i].name + '</option>');
                    _templates[pageType.templates[i].id] = pageType.templates[i];
                }
                if(typeof pageType.attached_widgets !== 'undefined' && pageType.attached_widgets.length > 0) {
                    $('#tableWidgets tbody tr').remove();
                    for(var i = 0; i < pageType.attached_widgets.length; i++) {
                        console.log(pageType.attached_widgets[i]);
                        if(pageType.attached_widgets[i].site_locale_id == $('#locale').val()) {
                            $('#tableWidgets tbody').append('<tr> \
                                <td><span class="widget-name">' + pageType.attached_widgets[i].widget_name + '</span><input data-attr="id" name="widgets[' + pageType.attached_widgets[i].widget_id + '][id]" type="hidden" value="' + pageType.attached_widgets[i].widget_id + '"></td> \
                                <td>' + pageType.attached_widgets[i].region_name + '<input data-attr="region" name="widgets[' + pageType.attached_widgets[i].widget_id + '][group]" type="hidden" value="' + pageType.attached_widgets[i].region + '"></td> \
                                <td>' + pageType.attached_widgets[i].weight + '<input data-attr="weight" name="widgets[' + pageType.attached_widgets[i].widget_id + '][weight]" type="hidden" value="' + pageType.attached_widgets[i].weight + '"></td> \
                                <td> \
                                    <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                                    <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
                                </td> \
                            </tr>');
                        }
                    }
                }
            });*/
    });

    $('#modalWarningType .btn-cancel').on('click', function() {
        $('#type_id').val($('#type_id').data('prev'));
    });

    $('#modalWarningType .btn-continue').on('click', function() {
        var pageTypeId = $('#type_id').val();
        loadFields(pageTypeId, pageId);
        $('#template_id option').remove();
        $.get('/page-type/' + pageTypeId + '/templates')
            .done(function(templates) {
                for(var i = 0; i < templates.length; i++) {
                    $('#template_id').append('<option value="' + templates[i].id + '">' + templates[i].name + '</option>');
                    _templates[templates[i].id] = templates[i];
                }
            });
        $('#tableWidgets tbody tr').remove();
        $('#type_id').data('prev', pageTypeId);
        $('#modalWarningType').modal('hide');
    });

    $('select#template_id').on('change', function() {
        var templateId = $(this).val();
        var pageTypeId = $('#type_id').val();
        $('#widgetGroup option').remove();
        /*for(var i = 0; _templates[templateId].regions.length; i++) {
            $('#widgetGroup').append('<option value="' + _templates[templateId].regions[i].id + '">' + _templates[templateId].regions[i].name + '</option>');
        }*/
        $('#widgetGroup').html($('template[data-page-type="' + pageTypeId + '"][data-template="' + templateId + '"]').html());
    });

    $('select#site_id').on('change', function() {
        loadLocales($(this).val());
    });

    // Metadata
    $('button#addMetadata').on('click', function() {
        var metadataName = $('#metadataName').val().trim();
        var metadataValue = $('#metadataValue').val().trim();
        if(metadataName !== '' && metadataValue !== '') {
            $('#tableMetadata tbody').append('<tr><td>' + metadataName + '<input name="metadata[' + metadataName + '][name]" type="hidden" value="' + metadataName + '"></td><td>' + metadataValue + '<input name="metadata[' + metadataName + '][value]" type="hidden" value="' + metadataValue + '"></td><td><button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td></tr>');
            $('#metadataName, #metadataValue').val('');
            $('#metadataName').focus();
        }
    });
    $('#tableMetadata').on('click', 'button.btn-remove', function() {
        $(this).parents('tr').remove();
    });
    $('#tableMetadata').on('click', 'button.btn-edit', function() {
        $(this).parents('tr').find('input').each(function() {
            var $in = $(this).clone().attr('type', 'text').addClass('form-control');
            $(this).parent().html('').append($in);
        });
        $(this).removeClass('btn-edit').addClass('btn-save').text('Save');
        $(this).parents('tr').find('input:first').focus();
    });
    $('#tableMetadata').on('click', 'button.btn-save', function() {
        $(this).parents('tr').find('input').each(function() {
            var $in = $(this).clone().attr('type', 'hidden').removeClass('form-control');
            $(this).parent().text($in.val()).append($in);
        });
        $(this).removeClass('btn-edit').addClass('btn-save').text('Edit');
    });

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
        $('#widgetId').val(selection._id);
    });
    $('button#addWidget').on('click', function() {

        var widgetId = $('#widgetId').val();
        var widgetLookup = $('#widgetLookup').val();
        var widgetGroup = $('#widgetGroup').val();
        var widgetRegionName = $('#widgetGroup option:selected').text();
        var widgetWeight = $('#widgetWeight').val();
        if(widgetWeight === '') {
            widgetWeight = '50';
        }
        if(widgetId !== '') {
            $('#tableWidgets tbody').append('<tr> \
                <td><span class="widget-name">' + widgetLookup + '</span><input data-attr="id" name="widgets[' + widgetId + '][id]" type="hidden" value="' + widgetId + '"></td> \
                <td>' + widgetRegionName + '<input data-attr="region" name="widgets[' + widgetId + '][group]" type="hidden" value="' + widgetGroup + '"></td> \
                <td>' + widgetWeight + '<input data-attr="weight" name="widgets[' + widgetId + '][weight]" type="hidden" value="' + widgetWeight + '"></td> \
                <td> \
                    <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                    <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
                </td> \
            </tr>');
            $('#widgetId, #widgetWeight').val('');
            $('#widgetLookup').typeahead('val', '').focus();
        }
    });
    $('#tableWidgets').on('click', 'button.btn-remove', function() {
        $(this).parents('tr').remove();
    });
    $('#tableWidgets').on('click', 'button.btn-edit', function() {
        var $tr = $(this).closest('tr');
        var widgetName = $tr.find('span.widget-name').text();
        var widgetId = $tr.find('input[data-attr="id"]').val();
        $('#widgetLookup').typeahead('val', widgetName);
    });

    $('#parentLookup.typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    }, {
        name: 'pages',
        display: function(datum) {
            return datum.title + ' (' + datum.url + ')';
        },
        source: pages.ttAdapter(),
        limit: 10,
        templates: {
            empty: '<div>Nothing found</div>',
            suggestion: Handlebars.compile('<div><span>{{title}}</span><br><i>{{url}}</i></div>')
        }
    });
    $('#parentLookup.typeahead').on('typeahead:selected', function(el, selection, dataset) {
        $('#parent_id').val(selection.id);
    });

    $('.action-remove-parent').on('click', function() {
        $('#parent_id').val('');
        $('#parentLookup').typeahead('val', '').focus();
    });
});
