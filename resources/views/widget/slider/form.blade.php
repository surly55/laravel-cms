<script>
    var slideCount = {{ isset($data['slides']) ? count($data['slides']) : 0 }};
</script>

<div class="form-group">
    <label for="widgetSlider_version">Version</label>
    <select name="data[version]" id="widgetSlider_version" class="form-control">
        <option value="full" @if(isset($data['version']) && $data['version'] == 'full') selected @endif>Full-size</option>
        <option value="mini" @if(isset($data['version']) && $data['version'] == 'mini') selected @endif>Mini</option>
    </select>
</div>

<button type="button" class="btn btn-primary" id="widgetSlider_addSlide"><i class="fa fa-plus"></i> Add slide</button>

<hr>

<div id="widgetSlider_slideForm" style="display: none">
    @include('widget.slider.form-slide', [ 'counter' => null ])
</div>

<div class="widget-slider-slides">
    @if($data)
        <?php $counter = 0; ?>
        @foreach($data['slides'] as $slide)
            @include('widget.slider.form-slide', [ 'slide' => $slide, 'counter' => $counter ])
            <?php $counter++; ?>
        @endforeach
    @endif
</div>

@include('partials.modal-library')