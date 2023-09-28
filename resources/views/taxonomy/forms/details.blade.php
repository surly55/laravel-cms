<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="form-control" tabindex="1" value="{{ old('name', $action == 'edit' ? $taxonomicGroup->name : '') }}">
</div>