<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="criteriaRule">Rule</label>
            <select id="criteriaRule" class="form-control">
                <option value="0" selected>-- Choose --</option>
                @foreach($rules as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="criteriaCondition">Condition</label>
            <select id="criteriaCondition" class="form-control">
                <optgroup label="General">
                    <option value="eq">Is (Equals)</option>
                    <option value="neq">Is Not (Not equal)</option>
                </optgroup>
                <optgroup class="specific" label="Specific" style="display: none"></optgroup>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="criteriaValue">Value</label>
            <div id="criteriaValueWrapper"></div>
        </div>
    </div>
    <div class="col-sm-3">
        <button type="button" id="addCriteria" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Add criteria</button>
    </div>
</div>

<table id="tableCriterias" class="table table-striped table-bordered table-condensed" style="margin-top: 10px">
    <thead>
        <tr>
            <th class="col-sm-3">Rule</th>
            <th class="col-sm-3">Condition</th>
            <th class="col-sm-3">Value</th>
            <th class="col-sm-3">-</th>
        </tr>
    </thead>
    <tbody>
        @if($action == 'edit' || $action == 'duplicate')
            @foreach($view->criterias as $criteria)
            <tr>
                <td><input type="hidden" name="criteria[rule][]" value="{{ $criteria['rule'] }}">{{ $criteria['rule'] }}</td>
                <td><input type="hidden" name="criteria[condition][]" value="{{ $criteria['condition'] }}">{{ $criteria['condition'] }}</td>
                <td><input type="hidden" name="criteria[value][]" value="{{ $criteria['value'] }}">{{ $criteria['value'] }}</td>
                <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>