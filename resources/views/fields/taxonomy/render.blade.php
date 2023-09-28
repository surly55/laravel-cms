<div class="form-group">
    <label for="field_{{ $id }}">{{ $field['label'] }}</label>
    <select name="content[{{ $id }}]" id="field_{{ $id }}" class="form-control">
        @foreach($taxonomicGroup->terms as $term)
        <option value="{{ $term->key }}" @if($term->key == $data) selected @endif>{{ $term->name }}</option>
        @endforeach
    </select>
</div>