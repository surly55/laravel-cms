<div class="row form-region">
    <div class="col-sm-6">
        <div class="form-group">
            <input id="regionName" type="text" class="form-control" placeholder="Name">
        </div>
    </div>
    <div class="col-sm-4" style="padding-left: 0">
        <div class="form-group">
            <input id="regionId" type="text" class="form-control" placeholder="ID">
        </div>
    </div>
    <div class="col-sm-2" style="padding-left: 0">
        <button type="button" class="btn btn-default btn-block" id="addRegion"><i class="fa fa-plus"></i> Add</button>
    </div>
</div>

<table id="tableRegions" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
    <thead>
        <tr>
            <th class="col-sm-6">Name</th>
            <th class="col-sm-4">ID</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>
        @if($action == 'create')
        <tr>
            <td>Default<input class="form-control input-sm" name="regions[name][]" type="hidden" value="Default"></td>
            <td>default<input class="form-control input-sm" name="regions[id][]" type="hidden" value="default"></td>
            <td></td>
        </tr>
        @else
            @foreach($pageTemplate->regions as $region)
            <tr>
                <td>{{ $region['name'] }}<input class="form-control input-sm" name="regions[name][]" type="hidden" value="{{ $region['name'] }}"></td>
                <td>{{ $region['id'] }}<input class="form-control input-sm" name="regions[id][]" type="hidden" value="{{ $region['id'] }}"></td>
                <td><button class="btn btn-xs btn-danger btn-remove" type="button">Remove</button></td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>