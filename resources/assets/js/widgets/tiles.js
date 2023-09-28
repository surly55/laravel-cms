var targetInput;

function loadTiles(rows, columns)
{
    $('.tiles').empty();
    var counter = 0;
    for(var i = 0; i < rows; i++) {
        for(var j = 0; j < columns; j++) {
            var $elBoxForm = $('.tile-form-prototype').clone();
            $('legend span.tile-number', $elBoxForm).text((i+1)*(j+1));
            $('legend small.tile-position', $elBoxForm).text('row ' + (i+1) + ', column ' + (j+1));
            $('input', $elBoxForm).each(function() {
                if($(this).data('name')) {
                    $(this).attr('name', $(this).data('name').replace('_id', counter));
                }
            });
            $('input[name="data[tiles][' + counter + '][row]"]', $elBoxForm).val(i);
            $('input[name="data[tiles][' + counter + '][column]"]', $elBoxForm).val(j);
            var randomString = Math.random().toString(36).substring(2, 7);
            $('input.box-image', $elBoxForm).addClass('box-image-' + randomString);
            $('button.btn-library', $elBoxForm).attr('data-input-target', '.box-image-' + randomString);
            $('.tiles').append($elBoxForm.html());
            counter++;
        }
    }
}

var pages = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/page/lookup/?s=%QUERY',
        wildcard: '%QUERY',
        // Hack (workaround) so we can get query later in transform function
        prepare: function(query, settings) {
            this.query = query;
            settings.url = settings.url.replace('%QUERY', encodeURI(query));
            return settings;
        },
        transform: function(response) {
            var query = this.query;
            return response.sort(function(a, b) {
                return Levenshtein.get(a.title, query) - Levenshtein.get(b.title, query);
            });
        }
    }
});
pages.initialize();

$(function() {
    $('.btn-library').on('click', function() {
        targetInput = $(this).siblings('input[type=hidden]');
        $('#libraryModal').modal('show');
    });

    $('#libraryModal .btn-choose-image').on('click', function() {
        if(chosenImage != undefined || chosenImage != '') {
            targetInput.val(chosenImage.image);
            targetInput.siblings('img').attr('src', '/uploads/thumbnails/' + chosenImage.image).show();
            chosenImage = {};
            $('#libraryModal').modal('hide');
        }
    });


    $('button.widget-tiles-update').on('click', function() {
        loadTiles($('#widgetRows').val(), $('#widgetColumns').val());

        /*$('.tiles input.box-page').typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
        }, {
            name: 'pages',
            displayKey: 'title',
            source: pages.ttAdapter(),
        });
        $('.tiles input.box-page').on('typeahead:selected', function(el, selection, dataset) {
            $(this).parents('.form-group').find(':hidden').val(selection.value);
        });*/
    });

    loadTiles($('#widgetRows').val(), $('#widgetColumns').val());

    $('.link-page.typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    }, {
        name: 'page',
        display: 'title',
        source: pages.ttAdapter(),
        limit: 10,
        templates: {
            empty: '<div>Nothing found</div>',
            suggestion: Handlebars.compile('<div><span>{{title}}</span><br><i>{{url}}</i></div>')
        }
    });
    $('.link-page.typeahead').on('typeahead:selected', function(el, selection, dataset) {
        $(this).closest('.row').find('input.link-url').val(selection.id);
    });

    $('select.link-type').on('change', function() {
        var linkType = $(this).val();
        var $row = $(this).closest('.row');
        if(linkType == 'page') {
            $row.find('input.link-url').val('').hide();
            $row.find('.link-page-wrapper').show();
        } else {
            $row.find('.link-page-wrapper').hide();
            $row.find('input.link-url').val('').show();
        }
    });

    $('#widgetLayout').on('change', function() {
        var tiles = $(this).children('option:selected').first().data('tiles');
        $('#widgetTiles li.tile').slice(0, tiles).show();
        if(tiles != 10) {
            $('#widgetTiles li.tile').slice(-10+tiles).hide();
        }
    });

    $('.tile .btn-collapse').on('click', function() {
        $(this).closest('.tile').children('.row').toggle();
    });

    $('#widgetTiles').sortable({
        handle: 'legend>span',
    });
});