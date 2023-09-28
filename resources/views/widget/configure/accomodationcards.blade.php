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
      <label for="widgetSubtitle">Button</label>
      <input type="text" name="data[button]" id="widgetButton" class="form-control" value="{{ isset($data['button']) ? $data['button'] : '' }}">
  </div>

  <div class="form-group">
      <label for="widgetSubtitle">Path</label>
      <input type="text" name="data[path]" id="widgetPath" class="form-control" value="{{ isset($data['path']) ? $data['path'] : '' }}">
  </div>


  <div class="form-group">
    <label for="widgetImages">Cards</label>
    <div class="row all-images">
      <div class="col-md-12" id="widget-images-div-0" >
        <label>Title</label>
        <input type="text" name="images[title][]" value="" class="form-control" placeholder="Title" />
        <br>
        <label>Image</label>
        <input type="text" name="images[image][]" value="" class="form-control" placeholder="Image" />
        <br>
        <label>Label</label>
        <input type="text" name="images[label][]" value="" class="form-control" placeholder="Label" />
        <br>
        <label>Location</label>
        <input type="text" name="images[location][]" value="" class="form-control" placeholder="Location" />
        <br>
        <label>Nights</label>
        <input type="number" name="images[nights][]" value="" class="form-control" placeholder="Nights" />
        <br>
        <label>Halfboards</label>
        <input type="number" name="images[halfboards][]" value="" class="form-control" placeholder="Halfboards" />
        <br>
        <label>Price</label>
        <input type="text" name="images[price][]" value="" class="form-control" placeholder="Price" />
        <br>
        <label>Rating</label>
        <input type="text" name="images[rating][]" value="" class="form-control" placeholder="Rating" />
        <br>
        <div class="btn btn-primary" onclick="cloneWidgetGalleryDiv();"><i class="fa fa-plus"></i>Add new</div>

      </div>
    </div>
  </div>



</fieldset>
