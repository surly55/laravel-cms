<div class="form-group">
    <label for="widgetTitle">Title</label>
    <input type="text" name="data[title]" id="widgetTitle" class="form-control" value="{{ isset($data['title']) ? $data['title'] : '' }}">
</div>

<div class="form-group">
    <label for="widgetSubtitle">Subtitle</label>
    <input type="text" name="data[subtitle]" id="widgetSubtitle" class="form-control" value="{{ isset($data['subtitle']) ? $data['subtitle'] : '' }}">
</div>

<div class="form-group">
    <label for="widgetText">Text</label>
    <input type="text" name="data[text]" id="widgetText" class="form-control" value="{{ isset($data['text']) ? $data['text'] : '' }}">
</div>

<div class="form-group">
    <label for="widgetButton">Button</label>
    <input type="text" name="data[button]" id="widgetButton" class="form-control" value="{{ isset($data['button']) ? $data['button'] : '' }}">
</div>

<div class="form-group">
    <label for="widgetPath">Path</label>
    <input type="text" name="data[path]" id="widgetPath" class="form-control" value="{{ isset($data['path']) ? $data['path'] : '' }}">
</div>

<div class="form-group">
    <label for="widgetImage">Image URL</label>
    <input type="text" name="data[img]" id="widgetImage" class="form-control" value="{{ isset($data['img']) ? $data['img'] : '' }}">
</div>
