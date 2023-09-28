<div class="row form-widget">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="widgetLookup">Widget</label>
            <input id="widgetLookup" type="text" class="form-control typeahead" placeholder="Widget" autocomplete="off">
            <input type="hidden" id="widgetId">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="widgetLocale">Locale</label>
            <select id="widgetLocale" class="form-control">
                <option value="0">Any</option>
                @if($action == 'edit')
                    @foreach($site->locales as $locale)
                    <option value="{{ $locale->_id }}">{{ $locale->name }} ({{ $locale->locale->code }})</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="widgetRegion">Region</label>
            <select id="widgetRegion" class="form-control">
                <option value="0">No region</option>
                @if($action == 'edit' && !empty($site->layout['regions']))
                    @foreach($site->layout['regions'] as $region)
                    <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label for="widgetWeight">Weight</label>
            <input id="widgetWeight" type="number" min="1" max="100" value="50" class="form-control" placeholder="Weight">
        </div>
    </div>
    <div class="col-sm-6">
        <div id="widgetActions" style="padding-top: 25px; text-align: right">
            <button type="button" class="btn btn-default" data-action="add"><i class="fa fa-plus"></i> Add widget</button>
            <button type="button" class="btn btn-success" data-action="save" style="display: none"><i class="fa fa-pencil"></i> Save</button>
            <button type="button" class="btn btn-default" data-action="reset" style="display: none"><i class="fa fa-times"></i> Cancel</button>
        </div>
    </div>
</div>

<table id="tableWidgets" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
    <thead>
        <tr style="text-transform: uppercase;">
            <th class="col-sm-4">Widget</th>
            <th class="col-sm-2">Locale</th>
            <th class="col-sm-3">Region</th>
            <th class="col-sm-1">Weight</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>
        @if(empty($site->attachedWidgets))
            <tr class="no-widgets">
                <td colspan="5" class="text-center">No widgets</td>
            </tr>
        @else
            @foreach($site->attachedWidgets as $widget)
            <tr>
                <td>{{ $widget->widget_name }}<input type="hidden" name="widgets[widget][]" value="{{ $widget['widget_id'] }}" data-name="widget" data-widget="{{ $widget->widget_name }}"> <a href="{{ route('widget.edit', [ 'id' => $widget['widget_id'] ]) }}" target="_blank" class="btn btn-xs btn-default">Edit widget</a></td>
                <td>
                    @if($widget->locale)
                        {{ $widget->locale->name }} ({{ $widget->locale->locale->code }})<input name="widgets[locale][]" type="hidden" value="{{ $widget->locale->_id }}" data-name="locale">
                    @else
                        Any<input name="widgets[locale][]" type="hidden" value="0" data-name="locale">
                    @endif
                </td>
                <td>{{ $widget['region'] }}<input type="hidden" name="widgets[region][]" value="{{ $widget['region'] }}" data-name="region"></td>
                <td>{{ $widget['weight'] }}<input type="hidden" name="widgets[weight][]" value="{{ $widget['weight'] }}" data-name="weight"></td>
                <td>
                    <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button>
                    <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>