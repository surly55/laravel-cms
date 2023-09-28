@for($i=0; $i<3; $i++)
<div class="form-group">
    <label>Title</label>
    <input type="text" name="data[video][{{ $i }}][title]" class="form-control" value="{{ isset($data['video'][$i]['title']) ? $data['video'][$i]['title'] : '' }}">
</div>

<div class="form-group">
    <label>Youtube URL</label>
    <input type="text" name="data[video][{{ $i }}][url]" class="form-control" value="{{ isset($data['video'][$i]['url']) ? $data['video'][$i]['url'] : '' }}">
</div>

<hr>
@endfor