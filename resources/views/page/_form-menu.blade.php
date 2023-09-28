<fieldset class="metadata">
  <label for="menues">Menu</label>
    <div class="row">
        <div class="col-sm-10">
            <select class="form-control" id="itemPageMenu">
              <option value="0" disabled>Select...</option>
              @foreach($menu as $mu)
              <option value="{{ $mu->_id }}">{{ $mu->title }}</option>
              @endforeach
            </select>
        </div>
        <div class="col-sm-2" style="padding-left: 0">
            <button type="button" class="btn btn-default btn-block" id="addMenuOnPage"><i class="fa fa-plus"></i> Add</button>
        </div>
    </div>
    <table id="tableMenuItems" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
        <thead>
            <tr>
                <th class="col-sm-6">Name</th>
                <th class="col-sm-6">-</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


  <br>
  <label for="searches">Search</label>
  <div class="row">
      <div class="col-sm-10">
        <select class="form-control" id="itemPageSearch">
          <option value="0" disabled>Select...</option>
          @foreach($search as $sh)
          <option value="{{ $sh->_id }}">{{ $sh->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2" style="padding-left: 0">
          <button type="button" class="btn btn-default btn-block" id="addSearchOnPage"><i class="fa fa-plus"></i> Add</button>
      </div>
  </div>
  <table id="tableSearchItems" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
      <thead>
          <tr>
              <th class="col-sm-6">Name</th>
              <th class="col-sm-6">-</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
</fieldset>
