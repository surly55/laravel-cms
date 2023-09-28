@if($action == 'edit')
<div class="alert alert-warning alert-no-locale" style="display: none">
    <p>In order to add widgets for this page type <strong>you need to select at least one locale</strong>! Also, all previously added widgets for a locale that is no longer associated with this page type will be removed upon saving.</p>
</div>

<div id="widgetForm">
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="widgetLocale">Locale</label>
            <select id="widgetLocale" class="form-control">
                @foreach($pageType->locales as $locale)
                    <option value="{{ $locale->_id }}">{{ $locale->name }} ({{ $locale->locale->code }})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="widgetTemplate">Template</label>
            <select id="widgetTemplate" class="form-control">
                @foreach($pageType->templates as $template)
                <option value="{{ $template->_id }}">{{ $template->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="widgetRegion">Region</label>
            <select id="widgetRegion" class="form-control">
                @foreach($pageType->templates->first()->regions as $region)
                    <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
        <div class="form-group">
            <label for="widgetWidget">Widget</label>
            <input type="text" id="widgetLookup" class="form-control typeahead" autocomplete="off">
            <input type="hidden" id="widgetWidget">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="widgetWeight">Weight</label>
            <input type="number" id="widgetWeight" class="form-control" value="50">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <button type="button" id="addWidget" class="btn btn-default"><i class="fa fa-plus"></i>Add widget</button>
        </div>  
    </div>
</div>
</div>

<table id="tableWidgets" class="table table-striped table-bordered table-condensed" style="margin-top: 10px">
    <thead>
        <tr style="text-transform: uppercase;">
            <th class="col-sm-2">Locale</th>
            <th class="col-sm-2">Template</th>
            <th class="col-sm-2">Region</th>
            <th class="col-sm-2">Widget</th>
            <th class="col-sm-2">Weight</th>
            <th class="col-sm-2">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @if(count($pageType->attachedWidgets) > 0)
            @foreach($pageType->attachedWidgets as $widget)
                <tr>
                    <td>{{ $widget->locale->name }}<input name="widgets[locale][]" type="hidden" value="{{ $widget->locale->_id }}"></td>
                    <td>{{ $widget->template->name }}<input name="widgets[template][]" type="hidden" value="{{ $widget->template->_id }}"></td>
                    <td>
                        @if($region = $widget->template->getRegion($widget->region))
                            {{ $region['name'] }}
                        @endif
                        <input name="widgets[region][]" type="hidden" value="{{ $widget->region }}">
                    </td>
                    <td>{{ $widget->widget->name }}<input name="widgets[widget][]" type="hidden" value="{{ $widget->widget->_id }}"></td>
                    <td>{{ $widget->weight }}<input name="widgets[weight][]" type="hidden" value="{{ $widget->weight }}"></td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button>
                        <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@else
<div>You may add widgets to this page type after saving.</div>
@endif