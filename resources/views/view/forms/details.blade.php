<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
    <input name="name" id="name" type="text" class="form-control" tabindex="1" value="{{ old('name', $action == 'edit' || $action == 'duplicate' ? $view->name : '') }}">
    @if($errors->has('name'))
        <span class="help-block">
        @foreach($errors->get('name') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>