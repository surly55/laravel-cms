<div class="modal modal-{{ $modalMode or 'default' }} fade" id="modalDelete" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirm delete</h4>
            </div>
            <div class="modal-body">
                <p>{{ $warningMessage or '' }} Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDelete" class="btn btn-danger" type="button">Delete</button>
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>