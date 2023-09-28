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
  <textarea name="data[content]" id="widgetContent" class="form-control" rows="10"></textarea>
</div>
