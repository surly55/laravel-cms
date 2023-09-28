<fieldset class="widget-slider-slide">
    <legend>Slide <span class="slide-num">{{ isset($counter) ? $counter+1 : '' }}</span>
        <div class="pull-right">
            <button type="button" class="btn btn-box-tool btn-widget-slider-delete" data-widget="collapse"><i class="fa fa-times"></i></button>
        </div>
    </legend>

    <div class="form-group">
        <label for="" style="display: block;">Image</label>
        @if(isset($slide))
            <img src="/uploads/thumbnails/{{ $slide['image'] }}" alt="Slider image" class="img-thumbnail" style="margin-bottom: 5px">
        @else
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='" alt="Slider image" style="display: none; margin-bottom: 5px" class="img-thumbnail">
        @endif
        <button type="button" class="btn btn-default btn-widget-slider-image"><i class="fa fa-image"></i> Choose image from gallery</button>
        <input type="hidden" name="data[slides][{{ $counter or '%id%' }}][image]" @if(isset($slide)) value="{{ $slide['image'] }}" @else value="" disabled @endif>
    </div>

    <div class="form-group">
        <label for="">Text</label>
        <textarea name="data[slides][{{ $counter or '%id%' }}][text]" rows="2" class="form-control" @if(!isset($slide)) disabled @endif>{{ $slide['text'] or '' }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Alignment</label>
                <?php $alignment = isset($slide) ? $slide['text_alignment'] : 'center'; ?>
                <select name="data[slides][{{ $counter or '%id%' }}][text_alignment]" class="form-control" @if(!isset($slide)) disabled @endif>
                    <option value="left" @if($alignment == 'left') selected="selected" @endif>Left</option>
                    <option value="center" @if($alignment == 'center') selected="selected" @endif>Center</option>
                    <option value="right" @if($alignment == 'right') selected="selected" @endif>Right</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Color</label>
                <input type="color" name="data[slides][{{ $counter or '%id%' }}][text_color]" class="form-control" @if(isset($slide)) value="{{ $slide['text_color'] }}" @else value="#FFFFFF" disabled @endif>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Background</label>
                <input type="color" name="data[slides][{{ $counter or '%id%' }}][text_bgcolor]" class="form-control" @if(isset($slide)) value="{{ $slide['text_bgcolor'] }}" @else value="#000000" disabled @endif>

                <label for="">Opacity</label>
                <input type="number" name="data[slides][{{ $counter or '%id%' }}][text_bgcolor_opacity]" class="form-control"  min="0" max="100" @if(isset($slide)) value="{{ $slide['text_bgcolor_opacity'] }}" @else value="100" disabled  @endif>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="data[slides][{{ $counter or '%id%' }}][text_bgcolor]" value="transparent" @if(!isset($slide) || $slide['text_bgcolor'] == 'transparent') checked @endif @if(!isset($slide)) disabled @endif> Transparent
                    </label>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-sm btn-primary btn-add-action-button" data-slide-id="{{ $counter or 0 }}"><i class="fa fa-plus"></i> Add action button</button>

    <table class="table table-condensed table-bordered table-action-buttons">
        <thead>
            <tr>
                <th>Label</th>
                <th>Style</th>
                <th>Link</th>
                <th>OP</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($slide) && isset($slide['action_buttons']))
                <?php $anotherCounter = 0; ?>
                @foreach($slide['action_buttons'] as $ab)
                <tr>
                    <td><input type="text" name="data[slides][{{ $counter }}][action_buttons][{{ $anotherCounter }}][label]" class="form-control" placeholder="Label" value="{{ $ab['label'] }}"></td>
                    <td>
                        <select name="data[slides][{{ $counter }}][action_buttons][{{ $anotherCounter }}][style]" class="form-control">
                            <option value="blue" @if($ab['style'] == 'blue') selected @endif>Blue</option>
                            <option value="white" @if($ab['style'] == 'white') selected @endif>White</option>
                        </select>
                    </td>
                    <td><input type="text" name="data[slides][{{ $counter }}][action_buttons][{{ $anotherCounter }}][link]" class="form-control" placeholder="Link" value="{{ $ab['link'] }}"></td>
                    <td><button type="button" class="btn btn-sm btn-danger btn-delete-action-button">Remove</button></td>
                </tr>
                <?php $anotherCounter++ ?>
                @endforeach
            @endif
        </tbody>
    </table>
</fieldset>