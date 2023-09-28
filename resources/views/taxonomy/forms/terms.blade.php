<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="termName">Name</label>
            <input type="text" id="termName" class="form-control">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="termKey">Key</label>
            <input type="text" id="termKey" class="form-control">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="termDescription">Description</label>
    <textarea id="termDescription" rows="3" class="form-control" placeholder="Short description (optional)"></textarea>
</div>

<div class="form-group">
    <button type="button" class="btn btn-default" id="addTerm"><i class="fa fa-plus"></i> Add term</button>
</div>

<table id="tableTerms" class="table table-striped table-bordered table-condensed" style="margin-top: 10px">
    <thead>
        <tr>
            <th class="col-sm-5">Name</th>
            <th class="col-sm-5">Key</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>
    @if($action == 'edit')
        @foreach($taxonomicGroup->terms as $term)
        <tr>
            <td>{{ $term->name }}<input name="terms[name][]" type="hidden" value="{{ $term->name }}"></td>
            <td>{{ $term->key }}<input name="terms[key][]" type="hidden" value="{{ $term->key }}"></td>
            <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>