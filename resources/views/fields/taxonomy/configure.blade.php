<div class="form-group">
    <label>Group</label>
    <select name="configuration[taxonomy]" class="form-control">
        @foreach($taxonomicGroups as $tg)
        <option value="{{ $tg->id }}" @if($tg->id == $data) selected @endif>{{ $tg->name }}</option>
        @endforeach
    </select>
</div>