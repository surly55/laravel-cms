<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="localeLocale">Locale</label>
            <select id="localeLocale" class="form-control">
                <option value="0" selected>-- Select --</option>
                @foreach($locales as $locale)
                <option value="{{ $locale->_id }}" data-name="{{ $locale->name }}" data-code="{{ $locale->code }}">{{ $locale->name }} ({{ $locale->code }})</option>
                @endforeach        
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="localeName">Name</label>
            <input type="text" class="form-control" id="localeName">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="localeType">Type</label>
            <select id="localeType" class="form-control">
                <option value="url_prefix" selected>URL prefix</option>
                <option value="subdomain">Subdomain</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="localeId">URL prefix/subdomain</label>
            <input type="text" id="localeId" class="form-control">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="checkbox">
            <label><input id="localeActive" type="checkbox" value="1" checked>Active</label>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="pull-right" id="localeActions">
            <button type="button" class="btn btn-default" data-action="add"><i class="fa fa-plus"></i>Add locale</button>
            <button type="button" class="btn btn-success" data-action="save" style="display: none"><i class="fa fa-pencil"></i> Save</button>
            <button type="button" class="btn btn-default" data-action="reset" style="display: none"><i class="fa fa-times"></i> Cancel</button>
        </div>
    </div>
</div>

<table id="tableLocales" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
    <thead>
        <tr>
            <th class="col-sm-3">Name</th>
            <th class="col-sm-2">Locale</th>
            <th class="col-sm-2">Type</th>
            <th class="col-sm-2"><abbr title="URL prefix or subdomain">URL</abbr></th>
            <th class="col-sm-1">Active</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>
        @if($action == 'edit' && count($site->locales) > 0)
        @foreach($site->locales as $locale)
        <tr>
            <td>{{ $locale->name }} <input type="hidden" name="locales[name][]" value="{{ $locale->name }}" data-name="name"></td>
            <td>{{ $locale->locale->name }} ({{ $locale->locale->code }}) <input type="hidden" name="locales[locale][]" value="{{ $locale->locale->_id }}" data-name="locale"></td>
            <td>
                @if($locale->type == 'subdomain')
                Subdomain
                @elseif($locale->type == 'url_prefix')
                URL prefix
                @endif
                <input type="hidden" name="locales[type][]" value="{{ $locale->type }}" data-name="type">
            </td>
            <td>
                @if($locale->type == 'subdomain')
                {{ $locale->subdomain }}
                <input type="hidden" name="locales[id][]" value="{{ $locale->subdomain }}" data-name="id">
                @elseif($locale->type == 'url_prefix')
                {{ $locale->url_prefix }}
                <input type="hidden" name="locales[id][]" value="{{ $locale->url_prefix }}" data-name="id">
                @endif
            </td>
            <td>
                @if($locale->active)
                yes
                @else
                no
                @endif
                <input type="hidden" name="locales[active][]" value="{{ (int)$locale->active }}" data-name="active">
            </td>
            <td>
                <input type="hidden" name="locales[_id][]" value="{{ $locale->_id }}">
                <button type="button" class="btn btn-xs btn-default btn-edit" data-action="edit">Edit</button>
                <button type="button" class="btn btn-xs btn-danger btn-remove" data-action="remove">Remove</button>
            </td>
        </tr>
        @endforeach
        @else
        <tr class="no-locales">
            <td colspan="6" class="text-center">No locales</td>
        </tr>
        @endif
    </tbody>
</table>