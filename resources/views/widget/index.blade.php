@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('widget.show', [ 'id' => '%id%' ]) }}';
    $(function() {
        $('.table-resources tr[data-id]').on('click', function() {
            window.location = _url.replace('%id%', $(this).data('id'));
        });
        $('.table-resources button.btn-delete').on('click', function(e) {
            $('#modalDelete').modal('show', $(this));
            e.stopPropagation();
        });
    });
    </script>
@endsection

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-th"></i>Widgets <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('widget.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create widget</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Widgets</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $widgets->total() }} Widgets</h3>
            </div>
            <div class="box-body">
                <div class="messages"></div>

                @if($widgets->count() > 0)
                    <form action="{{ route('widget.index') }}" method="GET">
                    <table class="table table-striped table-hover table-bordered table-resources table-widgets">
                        <thead>
                            <tr style="text-transform: uppercase;">
                                <th class="col-sm-5" data-sort="name" data-order="">Name <i class="fa fa-sort pull-right"></i></th>
                                <th class="col-sm-3" data-sort="type" data-order="">Type <i class="fa fa-sort pull-right"></i></th>
                                <th class="col-sm-2" data-sort="updated_at" data-order="">Updated <i class="fa fa-sort pull-right"></i></th>
                                <th class="col-sm-2">Actions</th>
                            </tr>
                            <tr>
                                <td><input name="name" type="text" class="form-control" value="{{ $search['name'] or '' }}" placeholder="Name" tabindex="2"></td>
                                <td>
                                    <select name="type" class="form-control" tabindex="3">
                                        <option value="">All</option>
                                        @foreach($types as $id => $type)
                                        <option value="{{ $id }}" @if(isset($search['type']) && $search['type'] == $id) selected @endif>{{ $type['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td></td>
                                <td><button type="submit" class="btn btn-primary btn-block" tabindex="6"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($widgets as $widget)
                                <tr class="resource-{{ $widget->id }} widget-{{ $widget->id }}" data-id="{{ $widget->id }}">
                                    <td>{{ $widget->name }}</td>
                                    <td>{{ $types[$widget->type]['name'] }}</td>
                                    <td>{{ $widget->updated_at->format('d.m.Y H:i') }}</td>
                                    <td style="padding-top: 4px; padding-bottom: 4px">
                                        <div class="btn-group btn-group-sm" style="display: flex;">
                                          
                                          <a class="btn btn-default" href="{{ route('widget.edit', [ 'id' => $widget->id ]) }}"><i class="fa fa-pencil"></i><span class="xs-hidden">Edit</span></a>
                                            <a href="{{ route('widget.duplicate', [ 'id' => $widget->id ]) }}" class="btn btn-default"><i class="fa fa-copy"></i><span class="xs-hidden">Duplicate</span></a>
                                          <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $widget->id }}" data-delete-url="{{ route('widget.destroy', [ 'id' => $widget->id ]) }}"><i class="fa fa-trash"></i><span class="xs-hidden">Delete</span></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </form>

                    <div class="row">
                        <div class="col-sm-7" style="padding-top: 5px">
                            <span>Showing {{ ($widgets->currentPage()-1)*$widgets->perPage()+1 }} to {{ ($widgets->currentPage()-1)*$widgets->perPage()+$widgets->count() }} out of {{ $widgets->total() }} results</span>
                        </div>
                        <div class="col-sm-5">
                            <div class="pagination-wrapper">
                                {!! $widgets->appends(Input::except('page'))->render() !!}
                            </div>
                        </div>
                    </div>

                    @include('partials.modal-delete')
                @else
                    <div class="alert alert-warning">No widgets found!</div>
                @endif
            </div>
        </div>
    </section>
@endsection
