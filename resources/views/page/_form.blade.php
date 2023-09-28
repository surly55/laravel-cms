<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">Title</label>
    <input name="title" id="title" type="text" class="form-control" tabindex="1" value="{{ old('title', $action == 'edit' ? $page->title : '') }}">
    @if($errors->has('title'))
        <span class="help-block">
        @foreach($errors->get('title') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
    <label for="url">URL</label>
    <input name="url" id="url" type="text" class="form-control" tabindex="2" value="{{ old('url', $action == 'edit' ? $page->url : '') }}">
    @if($errors->has('url'))
        <span class="help-block">
            @foreach($errors->get('url') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
            <label for="site_id">Site</label>
            <select name="site_id" id="site_id" class="form-control">
                @foreach($sites as $id => $site)
                <option value="{{ $id }}" @if(old('site_id') == $id || ($action == 'edit' && $page->site_id == $id))selected="selected"@endif>{{ $site['name'] }}</option>
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

    <div class="col-sm-6">
        <div class="form-group" @if(!$hasLocales)style="display: none"@endif>
            <label for="locale">Locale</label>
            <select name="site_locale_id" id="locale" class="form-control">
                @foreach($sites[$selectedSite]->locales as $locale)
                <option value="{{ $locale->_id }}" @if($selectedLocale == $locale->_id)selected="selected"@endif>{{ $locale->name }} ({{ $locale->locale->code }})</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- PAGE TYPE & THEME -->
<div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="page_type">Page type (layout)</label>
        <select name="page_type" id="page_type" class="form-control">
          <option value="1">Home (full width)</option>
          <option value="2">Default (limited width)</option>
        </select>
    </div>

    <div class="checkbox">
        <input type="hidden" name="sidebar" value="0">
        <label><input name="sidebar" type="checkbox" value="1" {{ old('sidebar') == '0' || ($action == 'edit' && $page->sidebar == false) ? '' : '' }}>Sidebar</label>
    </div>

  </div>



  <div class="col-sm-12">
    <div class="form-group">
      <label for="page_theme">Page theme</label>
      <select name="page_theme" id="page_theme" class="form-control">
        <option value="0">Default</option>
        <option value="1">Green</option>
        <option value="2">Red</option>
        <option value="3">Blue</option>
        <option value="4">Yellow</option>
        <option value="5">Purple</option>
        <option value="6">Black</option>
      </select>
  </div>
</div>
</div>



<div class="checkbox">
    <input type="hidden" name="published" value="0">
    <label><input name="published" type="checkbox" value="1" {{ old('published') == '0' || ($action == 'edit' && $page->published == false) ? '' : '' }}>Published</label>
</div>
