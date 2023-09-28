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
    <input type="number" name="data[amount]" class="form-control" value="{{ isset($data['amount']) ? $data['amount'] : '3' }}">
</div>