<div class="modal fade" id="libraryModal" role="dialog" tabindex="-1" data-loaded="false" data-skip="0">
    <div class="modal-dialog overlay-wrapper">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4>Choose image from library</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <select class="form-control media-category">
                                <option value="-1">-- All categories --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control media-search" placeholder="Search" />
                        </div>
                    </div>
                </div>
                <div class="row media">Loading...</div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6" style="text-align: left">
                        <nav>
                            <ul class="pagination" style="margin: 0">
                                <li class="prev"><a class="prev" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                <li class="next"><a class="next" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-choose-image" type="button">Choose image</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>
</div>