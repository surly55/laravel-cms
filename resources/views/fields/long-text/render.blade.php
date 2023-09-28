<div class="form-group">
    <label for="field_{{ $id }}">{{ $field['label'] }}</label>
    <textarea name="content[{{ $id }}]" id="field_{{ $id }}" rows="{{ $config['rows'] }}" class="form-control">{{ $data or '' }}</textarea>
</div>