var loadedScripts = loadedStyles = [];

Array.prototype.uniq = function() {
    return this.reduce(function(prev, curr) {
        if(prev.indexOf(curr) == -1) prev.push(curr);
        return prev;
    }, []);
}

$.getScriptCached = function(url, options) {
    options = $.extend(options || {}, {
        async: false,
        dataType: 'script',
        cache: false,
        url: url
    });

    return jQuery.ajax(options);
};

function displayMessage(message, type, clear) {
    type = typeof type !== 'undefined' ? type : 'info';
    clear = typeof clear !== 'undefined' ? clear : true;

    if(clear) 
        $('.messages').html('');

    $('.messages').append('<div class="alert alert-' + type + ' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' + message + '</div>');
}

function loadLocales(siteId, localeInput)
{
    loadLocalesNew(siteId, localeInput);
    /*localeInput = localeInput || '#locale';
    console.log('Loading locales for ' + siteId + ' into ' + localeInput);
    $(localeInput).find('option').remove();
    if(sites[siteId].locales !== null) {
        var options = '';
        Object.keys(sites[siteId].locales).forEach(function(k) {
            options += '<option value="' + k + '">' + sites[siteId].locales[k] + ' (' + k + ')</option>';
        });
        $(localeInput).append(options).trigger('change').parent().show();
    } else {
        $(localeInput).parent().hide();
    }*/
}

function loadLocalesNew(siteId, localeInput)
{
    localeInput = localeInput || '#locale';
    console.log('Loading locales for ' + siteId + ' into ' + localeInput);
    if($(localeInput).length > 0) {
        $(localeInput).find('option').remove();
        if(sites[siteId].locales !== null) {
            var options = '';
            sites[siteId].locales.forEach(function(locale) {
                options += '<option value="' + locale._id + '">' + locale.name + '</option>';
            });
            $(localeInput).append(options).val($(localeInput).data('locale')).trigger('change').parent().show();
        } else {
            $(localeInput).parent().hide();
        }
    }
}

function trimUrl(url)
{
    return url.replace(/^\/+|\/+$/g, '');
}

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $('#modalDelete').on('show.bs.modal', function (e) {
        $('#btnDelete').data('delete-url', $(e.relatedTarget).data('delete-url'));
        $('#btnDelete').data('resource-id', $(e.relatedTarget).data('resource-id'));
    });
    $('#btnDelete').click(function() {
        var resourceId = $(this).data('resource-id');
        $.ajax({
            url: $(this).data('delete-url'),
            type: 'POST',
            data: { _method: 'DELETE' },
            dataType: 'json'
        }).done(function(data) {
            $('.table-resources tr.resource-' + resourceId).remove();
            displayMessage(data.message, 'success');
        }).fail(function(jqXHR, textStatus, errorThrown) {
            displayMessage(jqXHR.responseJSON.message, 'danger');
        }).always(function(data) {
            $('#modalDelete').modal('hide');
        });
    });

    // Sortable tables
    $('table th[data-sort]').on('click', function() {
        // Here, it would be smater to use URLSearchParams (https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams)
        // but it's not supported in all browsers, so here is a workaround
        var queryObj = window.location.search.substring(1).split('&').reduce(function(query, param) {
            var parts = param.split('=');
            if(parts[0]) {
                query[parts[0]] = parts[1];
            }
            return query;
        }, {});
        queryObj.sort = $(this).data('sort');
        queryObj.order = $(this).data('order');
        var queryString = '';
        for(p in queryObj) {
            if(queryObj.hasOwnProperty(p)) {
                queryString += p + '=' + queryObj[p] + '&';
            }
        }
        //console.log(queryObj, queryString);
        window.location.search = queryString;
    });
});