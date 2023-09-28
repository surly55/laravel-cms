$(function() {
    $('.btn-chose-image').on('click', function() {
        $('#libraryModal').modal('show');
    });

    $('#libraryModal .btn-primary').on('click', function() {
        if(chosenImage.length !== 0) {
            $('#widgetBackground').val(chosenImage.image);
            $('#widgetBackground').siblings('img.background-image').attr('src', '/uploads/thumbnails/' + chosenImage.image).show();
            self.chosenImage = {};
            $('#libraryModal').modal('hide');
        }
    });
})