<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
    <input name="name" id="name" type="text" class="form-control" tabindex="1" value="{{ old('name', $action == 'edit' ? $pageTemplate->name : '') }}">
    @if($errors->has('name'))
        <span class="help-block">
        @foreach($errors->get('name') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('template_id') ? 'has-error' : '' }}">
    <label for="template_id">Template ID <a href="#" class="text-danger" data-toggle="tooltip" data-placement="right" title="Do not change this unless you know what you're doing!"><i class="fa fa-exclamation-circle"></i></a></label>
    <input name="template_id" id="template_id" type="text" class="form-control" tabindex="2" value="{{ old('template_id', $action == 'edit' ? $pageTemplate->template_id : '') }}">
    @if($errors->has('template_id'))
        <span class="help-block">
        @foreach($errors->get('template_id') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
    <textarea name="description" id="description" rows="3" tabindex="3" class="form-control" placeholder="A short description&hellip;"></textarea>
    @if($errors->has('description'))
        <span class="help-block">
            @foreach($errors->get('description') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>