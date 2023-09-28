<div class="form-group">
    <label for="field_{{ $id }}">{{ $field['label'] }}</label>
    <input type="text" name="content[{{ $id }}]" id="field_{{ $id }}" value="{{ $data or '' }}" class="form-control">
</div>