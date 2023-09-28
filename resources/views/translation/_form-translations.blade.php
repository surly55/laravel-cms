<fieldset class="translations">
    @if($action == 'edit')
        @foreach($translation->site->locales as $locale)
        <div class="form-group">
            Locale: <strong>{{ $locale->name }}</strong>
            <textarea name="translations[{{ $locale->_id }}]" class="form-control" rows="5">@if(isset($translation->translations[$locale->_id])){{ $translation->translations[$locale->_id] }}@endif</textarea>
        </div>
        @endforeach
    @endif
</fieldset>