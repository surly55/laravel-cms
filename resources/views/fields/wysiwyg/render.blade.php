<div class="form-group">
    <label for="{{ $id }}">{{ $field['label'] }}</label>
    <textarea name="content[{{ $id }}]" id="{{ $id }}" class="form-control">{{ $data or '' }}</textarea>
</div>