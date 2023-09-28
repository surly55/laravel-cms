@if($action == 'create')
<p>Unless you choose which page templates you want to use for this page type, a default one will be created.</p>
@endif

<div class="form-group">
    <label for="templates">Templates</label>
    <select name="templates[]" id="templates" class="form-control" multiple>
        @foreach($pageTemplates as $id => $template)
            <?php 
                if(old('templates') && in_array($id, old('templates'))) {
                    $selected = 'selected';
                } else {
                    $selected = ($action == 'edit' && $pageType->templates->contains($id)) ? 'selected' : ''; 
                }
            ?>
            <option value="{{ $id }}" {!! $selected !!}>{{ $template->name }}</option>
        @endforeach
    </select>
    @if($action == 'edit')
    <span class="help-block">
        <span class="no-template-selected">You must select at least one template!</span>
    </span>
    @endif
</div>