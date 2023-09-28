<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Title</label>
    <input type="text" name="name" id="name" class="form-control" tabindex="1" value="{{ old('name', ($action == 'edit' || $action == 'duplicate') ? $widget->name : '') }}">
    @if($errors->has('name'))
        <span class="help-block">
            @foreach($errors->get('name') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>

<div class="form-group">
    <label for="name">Subtitle</label>
    <input type="text" name="subtitle" id="subtitle" class="form-control">
</div>


<div style="display:none;" class="form-group {{ $errors->has('widget_id') ? 'has-error' : '' }}">
    <label for="widget_id">ID</label>
    <input type="text" name="widget_id" id="widget_id" class="form-control" tabindex="1" value="{{ old('widget_id', ($action == 'edit' || $action == 'duplicate') ? $widget->widget_id : '') }}">
    @if($errors->has('widget_id'))
        <span class="help-block">
            @foreach($errors->get('widget_id') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('type_id') ? 'has-error' : '' }}">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" tabindex="3">
                @foreach($types as $id => $type)
                <option value="{{ $id }}" @if(old('type') == $id || (($action == 'edit' || $action == 'duplicate') && $widget->type == $id))selected="selected"@endif>{{ $type['name'] }}</option>
                @endforeach
            </select>
            @if($errors->has('type_id'))
                <span class="help-block">
                    @foreach($errors->get('type_id') as $message)
                        {{ $message }}
                    @endforeach
                </span>
            @endif
        </div>
    </div>

    <div class="col-sm-4" style="display:none;">
        <div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
            <label for="site_id">Site</label>
            <select name="site_id" id="site_id" class="form-control" tabindex="4">
                @foreach($sites as $site)
                <option value="{{ $site->_id }}" @if(old('site_id') == $site->_id || (($action == 'edit' || $action == 'duplicate') && $widget->site_id == $site->_id))selected="selected"@endif>{{ $site->name }}</option>
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
    </div>

    <div class="col-sm-6" >
        <div class="form-group">
            <label for="locale">Locale</label>
            <select name="site_locale_id" id="locale" class="form-control" tabindex="5">
              <option value="0" selected>-- Select --</option>
              @foreach($locales as $locale)
                  <option value="{{ $locale->_id }}" data-name="{{ $locale->name }}" data-code="{{ $locale->code }}">{{ $locale->name }} ({{ $locale->code }})</option>
                  
              @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="header">Header</label>
    <textarea name="header" id="header" rows="3" class="form-control">{{ old('header', ($action == 'edit' || $action == 'duplicate') ? $widget->header : '') }}</textarea>
</div>
