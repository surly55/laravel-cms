<div class="form-group">
    <label for="field">Field</label>
    <select id="field" class="form-control">
        @foreach($fields as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="fieldLabel">Label</label>
    <input id="fieldLabel" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="fieldId">ID</label>
    <input id="fieldId" type="text" class="form-control">
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="checkbox">
            <label><input id="fieldRequired" type="checkbox" value="1">Required</label>
        </div>
    </div>
    <div class="col-sm-6">
        <button type="button" id="addField" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add field</button>
    </div>
</div>

<table id="tableFields" class="table table-condensed table-bordered" style="margin-top: 10px">
    <thead>
        <tr style="text-transform: uppercase;">
            <th class="col-sm-3">Field</th>
            <th class="col-sm-3">Label</th>
            <th class="col-sm-3">ID</th>
            <th class="col-sm-2">Required</th>
            <th class="col-sm-1">-</th>
        </tr>
    </thead>
    <tbody>
        @if($action == 'edit' && count($pageType->fields) > 0)
            @foreach($pageType->fields as $id => $field)
            <tr>
                <td><i class="fa fa-arrows-v handle"></i> {{ $fields[$field['field']] }}<input type="hidden" name="fields[{{ $id }}][field]" value="{{ $field['field'] }}"></td>
                <td>{{ $field['label'] }}<input type="hidden" name="fields[{{ $id }}][label]" value="{{ $field['label'] }}"></td>
                <td>{{ $id }}</td>
                <td>{{ $field['required'] ? 'yes' : 'no' }}<input type="hidden" name="fields[{{ $id }}][required]" value="{{ $field['required'] }}"></td>
                <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
