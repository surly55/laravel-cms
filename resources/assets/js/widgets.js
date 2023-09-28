/*function loadWidget(widgetType)
{
    console.log('Loading widget ' + widgetType)
    $.get(routeURL.replace('%TYPE%', widgetType), function(data) {
        if(data.error) {
            $('fieldset.widget').html(data.message);    
            return;
        } else {
            $('fieldset.widget').html(data.form);
            var requires = data.requires || [];
            var trueRequires = requires.uniq().filter(function(r) { return loadedScripts.indexOf(r) < 0 });
            var trulyTrueRequires = trueRequires.map(function(r) { 
                return $.getScriptCached('/js/' + r) 
            });
            trulyTrueRequires.push($.Deferred(function(deferred) {
                $(deferred.resolve);
            }));
            $.holdReady(true);
            $.when.apply($, trulyTrueRequires).done(function() {
                loadedScripts = loadedScripts.concat(trueRequires);
                $.holdReady(false);
            });
        }
    });
}*/

function getScriptsSync(scripts, callback)
{
    var loaded = 0;
    scripts.forEach(function(script) {
        $.getScriptCached('/js/' + script).done(function() {
            if(++loaded == scripts.length) callback();
        });
    });
}

function loadWidget(widgetType)
{
    console.log('Loading widget ' + widgetType)
    $.get(routeURL.replace('%TYPE%', widgetType), function(data) {
        if(data.error) {
            $('fieldset.widget').html(data.message);    
            return;
        } else {
            $('fieldset.widget').html(data.form);
            var requires = data.requires || [];
            var trueRequires = requires.uniq().filter(function(r) { return loadedScripts.indexOf(r) < 0 });
            getScriptsSync(trueRequires, function() {
                loadedScripts = loadedScripts.concat(trueRequires);
            });
            /*var trulyTrueRequires = trueRequires.map(function(r) { 
                return $.getScriptCached('/js/' + r) 
            });
            trulyTrueRequires.push($.Deferred(function(deferred) {
                $(deferred.resolve);
            }));
            $.holdReady(true);
            $.when.apply($, trulyTrueRequires).done(function() {
                loadedScripts = loadedScripts.concat(trueRequires);
                $.holdReady(false);
            });*/
        }
    });
}

$(function() {
    $('#type').on('change', function() {
        loadWidget('type:' + $(this).val());
    });

    $('#site_id').on('change', function() {
        loadLocales($(this).val());
    });
});