<div class="form-group field_{{ $id }}">
    <label style="display: block">Featured image</label>
    <input type="hidden" name="content[{{ $id }}]" id="{{ $id }}" value="{{ $data or '' }}">
    <img src="{{ $data !== null ? '/uploads/thumbnails/' . $data : '' }}" style="{{ $data === null ? 'display: none;' : '' }}" class="featured-image">
    <button type="button" class="btn btn-default btn-chose-image">Choose image</button>
    <button type="button" class="btn btn-danger btn-remove-image" style="{{ $data === null ? 'display: none;' : '' }}">Remove image</button>
</div>

@include('partials.modal-library')