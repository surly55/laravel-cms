@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    $(function() {
        $('.media-list button.btn-delete').on('click', function(e) {
            $('#modalDelete').modal('show', $(this));
            e.stopPropagation();
        });
    });
    </script>
@endsection

@section('content')
    <section class="content-header">
        <h1>Media manager <a class="btn btn-primary btn-xs" href="{{ route('media.upload') }}" style="margin-left: 10px"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;&nbsp;Upload</a></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Media</li>
        </ol>
    </section>

     <section class="content">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Media library</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="messages"></div>
                    <form action="{{ route('media.index') }}" method="GET" class="form-inline" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #f3f3f3">
                        <div class="form-group">
                            <label for="searchCaption">Caption</label>
                            <input type="text" class="form-control" name="caption" id="searchCaption" value="{{ $searchCriteria['caption'] or '' }}">
                        </div>
                        <div class="form-group">
                            <label for="searchCategory">Category</label>
                            <select name="category" id="searchCategory" class="form-control">
                                <option value="" selected="selected">All categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}" @if(isset($searchCriteria['category']) && $searchCriteria['category'] == $category) selected @endif>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        @if(!empty($searchCriteria))
                        <a href="{{ route('media.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Reset</a>
                        @endif
                    </form>

                @if($media->count() > 0)
                    @for($i = 0; $i < count($media); $i++)
                        @if($i%3 == 0 || $i == 0)
                        <div class="row" style="margin-bottom: 30px;">
                        @endif
                        <div class="col-md-4 media-{{ $media[$i]->id }} resource-{{ $media[$i]->id }}">
                            <img class="img-responsive" src="/uploads/thumbnails/{{ $media[$i]->id }}" style="height: 200px;" />
                            <table class="table table-condensed" style="margin-top: 5px">
                                <tr>
                                    <th>Caption</th>
                                    <td>{{ $media[$i]->caption }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>
                                        @if($media[$i]->category)
                                            <a href="{{ route('media.index', [ 'category' => $media[$i]->category ]) }}"> {{ $media[$i]->category }}</a>
                                        @else
                                        <em>Uncategorized</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dimensions</th>
                                    <td>{{ $media[$i]->metadata['width'] }}x{{ $media[$i]->metadata['height'] }}px</td>
                                </tr>
                                <tr>
                                    <th>URL</th>
                                    <td><?php $fullUrl = $media[$i]->storage->options['baseUrl'] . '/' . $media[$i]->filename; ?><a href="{{ $fullUrl }}" target="_blank">{{ $fullUrl }}</a></td>
                                </tr>
                            </table>
                            <div class="pull-right">
                                <a href="{{ route('media.edit', array('id' => $media[$i]->id)) }}" class="btn btn-default"><i class="fa fa-pencil"></i>Edit</a>
                                <button class="btn btn-danger btn-delete" data-resource-id="{{ $media[$i]->id }}" data-delete-url="{{ route('media.destroy', [ 'id' => $media[$i]->id ]) }}"><i class="fa fa-trash"></i>Delete</button>
                            </div>
                        </div>
                        @if(($i+1)%3 == 0)
                        </div>
                        @endif
                    @endfor
                    
                    @include('partials.modal-delete')
            @else
                <div class="alert alert-warning">No media found!</div>
            @endif
            </div>
        </div>
    </section>
@endsection