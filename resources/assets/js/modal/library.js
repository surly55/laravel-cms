var chosenImage = {}, imageCount = 0;

$(document).on('show.bs.modal', '#libraryModal', function(e) {
    var $modal = $(this);
    console.log($modal.data('loaded'));
    if($modal.data('loaded') == false) {
        $('#libraryModal .overlay').show();
        $.get('/media', function(response) {
            $('#libraryModal .modal-body .media').empty();
            for(var i = 0; i < response.media.length; i++) {
                $('#libraryModal .modal-body .media').append('<div class="col-sm-4"><img class="img-responsive img-media" src="/uploads/thumbnails/' + response.media[i]._id + '" data-id="' + response.media[i]._id + '" /><span class="caption">' + response.media[i].caption + '</span></div>');
            }
            for(var i = 0; i < response.categories.length; i++) {
                $('#libraryModal .modal-body select.media-category').append('<option value="' + response.categories[i] + '">' + response.categories[i] + '</option>');
            }
            var pages = Math.ceil(response.total/6);
            var pagesToShow = pages < 5 ? pages : 5;
            if(pages > 1) {
                for(var i = 1; i <= pagesToShow; i++) {
                    $('#libraryModal ul.pagination li.next').before('<li><a href="#">' + i + '</a></li>');
                }
            }
            $('#libraryModal .overlay').hide();
            $modal.data('loaded', true);
        });
    }
});

$(document).on('click', '#libraryModal ul.pagination a', function(e) {
    e.preventDefault();
    var skip = 0;
    if($(this).hasClass('prev')) {
        skip = $('#libraryModal').data('skip')-6;
    } else if($(this).hasClass('next')) {
        skip = $('#libraryModal').data('skip')+6;
    } else {
        skip = (parseInt($(this).text())-1)*6;
    }

    $('#libraryModal').data('skip', skip);
    $('#libraryModal .overlay').show();
    $.get('/media', { category: $('#libraryModal .media-category').val(), 'skip': skip }, function(response) {
        $('#libraryModal .modal-body .media').empty();
        for(var i = 0; i < response.media.length; i++) {
            $('#libraryModal .modal-body .media').append('<div class="col-sm-4"><img class="img-responsive img-media" src="/uploads/thumbnails/' + response.media[i]._id + '" data-id="' + response.media[i]._id + '" /><span class="caption">' + response.media[i].caption + '</span></div>');
        }
        for(var i = 0; i < response.categories.length; i++) {
            $('#libraryModal .modal-body select.media-category').append('<option value="' + response.categories[i] + '">' + response.categories[i] + '</option>');
        }
        var pages = Math.ceil(response.total/6);
        var pagesToShow = pages < 5 ? pages : 5;
        if(pages > 1) {
            $('#libraryModal ul.pagination li').not('.prev, .next').remove();
            for(var i = 1; i <= pagesToShow; i++) {
                $('#libraryModal ul.pagination li.next').before('<li><a href="#">' + i + '</a></li>');
            }
        }
        $('#libraryModal .overlay').hide();
    });
});

$(document).on('change', '#libraryModal .media-category', function() {
    $('#libraryModal .overlay').show();
    $.get('/media', { category: $(this).val(), caption: $('#libraryModal .media-search').val() }, function(response) {
        $('#libraryModal .modal-body .media').empty();
        for(var i = 0; i < response.media.length; i++) {
            $('#libraryModal .modal-body .media').append('<div class="col-sm-4"><img class="img-responsive img-media" src="/uploads/thumbnails/' + response.media[i]._id + '" data-id="' + response.media[i]._id + '" /><span class="caption">' + response.media[i].caption + '</span></div>');
        }
        $('#libraryModal .overlay').hide();
    });
});

$(document).on('keypress', '#libraryModal .media-search', function(e) {
    if(e.which == 13) {
        e.preventDefault();
        e.stopPropagation();
        $('#libraryModal .overlay').show();
        $.get('/media', { caption: $(this).val(), category: $('#libraryModal .media-category').val() }, function(response) {
            $('#libraryModal .modal-body .media').empty();
            for(var i = 0; i < response.media.length; i++) {
                $('#libraryModal .modal-body .media').append('<div class="col-sm-4"><img class="img-responsive img-media" src="/uploads/thumbnails/' + response.media[i]._id + '" data-id="' + response.media[i]._id + '" /><span class="caption">' + response.media[i].caption + '</span></div>');
            }
            $('#libraryModal .overlay').hide();
        });
    }
});

$(document).on('click', '#libraryModal .img-media', function() {
    $('#libraryModal .img-media').css('border', 'none');
    $(this).css('border', '3px solid orange');
    chosenImage = {
        image: $(this).data('id'),
        caption: $(this).siblings('.caption').text()
    };
});