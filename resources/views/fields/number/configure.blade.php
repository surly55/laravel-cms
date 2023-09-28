<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Min. value</label>
            <input type="number" name="configuration[min]" class="form-control" value="{{ $data['min'] or '' }}">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Max. value</label>
            <input type="number" name="configuration[max]" class="form-control" value="{{ $data['max'] or '' }}">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Default value</label>
            <input type="number" name="configuration[default]" class="form-control" value="{{ $data['default'] or '' }}">
        </div>
    </div>
</div>
