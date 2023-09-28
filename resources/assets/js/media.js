$(function() {
    $('#modalCategory').on('shown.bs.modal', function() {
        $('#newCategoryName').focus();
    });
    $('#modalCategory').on('hide.bs.modal', function() {
        $('#newCategoryName').val('');
    });
    $('#modalCategory button.btn-primary').on('click', function() {
        var categoryName = $('#newCategoryName').val().trim();
        var error = null;
        if(categoryName.length == 0) {
            error = 'Category name is required!';
        } else {
            $('#category option').each(function() {
                if($(this).val() == categoryName) {
                    error = 'Category with that name already exists!';
                    return false;
                }
            });
        }

        if(error) {
            $('#newCategoryName').siblings('span.help-block').text(error);
            $('#newCategoryName').closest('.form-group').addClass('has-error');
            $('#newCategoryName').focus();
        } else {
            $('#category').append('<option value="' + categoryName + '">' + categoryName + '</option>').val(categoryName);
            $('#modalCategory').modal('hide');
        }
    });
});