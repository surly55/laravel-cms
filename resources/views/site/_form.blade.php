<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
    <input id="name" type="text" name="name" class="form-control" tabindex="1" value="{{ old('name', $action == 'edit' ? $site->name : '') }}">
    @if($errors->has('name'))
        <span class="help-block">
        @foreach($errors->get('name') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('domain') ? 'has-error' : '' }}">
    <label for="domain">Domain <a href="#" data-toggle="tooltip" data-placement="right" title="Domain name without the protocol, eg. example.org"><i class="fa fa-question-circle"></i></a></label>
    <input id="domain" type="text" name="domain" class="form-control"  tabindex="2"  value="{{ old('domain', $action == 'edit' ? $site->domain : '') }}">
    @if($errors->has('domain'))
        <span class="help-block">
            @foreach($errors->get('domain') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>

<div class="checkbox">
  <label><input name="https" type="checkbox" value="1" {{ old('https') == '1' || ($action == 'edit' && $site->https === true) ? 'checked="checked"' : '' }}>HTTPS</label>
</div>