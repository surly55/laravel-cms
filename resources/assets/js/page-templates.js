$(function() {
    $('#regionName').on('input', function() {
        var regionId = $(this).val().trim();
        if(regionId.length > 0) {
            regionId = regionId.toLowerCase().replace(/[^a-z0-9_]/gi, '_').replace(/_+/g, '_').replace(/^_|_$/g, '');
        }
        $('#regionId').val(regionId);
    });

    $('#addRegion').on('click', function() {
        $('.box-site-layout .form-region .form-group').removeClass('has-error');

        var regionName = $('#regionName').val().trim();
        if(regionName.length == 0) {
            console.log('Region name is missing!');
            $('#regionName').val('').focus().tooltip({
                title: 'Region name is required!',
                delay: { 'hide': 100 }
            }).tooltip('show').parent().addClass('has-error');
            return;
        }

        var regionId = $('#regionId').val().trim();
        if(regionId.length == 0) {
            console.log('Region ID is missing!');
            $('#regionId').val('').focus().tooltip({
                title: 'Region ID is required!',
                delay: { 'hide': 100 }
            }).tooltip('show').parent().addClass('has-error');
            return;
        }

        if(!/^[a-z0-9_]+$/i.test(regionId)) {
            console.log('Region ID is incorrect!');
            $('#regionId').val('').focus().tooltip({
                title: 'Region ID can only contain alphanumeric characters and underscores!',
                delay: { 'hide': 100 }
            }).tooltip('show').parent().addClass('has-error');
            return;
        }

        $('#tableRegions').append('<tr> \
            <td><input class="form-control" type="hidden" name="regions[name][]" value="' + regionName + '">' + regionName + '</td> \
            <td><input class="form-control" type="hidden" name="regions[id][]" value="' + regionId + '">' + regionId + '</td> \
            <td><button type="button" class="btn btn-xs btn-default btn-update" data-action="edit">Edit</button> <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button></td> \
        </tr>');

        $('#regionName, #regionId').val('');
        $('#regionName').focus();
    });

    $('#tableRegions').on('click', 'button.btn-remove', function() {
        $(this).closest('tr').remove();
    });

    $('#tableRegions').on('click', 'button.btn-update', function() {
        $(this).toggleClass('btn-default btn-success');
        switch($(this).data('action')) {
            case 'edit':
                $(this).text('Save').data('action', 'save').closest('tr').find('input').each(function() {
                    $(this).closest('td').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                    $(this).attr('type', 'text');
                });
                break;
            case 'save':
                $(this).text('Edit').data('action', 'edit').closest('tr').find('input').each(function() {
                    $(this).attr('type', 'hidden').closest('td').append($(this).val());
                });
        }
    });
});