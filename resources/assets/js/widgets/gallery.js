$(function() {
    $('#widgetGallery_source').on('change', function() {
        $('div.form-source').hide();
        $('div.form-source[data-source="' + $(this).val() + '"]').show();
    });

    $('#addImage').on('click', function() {
        $('#libraryModal').modal('show');
    });

    $('#libraryModal .btn-primary').on('click', function() {
        var imageCount = $('#widgetGallery_imageCount').val();
        if(chosenImage.length !== 0) {
            var $i = $('#prototypeGalleryImage').clone().removeAttr('id').show().appendTo('fieldset.images ul');
            $i.find('img').attr('src', '/uploads/thumbnails/' + chosenImage['image']);
            $i.find('input').each(function() {
                var _val;
                switch($(this).data('name')) {
                    case 'image':
                        _val = chosenImage.image;
                        break;
                    case 'caption':
                        _val = chosenImage.caption;
                        break;
                    default:
                        _val = '';
                }
                $(this).val(_val).attr('name', 'data[images][' + imageCount + '][' + $(this).data('name') + ']');
            });
            imageCount++;
            $('#widgetGallery_imageCount').val(imageCount);
            chosenImage = {};
            $('#libraryModal').modal('hide');
            $('ul.sortable').sortable('refresh');
        }
    });

    $('fieldset.images').on('click', '.btn-remove', function() {
        $(this).closest('.gallery-image').remove();
    });

    $('ul.sortable').sortable();

    $('#widgetGallery_addVimeo').on('click', function() {
        var imageCount = $('#widgetGallery_imageCount').val();
        var videoUrl = $('#widgetGallery_sourceVimeo').val();
        $('fieldset.images ul').append('<li class="gallery-image" style="margin-bottom: 10px"> \
            <div class="row"> \
                <div class="col-md-1"> \
                    <i class="fa fa-arrows-v handle"></i> \
                </div> \
                <div class="col-md-11"> \
                    <div class="form-group"> \
                        <label>Video source</label> \
                        <input name="data[images][' + imageCount + '][source]" type="hidden" value="vimeo"> \
                        <input type="text" class="form-control" disabled value="Vimeo"> \
                    </div> \
                    <div class="form-group"> \
                        <label>Video URL</label> \
                        <input name="data[images][' + imageCount + '][image]" class="form-control" type="text" value="' + videoUrl + '"> \
                    </div> \
                    <div class="form-group"> \
                        <label>Caption</label> \
                        <input name="data[images][' + imageCount + '][caption]" type="text" class="form-control" value="" placeholder="Optional video caption"> \
                    </div> \
                    <button type="button" class="btn btn-danger btn-remove" style="margin-top: 5px">Remove</button> \
                </div> \
            </div> \
        </li>');
        imageCount++;
        $('#widgetGallery_imageCount').val(imageCount);
        $('ul.sortable').sortable('refresh');
    });

    $('#widgetGallery_addYoutube').on('click', function() {
        var imageCount = $('#widgetGallery_imageCount').val();
        var videoUrl = $('#widgetGallery_sourceYoutube').val();
        $('fieldset.images ul').append('<li class="gallery-image" style="margin-bottom: 10px"> \
            <div class="row"> \
                <div class="col-md-1"> \
                    <i class="fa fa-arrows-v handle"></i> \
                </div> \
                <div class="col-md-11"> \
                    <div class="form-group"> \
                        <label>Video source</label> \
                        <input name="data[images][' + imageCount + '][source]" type="hidden" value="youtube"> \
                        <input type="text" class="form-control" disabled value="Youtube"> \
                    </div> \
                    <div class="form-group"> \
                        <label>Video URL</label> \
                        <input name="data[images][' + imageCount + '][image]" class="form-control" type="text" value="' + videoUrl + '"> \
                    </div> \
                    <div class="form-group"> \
                        <label>Caption</label> \
                        <input name="data[images][' + imageCount + '][caption]" type="text" class="form-control" value="" placeholder="Optional video caption"> \
                    </div> \
                    <button type="button" class="btn btn-danger btn-remove" style="margin-top: 5px">Remove</button> \
                </div> \
            </div> \
        </li>');
        imageCount++;
        $('#widgetGallery_imageCount').val(imageCount);
        $('ul.sortable').sortable('refresh');
    });
});