<div class="row">
    <div class="col-sm-4">
      <select id="widgetId" class="form-control">
        <option value="0" disabled>-- Select --</option>
        @foreach($widgets as $w){
          <option value="{{ $w->_id}}">{{ $w->name}}</option>
        }
        @endforeach
      </select>


    </div>
    <div class="col-sm-4">
        <select id="widgetGroup" class="form-control">
            <option value="1">Main</option>
            <option value="2">Sidebar</option>
        </select>
    </div>
    <div class="col-sm-2" style="padding-left: 0">
        <input id="widgetWeight" type="number" class="form-control" min="1" max="100" value="50" placeholder="Weight">
    </div>
    <div class="col-sm-2" style="padding-left: 0">
        <button type="button" class="btn btn-default btn-block" id="addWidget"><i class="fa fa-plus"></i> Add</button>
    </div>
</div>

<table id="tableWidgets" class="table table-striped table-bordered table-condensed" style="margin-top: 10px">
    <thead>
        <tr>
            <th class="col-sm-4">Widget</th>
            <th class="col-sm-4">Region</th>
            <th class="col-sm-2">Weight</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>



    </tbody>
</table>
