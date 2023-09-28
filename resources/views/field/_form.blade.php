<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
    <input id="name" placeholder="Item name" type="text" name="name" class="form-control" tabindex="1" value="{{ old('name', $action == 'edit' ? $field->name : '') }}">
    @if($errors->has('name'))
        <span class="help-block">
        @foreach($errors->get('name') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="type">Item</label>
    <select name="type" id="type-item" class="form-control" tabindex="2">
      <option value="1">Header</option>
      <option value="2">Footer</option>
    </select>
</div>
