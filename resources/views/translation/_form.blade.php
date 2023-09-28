<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
    <label for="key">Key</label>
    <input name="key" id="key" type="text" class="form-control" tabindex="1" value="{{ old('key', $action == 'edit' ? $translation->key : '') }}">
    @if($errors->has('key'))
        <span class="help-block">
            @foreach($errors->get('key') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('source') ? 'has-error' : '' }}">
    <label for="source">Source</label>
    <textarea name="source" id="source" rows="5" class="form-control" tabindex="2">{{ old('source', $action == 'edit' ? $translation->source : '') }}</textarea>
    @if($errors->has('source'))
        <span class="help-block">
            @foreach($errors->get('source') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
    <label for="site_id">Site</label>
    <select name="site_id" id="site_id" class="form-control">
        @foreach($sites as $site)
        <option value="{{ $site->_id }}" @if(old('site_id') == $site->_id || ($action == 'edit' && $translation->site_id == $site->_id))selected="selected"@endif>{{ $site->name }}</option>
        @endforeach
    </select>
    @if($errors->has('site_id'))
        <span class="help-block">
            @foreach($errors->get('site_id') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>