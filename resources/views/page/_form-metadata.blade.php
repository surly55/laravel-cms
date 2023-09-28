<fieldset class="metadata">
    <div class="row">
        <div class="col-sm-10">
            <select id="metadataName" class="form-control">
              <option value="0" disabled>Select...</option>
              <option value="title">Title</option>
              <option value="description">Description</option>
              <option value="keywords">Keywords</option>
              <option value="author">Author</option>
            </select>
        </div>
    </div>
    <br>
    <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-10">
            <!--<input id="metadataValue" type="text" class="form-control" placeholder="Value">-->
            <textarea rows="4" id="metadataValue" type="text" class="form-control" placeholder="Value"></textarea>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-default btn-block" id="addMetadata"><i class="fa fa-plus"></i> Add</button>
        </div>
    </div>

    <table id="tableMetadata" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
        <thead>
            <tr>
                <th class="col-sm-5">Name</th>
                <th class="col-sm-5">Value</th>
                <th class="col-sm-2">-</th>
            </tr>
        </thead>
        <tbody>
            @foreach($metadata as $md)
            <tr>
                <td>{{ $md['name'] }}<input name="metadata[{{ $md['name'] }}][name]" type="hidden" value="{{ $md['name'] }}"></td>
                <td>{{ $md['value'] }}<input name="metadata[{{ $md['name'] }}][value]" type="hidden" value="{{ $md['value'] }}"></td>
                <td>
                    <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button>
                    <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</fieldset>
