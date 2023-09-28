<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="optionName">Name</label>
            <input id="optionName" type="text" class="form-control" placeholder="Name">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="optionLocale">Locale</label>
            <select id="optionLocale" class="form-control">
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
    <div class="col-sm-6">
        <div class="form-group">
            <label for="optionValue">Value</label>
            <input id="optionValue" type="text" class="form-control" placeholder="Value">
        </div>
    </div>
    <div class="col-sm-6">
        <div id="optionActions" style="padding-top: 25px; text-align: right">
            <button type="button" class="btn btn-default" data-action="add"><i class="fa fa-plus"></i> Add option</button>
            <button type="button" class="btn btn-success" data-action="save" style="display: none"><i class="fa fa-pencil"></i> Save</button>
            <button type="button" class="btn btn-default" data-action="reset" style="display: none"><i class="fa fa-times"></i> Cancel</button>
        </div>
    </div>
</div>

<table id="tableOptions" class="table table-striped table-bordered table-condensed" style="margin-top: 10px">
    <thead>
        <tr style="text-transform: uppercase;">
            <th class="col-sm-4">Name</th>
            <th class="col-sm-2">Locale</th>
            <th class="col-sm-4">Value</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>
        @if(empty($site->options))
            <tr class="no-options">
                <td colspan="3" class="text-center">No options</td>
            </tr>
        @else
            @foreach($site->options as $option)
                <tr>
                    <td>{{ $option['name'] }}<input name="options[name][]" type="hidden" value="{{ $option['name'] }}" data-name="name"></td>
                    <td>
                        @if($option->locale)
                            {{ $option->locale->name }} ({{ $option->locale->locale->code }})<input name="options[locale][]" type="hidden" value="{{ $option->locale->_id }}" data-name="locale">
                        @else
                            Any<input name="options[locale][]" type="hidden" value="0" data-name="locale">
                        @endif
                    </td>
                    <td>{{ $option['value'] }}<input name="options[value][]" type="hidden" value="{{ $option['value'] }}" data-name="value"></td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button>
                        <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>