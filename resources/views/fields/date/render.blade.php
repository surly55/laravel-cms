<div class="form-group">
    <label for="{{ $id }}">{{ $field['label'] }}</label>
    <input name="content[{{ $id }}]" id="{{ $id }}" type="date" class="form-control datepicker" value="{{ $data or '' }}">
</div>