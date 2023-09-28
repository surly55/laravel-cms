<div class="form-group">
    <label for="field_{{ $id }}">{{ $field['label'] }}</label>
    <select name="content[{{ $id }}]" id="field_{{ $id }}" class="form-control">
        @foreach($views as $view)
        <option value="{{ $view->id }}" @if($view->id == $data) selected @endif>{{ $view->name }}</option>
        @endforeach
    </select>
</div>