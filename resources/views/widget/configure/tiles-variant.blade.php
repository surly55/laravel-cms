<div class="form-group">
    <label for="widgetLayout">Layout</label>
    <select id="widgetLayout" name="data[layout]" class="form-control">
        @foreach($layouts as $id => $layout)
        <option value="{{ $id }}" data-tiles="{{ $layout['tiles'] }}" @if(isset($data['layout']) && $data['layout'] == $id) selected @endif>{{ $layout['name'] }}</option>
        @endforeach
    </select>
</div>

<input type="hidden" name="data[show_map]" value="0">
@if(!isset($simpleMosaic) || $simpleMosaic == false)
<div class="checkbox">
    <label><input name="data[show_map]" type="checkbox" value="1" {{ (isset($data['show_map']) && $data['show_map'] == false) ? '' : 'checked' }}>Show map</label>
</div>
@endif

<ol id="widgetTiles" class="list-unstyled">
@for($i = 0; $i < 10; $i++)
<li class="tile" @if((isset($data['layout']) && $i >= $layouts[$data['layout']]['tiles']) || (!isset($data['layout']) && $i >= $minTiles))style="display: none;"@endif>
<fieldset class="tile">
    <legend style="font-size: 16px; font-weight: bold; background-color: #f3f3f3;">
        <span style="padding: 5px; vertical-align: middle; cursor: pointer;">Tile {{ $i+1 }}</span>
        <div class="pull-right">
            <button type="button" class="btn btn-box-tool btn-collapse"><i class="fa fa-minus"></i></button>
        </div>
    </legend>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="">Title</label>
                <input name="data[tiles][{{ $i }}][title]" type="text" class="form-control" value="{{ isset($data['tiles'][$i]['title']) ? $data['tiles'][$i]['title'] : '' }}">
            </div>
            <div class="form-group">
                <label for="">Subtitle (on hover)</label>
                <input name="data[tiles][{{ $i }}][subtitle]" type="text" class="form-control" value="{{ isset($data['tiles'][$i]['subtitle']) ? $data['tiles'][$i]['subtitle'] : '' }}">
            </div>
            <div class="form-group">
                <label for="">Text (on hover)</label>
                <input name="data[tiles][{{ $i }}][text]" type="text" class="form-control" value="{{ isset($data['tiles'][$i]['text']) ? $data['tiles'][$i]['text'] : '' }}">
            </div>
            <div class="form-group">
                <label for="">Link</label>
                <div class="row">
                    <div class="col-xs-8">
                        @if(!isset($data['tiles'][$i]['link_type']) || (isset($data['tiles'][$i]['link_type']) && $data['tiles'][$i]['link_type'] == 'url'))
                        <input name="data[tiles][{{ $i }}][link]" type="text" class="form-control link-url" value="{{ isset($data['tiles'][$i]['link']) ? $data['tiles'][$i]['link'] : '' }}">
                        <div class="link-page-wrapper" style="display: none;">
                            <input type="text" class="form-control link-page typeahead">
                        </div>
                        @else
                        <input name="data[tiles][{{ $i }}][link]" type="text" class="form-control link-url" value="{{ isset($data['tiles'][$i]['link']) ? $data['tiles'][$i]['link'] : '' }}" style="display: none">
                        <div class="link-page-wrapper">
                            <input type="text" class="form-control link-page typeahead" value="{{ $data['tiles'][$i]['page'] }}">
                        </div>
                        @endif
                    </div>
                    <div class="col-xs-4">
                        <select name="data[tiles][{{ $i }}][link_type]" class="form-control link-type">
                            <option value="url" @if(isset($data['tiles'][$i]['link_type']) && $data['tiles'][$i]['link_type'] == 'url') selected @endif>URL</option>
                            <option value="page" @if(isset($data['tiles'][$i]['link_type']) && $data['tiles'][$i]['link_type'] == 'page') selected @endif>Page</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Geolocation</label>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" name="data[tiles][{{ $i }}][latitude]" class="form-control" placeholder="Latitude" value="@if(isset($data['tiles'][$i]['latitude'])){{ $data['tiles'][$i]['latitude'] }}@endif">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" name="data[tiles][{{ $i }}][longitude]" class="form-control" placeholder="Latitude" value="@if(isset($data['tiles'][$i]['longitude'])){{ $data['tiles'][$i]['longitude'] }}@endif">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="">Image</label>
                <button type="button" class="btn btn-default btn-library">Choose from library</button>
                <input name="data[tiles][{{ $i }}][image]" type="hidden" value="{{ isset($data['tiles'][$i]['image']) ? $data['tiles'][$i]['image'] : '' }}">
                <img class="img-responsive" src="{{ !empty($data['tiles'][$i]['image']) ? '/uploads/thumbnails/' . $data['tiles'][$i]['image'] : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' }}" style="display: {{ isset($data['tiles'][$i]['image']) ? 'block' : 'none' }}; margin-top: 10px">
            </div>
        </div>
    </div>
</fieldset>
</li>
@endfor
</ol>

@include('partials.modal-library')