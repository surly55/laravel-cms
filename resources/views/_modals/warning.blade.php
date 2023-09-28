<div class="modal modal-{{ $modal['type'] or 'default' }} fade" id="{{ $modal['id'] or 'modalWarning' }}" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> {{ $modal['title'] or 'Confirm action' }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ $modal['message'] or 'Are you sure you want to continue?' }}</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-continue" type="button"><i class="fa fa-exclamation"></i>Continue</button>
                <button class="btn btn-default btn-cancel" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>