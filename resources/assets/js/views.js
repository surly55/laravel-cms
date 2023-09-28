var criteriaRule = 'site';
var sites, pageTypes = [];
var selectedPageType;
var rules = [];

$(function() {
    $('#criteriaRule').on('change', function() {
        criteriaRule = $(this).val();
        console.log('Load criteria ' + criteriaRule);
        var criteriaValueEl = $('<input/>', { id: 'criteriaValue', class: 'form-control', type: 'text' });
        $('#criteriaValueWrapper').empty();
        if(criteriaRule == 'site') {
            $.get('/site')
                .done(function(data) {
                    sites = data;
                    criteriaValueEl = $('<select/>', { id: 'criteriaValue', class: 'form-control' });
                    for(var i = 0; i < sites.length; i++) {
                        criteriaValueEl.append('<option value="' + sites[i]._id + '">' + sites[i].name + '</option>');
                    }
                    $('#criteriaValueWrapper').append(criteriaValueEl);
                });
        } else if(criteriaRule == 'locale') {
            $.get('/site')
                .done(function(data) {
                    sites = data;
                    criteriaValueEl = $('<select/>', { id: 'criteriaValue', class: 'form-control' });
                    for(var i = 0; i < sites[0].locales.length; i++) {
                        criteriaValueEl.append('<option value="' + sites[0].locales[i]._id + '">' + sites[0].locales[i].name + '</option>');
                    }
                    $('#criteriaValueWrapper').append(criteriaValueEl);
                });
        } else if(criteriaRule == 'page-type') {
            $.get('/page-type')
                .done(function(data) {
                    criteriaValueEl = $('<select/>', { id: 'criteriaValue', class: 'form-control' });
                    for(var i = 0; i < data.length; i++) {
                        pageTypes[data[i]._id] = data[i];
                        criteriaValueEl.append('<option value="' + data[i]._id + '">' + data[i].name + '</option>');
                    }
                    $('#criteriaValueWrapper').append(criteriaValueEl);
                });
        } else if(criteriaRule == 'published') {
            criteriaValueEl = $('<select/>', { id: 'criteriaValue', class: 'form-control' });
            criteriaValueEl.append('<option value="-1">Any</option><option value="1">Published</option><option value="0">Not published</option>');
            $('#criteriaValueWrapper').append(criteriaValueEl);
        } else if(criteriaRule.substr(0, 6) == 'field:') {
            var field = criteriaRule.substr(6);
            var fieldId = pageTypes[selectedPageType].fields[field].field;
            $.get('/field/' + fieldId + '/filters')
                .done(function(data) {
                    $('#criteriaCondition optgroup.specific option').remove();
                    if(data.filters && !$.isEmptyObject(data.filters)) {
                        for(k in data.filters) {
                            $('#criteriaCondition optgroup.specific').append('<option value="' + k + '">' + data.filters[k] + '</option>');
                        }
                        $('#criteriaCondition optgroup.specific').show();
                    }
                    if(data.html) {
                        $('#criteriaValueWrapper').html(data.html);
                    } else {
                        $('#criteriaValueWrapper').html(criteriaValueEl);
                    }
                });
        }
    });

    $('#criteriaCondition').on('change', function() {
        console.log(criteriaRule);
        if(criteriaRule.substr(0, 6) == 'field:') {
            var field = criteriaRule.substr(6);
            var fieldId = pageTypes[selectedPageType].fields[field].field;
            var condition = $(this).val();
            console.log(condition);
            $.get('/field/' + fieldId + '/filter/' + condition)
                .done(function(data) {
                    if(data) {
                        $('#criteriaValueWrapper').html(data.html);
                    }
                });
        }
    });

    $('#addCriteria').on('click', function() {
        var rule = $('#criteriaRule').val();
        if(rule !== '0') {
            var ruleText = $('#criteriaRule option:selected').text();
            var condition = $('#criteriaCondition').val();
            var conditionText = $('#criteriaCondition option:selected').text();
            var value = valueText = $('#criteriaValue').val();
            if($('#criteriaValue').is('select')) {
                valueText = $('#criteriaValue option:selected').text();
            }
            rules.push({
                rule: rule,
                condition: condition,
                value: value
            });
            $('#tableCriterias').append('<tr data-rule="' + rule + '"> \
                <td><input type="hidden" name="criteria[rule][]" value="' + rule + '">' + ruleText + '</td> \
                <td><input type="hidden" name="criteria[condition][]" value="' + condition + '">' + conditionText + '</td> \
                <td><input type="hidden" name="criteria[value][]" value="' + value + '">' + valueText + '</td> \
                <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td> \
            </tr>');
            $('#criteriaRule').val('0').find('option[value="' + rule + '"]').hide();
            $('#criteriaCondition').val('eq');
            $('#criteriaValueWrapper').empty();
            if(rule == 'page-type') {
                selectedPageType = value;
                $('#displaySortRule option[data-type="field"]').remove();
                for(field in pageTypes[value].fields) {
                    $('#criteriaRule, #displaySortRule').append('<option data-type="field" value="field:' + field + '">Field: ' + pageTypes[value].fields[field].label + '</option>');
                }
            } else if(rule == 'site') {
                $('#criteriaRule').append('<option value="locale">Locale</option>');
            }
        }
    });

    $('#tableCriterias').on('click', 'button.btn-remove', function() {
        var $row = $(this).closest('tr');
        var rule = $row.find('input[name="criteria[rule][]"]').val();
        $('#criteriaRule option[value="' + rule + '"]').show();
        if(rule == 'page-type') {
            $('#criteriaRule, #displaySortRule').find('option[data-type="field"]').remove();
        }
        $('#tableCriterias, #displaySortRule').find('tr[data-rule^="field:"]').remove();
        $row.remove();
    });

    $('#addSort').on('click', function() {
        var rule = $('#displaySortRule').val();
        var ruleText = $('#displaySortRule option:selected').text();
        var order = $('#displaySortOrder').val();
        var orderText = $('#displaySortOrder option:selected').text();

        $('#tableSort').append('<tr data-rule="' + rule + '"> \
            <td><input type="hidden" name="sort[rule][]" value="' + rule + '">' + ruleText + '</td> \
            <td><input type="hidden" name="sort[order][]" value="' + order + '">' + orderText + '</td> \
            <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td> \
        </tr>');

        $('#displaySortRule option[value="' + rule + '"]').hide();
    });

    $('#tableSort').on('click', 'button.btn-remove', function() {
        var $row = $(this).closest('tr');
        var rule = $row.find('input[name="sort[rule][]"]').val();
        $('#displaySortRule option[value="' + rule + '"]').show();
        $row.remove();
    });
});