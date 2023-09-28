<div class="row">
	<div class="col-sm-12">
			<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
				<label for="type">Menu</label>
				<select name="type" id="type" class="form-control">
          <option value="menu_top">Top menu</option>
          <option value="menu_main">Main menu</option>
          <option value="search">Search</option>
				</select>
				<!--<input name="title" id="title" type="text" class="form-control" tabindex="1" value="{{ old('title', $action == 'edit' ? $menu->title : '') }}">
			-->
				@if($errors->has('title'))
					<span class="help-block">
					@foreach($errors->get('title') as $message)
						{{ $message }}
					@endforeach
					</span>
				@endif
			</div>
	</div>

  <div class="col-sm-12">
    	<div class="form-group">
        <label for="title">Title</label>
        <input id="title" name="title" type="text" class="form-control" placeholder="Title">
      </div>
  </div>

</div>

<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
				<label for="locale">Locale</label>
				<select name="site_locale_id" id="locale" class="form-control" tabindex="3" data-locale="{{ ($action == 'edit') ? $menu->site_locale_id : '' }}">
				@foreach($locales as $locale)
						<option value="{{ $locale->_id }}">{{ $locale->name }} ({{ $locale->code }})</option>
				@endforeach
				</select>
		</div>
	</div>
</div>


@section('style')
.flash-error {
    animation-name: pulse-error;
    animation-duration: .3s;
    animation-direction: alternate;
    animation-iteration-count: 6;
    animation-play-state: paused;
}

@keyframes pulse-error {
    0% {
        background-color: #FFF;
    }
    100% {
        background-color: #FFE9E9;
    }
}

.box-items .twitter-typeahead {
    width: 100%;
}
@endsection
