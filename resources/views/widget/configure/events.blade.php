<div class="form-group">
    <label>Number of events</label>
    <input type="number" name="data[events_count]" class="form-control" min="1" value="{{ isset($data['events_count']) ? $data['events_count'] : 1 }}">
    <span class="help-block">How many upcoming events to display?</span>
</div>  