<div style="display: flex; align-items: baseline; justify-content: space-around;">
    <label for="widgetRows" style="padding: 0 5px">Rows</label>
    <input id="widgetRows" name="widget[rows]" type="number" value="1" placeholder="Rows">
    <label for="widgetColumns" style="padding: 0 5px">Columns</label>
    <input id="widgetColumns" name="widget[columns]" type="number" value="1" placeholder="Columns">
    <button type="button" class="btn btn-success widget-tiles-update"><i class="fa fa-refresh"></i> Update</button>
</div>

<div class="tiles" style="margin-top: 20px"></div>

<div class="tile-form-prototype" style="display: none;">
    <fieldset class="tile">
        <legend style="font-size: 16px; font-weight: bold">Tile #<span class="tile-number"></span><small class="tile-position" style="margin-left: 5px; font-weight: normal"></small></legend>

        <input type="hidden" data-name="widget[tiles][_id][row]">
        <input type="hidden" data-name="widget[tiles][_id][column]">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <input name="" type="text" class="form-control" data-name="widget[tiles][_id][title]">
                </div>
                <div class="form-group">
                    <label for="">Text</label>
                    <input type="text" class="form-control" data-name="widget[tiles][_id][text]">
                </div>
                <div class="form-group">
                    <label for="">Link</label>
                    <div class="row">
                        <div class="col-xs-8">
                            <input type="text" class="form-control" data-name="widget[tiles][_id][link]">
                        </div>
                        <div class="col-xs-4">
                            <select name="link_type" class="form-control">
                                <option value="url">URL</option>
                                <option value="page">Page</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Image</label>
                    <button type="button" class="btn btn-default btn-library" data-toggle="modal" data-target="#libraryModal" data-input-target="">Choose from library</button>
                    <input type="hidden" data-name="widget[tiles][_id][image]">
                    <img class="img-responsive" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" style="display: none; margin-top: 10px">
                </div>
            </div>
        </div>
    </fieldset>
</div>

@include('partials.modal-library')