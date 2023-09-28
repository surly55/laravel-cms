Fields.image = {
    self: this,
    chosenImage: null,
    init: function(id, options) {
        $('.btn-chose-image').on('click', function() {
            $('#libraryModal').modal('show');
        });

        $('#libraryModal .btn-primary').on('click', function() {
            if(self.chosenImage.length !== 0) {
                $('#' + id).val(self.chosenImage.image);
                $('#' + id).siblings('img.featured-image').attr('src', '/uploads/thumbnails/' + self.chosenImage.image).show();
                self.chosenImage = {};
                $('#libraryModal').modal('hide');
            }
        });

        $('.btn-remove-image').on('click', function() {
            $('#' + id).val('').siblings('img.featured-image').attr('src', '').hide();
        });
    }
}