<div class="form-group">
    <label>View</label>
    <select name="data[view]" class="form-control">
        @foreach($views as $view)
        <option value="{{ $view->id }}" @if(isset($data['view']) && $data['view'] == $view->id) selected @endif>{{ $view->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Template</label>
    <select name="data[template]" id="widgetTemplate" class="form-control">
        <option value="grid" @if(isset($data['template']) && $data['template'] == 'grid') selected @endif>Grid</option>
        <option value="slider" @if(isset($data['template']) && $data['template'] == 'slider') selected @endif>Slider</option>
    </select>
</div>

<div id="templateOptionsGrid" @if(isset($data['template']) && $data['template'] == 'slider') style="display: none" @endif>
    <div class="form-group">
        <label>Items per row</label>
        <input type="number" name="data[template_options][grid][items_per_row]" class="form-control" value="{{ isset($data['template_options']['grid']['items_per_row']) ? $data['template_options']['grid']['items_per_row'] : 1 }}">
    </div>
</div>

<div id="templateOptionsSlider" @if(!isset($data['template']) || (isset($data['template']) && $data['template'] == 'grid')) style="display: none" @endif>
    <div class="form-group">
        <label>Items per slide</label>
        <input type="number" name="data[template_options][slider][items_per_slide]" class="form-control" value="{{ isset($data['template_options']['slider']['items_per_slide']) ? $data['template_options']['slider']['items_per_slide'] : 1 }}">
    </div>
</div>

<div class="form-group">
    <label>Header</label>
    <textarea name="data[header]" rows="3" class="form-control" placeholder="Optional widget header. You may use HTML">{{ isset($data['header']) ? $data['header'] : '' }}</textarea>
</div>

<div class="form-group">
    <label>Header (altenative)</label>
    <textarea name="data[header_alt]" rows="3" class="form-control" placeholder="Alternative header, i.e. for mobile version">{{ isset($data['header_alt']) ? $data['header_alt'] : '' }}</textarea>
</div>