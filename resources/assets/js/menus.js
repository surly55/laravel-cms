// This is a javascript hell
var pages = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/page/lookup/?s=%QUERY',
        wildcard: '%QUERY'
    }
});
pages.initialize();

var menus = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/menu/lookup/?s=%QUERY',
        wildcard: '%QUERY'
    }
});
menus.initialize();

$(function() {
    loadLocales($('#site_id').val());
    $('select#site_id').on('change', function() {
        loadLocales($(this).val());
    });

    $('#itemLabelUseHtml').on('change', function() {
        if(this.checked) {
            $('#itemLabelHtml').show();
        } else {
            $('#itemLabelHtml').hide();
        }
    });

    $('#itemPageLookup').typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    }, {
        name: 'pages',
        displayKey: 'title',
        source: pages.ttAdapter(),
        limit: 10,
    });

    $('#itemMenuLookup').typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    }, {
        name: 'menus',
        displayKey: 'title',
        source: menus.ttAdapter(),
        limit: 10,
    });
    $('#itemPageLookup, #itemMenuLookup').on('typeahead:selected', function(el, selection, dataset) {
        $('#itemLink').val(selection.id);
    });

    $('#addItem').on('click', function() {

      var itemTitle = $('#itemMainTitle').val().trim();
      alert(itemTitle);
      /*
        var itemLabel = $('#itemLabel').val().trim();
        if(itemLabel === '') {
            $('#itemLabel').addClass('flash-error').css('animation-play-state', 'running').parent().addClass('has-error');
        }
        var itemLabelHtml = $('#itemLabelUseHtml').is(':checked') ? _.escape($('#itemLabelHtml').val()) : '';
        var itemType = $('#itemType').val();
        var itemTypeText = $('#itemType option:selected').text();
        var itemTags = $('#itemTags').val();

        var itemLink = $('#itemLink').val();
        var itemLinkText = itemLink;
        var itemLinkData = '';
        if(itemType == 'page') {
            itemLinkText = 'Page: ' + $('#itemPageLookup').typeahead('val');
            itemLinkData = 'data-page="' + itemLinkText + '"';
        } else if(itemType == 'menu') {
            itemLinkText = 'Menu: ' + $('#itemMenuLookup').typeahead('val');
            itemLinkData = 'data-menu="' + itemLinkText + '"';
        }

        $('#tableItems tbody').append('<tr data-item="' + itemCount + '"> \
            <td><i class="fa fa-arrows-v handle"></i> <span>' + itemLabel + '</span><input name="items[' + itemCount + '][label]" type="hidden" value="' + itemLabel + '" data-attr="label"></td> \
            <td><span>' + itemTypeText + '</span><input name="items[' + itemCount + '][type]" type="hidden" value="' + itemType + '" data-attr="type"></td> \
            <td><span ' + itemLinkData + '>' + itemLinkText + '</span><input name="items[' + itemCount + '][link]" type="hidden" value="' + itemLink + '" data-attr="link"></td> \
            <td> \
                <input name="items[' + itemCount + '][tags]" type="hidden" value="' + itemTags + '" data-attr="tags"> \
                <input name="items[' + itemCount + '][labelHtml]" type="hidden" value="' + itemLabelHtml + '" data-attr="labelHtml"> \
                <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button> \
                <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button> \
            </td> \
        </tr>');
        $('#itemLabel, #itemLink, #itemTags').val('');
        $('#itemPageLookup, #itemMenuLookup').typeahead('val', '');
        $('#itemLabel').focus();
        itemCount++;

        */
    });

    $(document).on('change', '#itemType', function() {
        var itemType = $(this).val();
        if(itemType == 'url' || itemType == 'action') {
            $('#itemPageLookup, #itemMenuLookup').closest('.item-wrapper').hide();
            $('#itemLink').closest('.item-wrapper').show();
        } else if (itemType == 'page') {
            $('#itemLink, #itemMenuLookup').closest('.item-wrapper').hide();
            $('#itemPageLookup').closest('.item-wrapper').show();
        } else if (itemType == 'menu') {
            $('#itemLink, #itemPageLookup').closest('.item-wrapper').hide();
            $('#itemMenuLookup').closest('.item-wrapper').show();
        }
    });

    $('#tableItems').on('click', 'button.btn-remove', function() {
        $(this).closest('tr').remove();
    });

    $('#tableItems').on('click', 'button.btn-edit', function() {
        var $tr = $(this).closest('tr');
        $('#itemLabel').val($tr.find('input[data-attr="label"]').val());
        var itemLabelHtml = $tr.find('input[data-attr="labelHtml"]').val();
        if(itemLabelHtml.length > 0) {
            $('#itemLabelUseHtml').prop('checked', true);
            $('#itemLabelHtml').val(itemLabelHtml).show();
        } else {
            $('#itemLabelUseHtml').prop('checked', false);
            $('#itemLabelHtml').val('').hide();
        }
        var itemType = $tr.find('input[data-attr="type"]').val()
        $('#itemType').val(itemType);
        if(itemType == 'url' || itemType == 'action') {
            $('#itemPageLookup, #itemMenuLookup').closest('.item-wrapper').hide();
            $('#itemLink').closest('.item-wrapper').show();
        } else if (itemType == 'page') {
            $('#itemLink, #itemMenuLookup').closest('.item-wrapper').hide();
            $('#itemPageLookup').typeahead('val', $tr.find('span[data-page]').data('page')).closest('.item-wrapper').show();
        } else if (itemType == 'menu') {
            $('#itemLink, #itemPageLookup').closest('.item-wrapper').hide();
            $('#itemMenuLookup').typeahead('val', $tr.find('span[data-menu]').data('menu')).closest('.item-wrapper').show();
        }
        $('#itemLink').val($tr.find('input[data-attr="link"]').val());
        $('#itemTags').val($tr.find('input[data-attr="tags"]').val());
        $('#saveItem').data('item', $tr.data('item'));
        $('.action-add').hide();
        $('.action-save').show();
    });

    $('#saveItem').on('click', function() {
        var item = $(this).data('item');
        var itemLabel = $('#itemLabel').val().trim();
        if(itemLabel === '') {
            $('#itemLabel').addClass('flash-error').css('animation-play-state', 'running').parent().addClass('has-error');
        }
        var itemLabelHtml = $('#itemLabelUseHtml').is(':checked') ? _.escape($('#itemLabelHtml').val()) : '';
        var itemType = $('#itemType').val();
        var itemTypeText = $('#itemType option:selected').text();
        var itemTags = $('#itemTags').val();

        var itemLink = $('#itemLink').val();
        var itemLinkText = itemLink;
        if(itemType == 'page') {
            itemLinkText = 'Page: ' + $('#itemPageLookup').typeahead('val');
        } else if(itemType == 'menu') {
            itemLinkText = 'Menu: ' + $('#itemMenuLookup').typeahead('val');
        }

        $('#tableItems tr[data-item="' + item + '"] input[data-attr="label"]').val(itemLabel).closest('td').find('span').text(itemLabel);
        $('#tableItems tr[data-item="' + item + '"] input[data-attr="type"]').val(itemType).closest('td').find('span').text(itemTypeText);
        $('#tableItems tr[data-item="' + item + '"] input[data-attr="link"]').val(itemLink).closest('td').find('span').text(itemLinkText);
        $('#tableItems tr[data-item="' + item + '"] input[data-attr="tags"]').val(itemTags);
        $('#tableItems tr[data-item="' + item + '"] input[data-attr="labelHtml"]').val(itemLabelHtml);

        $('#itemLabel, #itemLink, #itemTags').val('');
        $('#itemPageLookup, #itemMenuLookup').typeahead('val', '');
        $('#itemLabel').focus();
        $(this).data('item', '');
        $('.action-save').hide();
        $('.action-add').show();
    });

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    $('#tableItems tbody').sortable({
        handle: '.handle',
        helper: fixHelper,
        update: function(e, ui) {
            var posStart = 1;
            $('#tableItems input[data-position]').each(function() {
                $(this).val(posStart++);
            });
        }
    });
});
