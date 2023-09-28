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
      <label for="widgetSubtitle">Latitude</label>
      <input type="text" name="data[latitude]" id="widgetLatitude" class="form-control" value="{{ isset($data['latitude']) ? $data['latitude'] : '' }}">
  </div>

  <div class="form-group">
      <label for="widgetSubtitle">Longitude</label>
      <input type="text" name="data[longitude]" id="widgetLongitude" class="form-control" value="{{ isset($data['longitude']) ? $data['longitude'] : '' }}">
  </div>

  <div class="form-group">
      <label for="widgetSubtitle">Zoom</label>
      <input type="number" min="1" name="data[zoom]" id="widgetZoom" class="form-control" value="{{ isset($data['zoom']) ? $data['zoom'] : '' }}">
  </div>


  <div class="form-group">
    <label for="widgetImages">Markers</label>
    <div class="row all-images">
      <div class="col-md-12" id="widget-images-div-0" >
        <label>Title</label>
        <input type="text" name="images[title][]" value="" class="form-control" placeholder="Title" />
        <br>
        <label>Latitude</label>
        <input type="text" name="images[latitude][]" value="" class="form-control" placeholder="Latitude" />
        <br>
        <label>Longitude</label>
        <input type="text" name="images[longitude][]" value="" class="form-control" placeholder="Longitude" />
        <br>
        <div class="btn btn-primary" onclick="cloneWidgetGalleryDiv();"><i class="fa fa-plus"></i>Add new</div>

      </div>
    </div>
  </div>



</fieldset>
