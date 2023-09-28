<div class="form-group">
    <label>Title</label>
    <input type="text" name="data[title]" class="form-control" value="{{ isset($data['title']) ? $data['title'] : '' }}">
</div>

<div class="form-group">
    <label>Text</label>
    <input type="text" name="data[text]" class="form-control" value="{{ isset($data['text']) ? $data['text'] : '' }}">
</div>

<div class="form-group">
    <label style="display: block;">Background image</label>
    <input id="widgetBackground" type="hidden" name="data[background]" value="{{ isset($data['background']) ? $data['background'] : '' }}">
    <img src="{{ $data['background'] !== null ? '/uploads/thumbnails/' . $data['background'] : '' }}" style="{{ $data['background'] === null ? 'display: none;' : '' }}" class="background-image">
    <button type="button" class="btn btn-default btn-chose-image">Choose image</button>
</div> 

<div class="form-group">
    <label>Product type ID</label>
    <input type="text" name="data[product_type_id]" class="form-control" value="{{ isset($data['product_type_id']) ? $data['product_type_id'] : '' }}">
</div>

<div class="form-group">
    <label>Interest ID</label>
    <input type="text" name="data[interest_id]" class="form-control" value="{{ isset($data['interest_id']) ? $data['interest_id'] : '' }}">
</div>

<div class="form-group">
    <label>Amount to show</label>
    <input type="number" name="data[amount]" class="form-control" value="{{ isset($data['amount']) ? $data['amount'] : '1' }}">
</div>

@include('partials.modal-library')