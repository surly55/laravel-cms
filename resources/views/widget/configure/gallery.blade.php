<fieldset>

  <div class="form-group">
      <label for="widgetTitle">Title</label>
      <input type="text" name="data[title]" id="widgetTitle" class="form-control" value="{{ isset($data['title']) ? $data['title'] : '' }}">
  </div>

  <div class="form-group">
      <label for="widgetSubtitle">Subtitle</label>
      <input type="text" name="data[subtitle]" id="widgetSubtitle" class="form-control" value="{{ isset($data['subtitle']) ? $data['subtitle'] : '' }}">
  </div>

  <div class="form-group">
    <label for="widgetContent">Content</label>
    <br>
    <div class="checkbox">
      <label><input name="data[thumbs]" type="checkbox" value="1" checked="">Thumbs</label>
    </div>
  </div>

  <div class="form-group">
    <label for="widgetImages">Images</label>
    <div class="row all-images">
      <div class="col-md-12" id="widget-images-div-0" >
        <label>Title</label>
        <input type="text" name="images[title][]" value="" class="form-control" placeholder="Title" />
        <br>
        <label>Subtitle</label>
        <input type="text" name="images[subtitle][]" value="" class="form-control" placeholder="Subtitle" />
        <br>
        <label>Image path</label>
        <input type="text" name="images[image_path][]" value="" class="form-control" placeholder="Image path" />
        <br>
        <label>Thumb path</label>
        <input type="text" name="images[thumb_path][]" value="" class="form-control" placeholder="Thumb path" />
        <br>
        <label>Path</label>
        <input type="text" name="images[path][]" value="" class="form-control" placeholder="Path" />
        <br>
        <div class="btn btn-primary" onclick="cloneWidgetGalleryDiv();"><i class="fa fa-plus"></i>Add new</div>

      </div>
    </div>
  </div>



</fieldset>
