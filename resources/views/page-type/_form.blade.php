<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
    <input name="name" id="name" type="text" class="form-control" tabindex="1" value="{{ old('name', $action == 'edit' ? $pageType->name : '') }}">
    @if($errors->has('name'))
        <span class="help-block">
        @foreach($errors->get('name') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('uri') ? 'has-error' : '' }}">
    <label for="uri">URI <a href="#" class="text-danger" data-toggle="tooltip" data-placement="right" title="Do not change this unless you know what you're doing!"><i class="fa fa-exclamation-circle"></i></a></label>
    <input name="uri" id="uri" type="text" class="form-control" tabindex="2" value="{{ old('uri', $action == 'edit' ? $pageType->uri : '') }}">
    <span class="help-block">URI can only contain a combination of lowercase letters, dash(-) and underscore(_).</span>
    @if($errors->has('uri'))
        <span class="help-block">
        @foreach($errors->get('uri') as $message)
            {{ $message }}
        @endforeach
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
    <textarea name="description" id="description" rows="2" tabindex="3" class="form-control" placeholder="A short description for what is this page type used for."></textarea>
    @if($errors->has('description'))
        <span class="help-block">
            @foreach($errors->get('description') as $message)
                {{ $message }}
            @endforeach
        </span>
    @endif
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="site_id">Site</label>
            <select name="site_id" id="site_id" class="form-control">
                @foreach($sites as $id => $site)
                <option value="{{ $id }}" @if($action == 'edit' && $pageType->site_id == $id) selected @endif>{{ $site->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="locales">Locales <button type="button" class="btn btn-xs btn-default btn-select-all-locales">Select all</button></label>
            <select name="locales[]" id="locales" class="form-control" multiple>
                @if($action == 'edit')
                    @foreach($sites[$pageType->site_id]->locales as $locale)
                    <option value="{{ $locale->_id }}" @if($pageType->locales->contains($locale->_id)) selected @endif>{{ $locale->name }} ({{ $locale->locale->code }})</option>
                    @endforeach
                @endif
            </select>
            <span class="help-block">
                <span class="no-locale-selected">You must select at least one locale!</span>
            </span>
        </div>
    </div>
</div>