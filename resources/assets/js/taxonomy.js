$(function() {
    $('#addTerm').on('click', function() {
        var termName = $('#termName').val();
        var termKey = $('#termKey').val();
        var termDescription = $('#termDescription').val();

        $('#tableTerms').append('<tr> \
            <td>' + termName + '<input type="hidden" name="terms[name][]" value="' + termName + '"></td> \
            <td>' + termKey + '<input type="hidden" name="terms[key][]" value="' + termKey + '"></td> \
            <td><button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td> \
        </tr>');

        $('#termName, #termKey, #termDescription').val('');
        $('#termName').focus();
    });

    $('#termName').on('input', function() {
        $('#termKey').val(slugify($(this).val()));
    });

    $('#tableTerms').on('click', 'button.btn-remove', function() {
        $(this).closest('tr').remove();
    });
})