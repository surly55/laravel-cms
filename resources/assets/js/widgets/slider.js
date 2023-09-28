var targetInput;

$(function() {
    $('fieldset.widget').on('click', '#widgetSlider_addSlide', function() {
        var $slideForm = $('#widgetSlider_slideForm').clone();
        $('input, textarea, select', $slideForm).each(function() {
            var inputName = $(this).attr('name').replace('%id%', slideCount);
            $(this).attr('name', inputName).removeAttr('disabled');
        });
        $('.btn-add-action-button', $slideForm).data('slide-id', slideCount);
        $('span.slide-num', $slideForm).text(slideCount+1);
        $slideForm.removeAttr('id').show().appendTo('.widget-slider-slides');
        slideCount++;
    });

    $('fieldset.widget').on('click', '.btn-widget-slider-image', function() {
        targetInput = $(this).siblings('input[type=hidden]');
        $('#libraryModal').modal('show');
    });

    $('fieldset.widget').on('click', '.btn-widget-slider-delete', function() {
        $(this).closest('.widget-slider-slide').remove();
    });

    $('fieldset.widget').on('click', '.btn-add-action-button', function() {
        var $tableActionButtons = $(this).siblings('table.table-action-buttons');
        var actionButtonCount = $tableActionButtons.find('tbody tr').length;
        var slideId = $(this).data('slide-id');
        var actionButtonHtml = '<tr><td><input type="text" name="data[slides][' + slideId + '][action_buttons][' + actionButtonCount + '][label]" class="form-control" placeholder="Label"></td><td><select name="data[slides][' + slideId + '][action_buttons][' + actionButtonCount + '][style]" class="form-control"><option value="blue">Blue</option><option value="white">White</option></select></td><td><input type="text" name="data[slides][' + slideId + '][action_buttons][' + actionButtonCount + '][link]" class="form-control" placeholder="Link"></td><td><button type="button" class="btn btn-sm btn-danger btn-delete-action-button">Remove</button></td></tr>';
        $tableActionButtons.find('tbody').append(actionButtonHtml);
    });

    $('fieldset.widget').on('click', '.btn-delete-action-button', function() {
        $(this).closest('tr').remove();
    });

    $('fieldset.widget').on('click', '#libraryModal .btn-primary', function() {
        if(chosenImage.length !== 0) {
            $(targetInput).val(chosenImage.image).siblings('img').attr('src', '/uploads/thumbnails/' + chosenImage.image).show();
            chosenImage = {};
            $('#libraryModal').modal('hide');
        }
    });
});