<div class="form-group">
    <label>Items per page</label>
    <input type="number" name="items_per_page" class="form-control" value="{{ $action == 'edit' && isset($view->items_per_page) ? $view->items_per_page : 10 }}">
</div>

<fieldset>
    <legend>Sorting</legend>

    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Rule</label>
                <select id="displaySortRule" class="form-control">
                    @foreach($sortRules as $rule => $name)
                    <option value="{{ $rule }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label>Order</label>
                <select id="displaySortOrder" class="form-control">
                    <option value="asc">Asc</option>
                    <option value="desc">Desc</option>
                </select>
            </div>
        </div>

        <div class="col-sm-2">
            <button id="addSort" type="button" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Add sort</button>
        </div>
    </div>

    <table id="tableSort" class="table table-striped table-bordered table-condensed" style="margin-top: 10px">
        <thead>
            <tr>
                <th class="col-sm-5">Rule</th>
                <th class="col-sm-5">Order</th>
                <th class="col-sm-2">-</th>
            </tr>
        </thead>
        <tbody>
        @if($action == 'edit' || $action == 'duplicate')
            @foreach($view->sortRules as $sortRule)
            <tr data-rule="{{ $sortRule->rule }}">
                <td><input type="hidden" name="sort[rule][]" value="{{ $sortRule->rule }}">{{ $sortRule->rule }}</td>
                <td><input type="hidden" name="sort[order][]" value="{{ $sortRule->order }}">{{ $sortRule->order }}</td>
                <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</fieldset>