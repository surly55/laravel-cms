<div id="menu-items-div">
<div class="form-group">
    <label for="itemMainTitle">Title</label>
    <input id="itemMainTitle" type="text" class="form-control" placeholder="Title">
</div>

<div class="form-group">
    <label for="itemMainPath">Path (URL)</label>
    <input id="itemMainPath" type="text" class="form-control" placeholder="#">
</div>

<div class="form-group">
    <label for="itemType">Type</label>
    <select id="itemType" class="form-control">
        <option value="main-menu">Main Menu</option>
        <option value="sub-menu">Menu lv 1</option>
      <!--  <option value="sub-sub-menu">Menu lv 2</option> -->
      <!--  <option value="page" >Page</option> -->
        <option value="url" selected>URL</option>
    </select>
</div>

<div class="form-group" id="sub-menu-parent" style="display:none;">
    <label for="itemParent">Parent</label>
    <select id="itemParent" class="form-control">
      <option value="0" disabled>Select ...</option>
    </select>
</div>

<div class="form-group" id="sub-sub-menu-parent" style="display:none;">
    <label for="itemSubParent">Sub parent</label>
    <select id="itemSubParent" class="form-control">
        <option value="0" disabled>Select ...</option>
    </select>
</div>


<div class="form-group" >
    <div class="item-wrapper" style="display: none">
        <label for="itemPageLookup">Page</label>
        <input id="itemPageLookup" type="text" class="form-control typeahead" placeholder="Page">
    </div>
    <div class="item-wrapper" style="display: none">
        <label for="itemMenuLookup">Menu</label>
        <input id="itemMenuLookup" type="text" class="form-control typeahead" placeholder="Menu">
    </div>
    <div class="item-wrapper" style="display: none">
        <label for="itemLink">URL/Action</label>
        <input id="itemLink" type="text" class="form-control" placeholder="Link">
    </div>
</div>

<div class="form-group" style="display: none">
    <label for="itemTags">Tags</label>
    <input id="itemTags" type="text" class="form-control" placeholder="Tags">
</div>

<div class="form-group">
    <div class="action-add">
        <button  type="button" class="btn btn-default" id="addItem"><i class="fa fa-plus"></i> Add</button>
    </div>
    <div class="action-save" style="display: none">
        <button type="button" class="btn btn-success" id="saveItem"><i class="fa fa-pencil"></i> Save</button>
        <button type="button" class="btn btn-default" id="cancelItem"><i class="fa fa-times"></i> Cancel</button>
    </div>
</div>

<table id="tableItems" class="table table-bordered table-condensed table-hover">
    <thead>
        <tr style="text-transform: uppercase;">
            <th class="col-sm-3">Title</th>
            <th class="col-sm-3">Link</th>
            <th class="col-sm-2">Parent</th>
            <th class="col-sm-2">Type</th>
            <th class="col-sm-2">-</th>
        </tr>
    </thead>
    <tbody>
        @if($action == 'edit' && !empty($menu->items))
            <?php $itemCount = 0; ?>
            @foreach($menu->items as $item)
                @if($item['type'] == 'page' && !$item->page)
                    <?php continue; ?>
                @endif
                <tr data-item="{{ $itemCount }}">
                    <td>
                        <i class="fa fa-arrows-v handle"></i>
                        <span>{{ $item['label'] }}</span>
                        <input type="hidden" name="items[{{ $itemCount }}][position]" value="{{ $item['position'] }}" data-position="{{ $item['position'] }}">
                        <input name="items[{{ $itemCount }}][label]" type="hidden" value="{{ $item['label'] }}" data-attr="label">
                    </td>
                    <td>
                        <span>{{ $item['type'] }}</span>
                        <input name="items[{{ $itemCount }}][type]" type="hidden" value="{{ $item['type'] }}" data-attr="type"></td>
                    <td>
                        @if($item['type'] == 'page' && $item->page)
                        <span data-page="{{ $item->page->title }}">Page: <a href="{{ route('page.show', $item->page->id) }}" target="_blank">{{ $item->page->title }}</a></span>
                        @elseif($item['type'] == 'menu' && $item->menu() != null)
                        <span data-menu="{{ $item->menu()->title }}">Menu: <a href="{{ route('menu.show', $item->menu()->id) }}" target="_blank">{{ $item->menu()->title }}</a></span>
                        @else
                        <span>{{ $item['link'] }}</span>
                        @endif
                        <input name="items[{{ $itemCount }}][link]" type="hidden" value="{{ $item['link'] }}" data-attr="link">
                    </td>
                    <td>
                        <input name="items[{{ $itemCount }}][tags]" type="hidden" value="{{ $item['tags'] or '' }}" data-attr="tags">
                        <input name="items[{{ $itemCount }}][labelHtml]" type="hidden" value="{{ $item['labelHtml'] or '' }}" data-attr="labelHtml">
                        <button type="button" class="btn btn-xs btn-default btn-edit">Edit</button>
                        <button type="button" class="btn btn-xs btn-danger btn-remove">Remove</button>
                    </td>
                </tr>
                <?php $itemCount++; ?>
            @endforeach
        @endif
    </tbody>
</table>
</div>

<!-- SEARCH ITEM PART -->
<div id="search-items-div" style="display:none;">
  <div class="form-group">
    <label for="searchCollapsed">Collapsed</label>
    <select id="searchCollapsed" name="searchCollapsed" class="form-control">
        <option value="0">True</option>
        <option value="1">False</option>
    </select>
    <br>

    <div class="form-group">
      <label for="itemSearchLocation">Location</label>
      <input id="itemSearchLocation" name="itemSearchLocation" type="text" class="form-control" placeholder="Location">
      <br>
      <label for="itemSearchAccomodation">Accomodation</label>
      <input id="itemSearchAccomodation" name="itemSearchAccomodation" type="text" class="form-control" placeholder="Accomodation type">
      <br>
      <label for="itemSearchFrom">From</label>
      <input id="itemSearchFrom" name="itemSearchFrom" type="date" class="form-control" placeholder="From">
      <br>
      <label for="itemSearchTo">To</label>
      <input id="itemSearchTo" name="itemSearchTo" type="date" class="form-control" placeholder="To">
      <br>
      <label for="itemSearchAdults"># Adults</label>
      <input id="itemSearchAdults" name="itemSearchAdults" type="number" class="form-control" placeholder="Number of adults">
      <br>
      <label for="itemSearchKids"># Kids</label>
      <input id="itemSearchKids" name="itemSearchKids" type="number" class="form-control" placeholder="Number of kids">

  </div>
  </div>



</div>
