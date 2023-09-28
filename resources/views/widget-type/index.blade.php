@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('widget-type.show', [ 'id' => '%id%' ]) }}';
    $(function() {
        $('.table-resources tr[data-id]').on('click', function() {
            window.location = _url.replace('%id%', $(this).data('id'));
        });
        $('.table-resources button[data-toggle="modal"]').on('click', function(e) {
            $($(this).data('target')).modal();
            e.stopPropagation();
        });
    });
    </script>
@endsection

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-th"></i>Widget Types <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('widget-type.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>Create widget type</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Widget types</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $widgetTypes->total() }} Widget Types</h3>
            </div>
            <div class="box-body">
                <div class="messages"></div>

                @if($widgetTypes->count() > 0)
                    <form action="{{ route('widget-type.index') }}" method="GET">
                    <table class="table table-striped table-hover table-bordered table-resources table-widget-types">
                        <thead style="text-transform: uppercase;">
                            <tr>
                                <th class="col-sm-6">Name</th>
                                <th class="col-sm-5">URI</th>
                                <th class="col-sm-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($widgetTypes as $widgetType)
                                <tr class="resource-{{ $widgetType->id }} widget-type-{{ $widgetType->id }}" data-id="{{ $widgetType->id }}">
                                    <td>{{ $widgetType->name }}</td>
                                    <td>{{ $widgetType->uri }}</td>
                                    <td style="padding-top: 4px; padding-bottom: 4px">
                                        <div class="btn-group btn-group-sm" style="display: flex;">
                                            <a class="btn btn-default" href="{{ route('widget-type.edit', [ 'id' => $widgetType->id ]) }}"><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                            <button type="button" class="btn btn-danger" data-resource-id="{{ $widgetType->id }}" data-delete-url="{{ route('widget-type.destroy', [ 'id' => $widgetType->id ]) }}" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </form>

                    <div class="row">
                        <div class="col-sm-7" style="padding-top: 5px">
                            <span>Showing {{ ($widgetTypes->currentPage()-1)*$widgetTypes->perPage()+1 }} to {{ ($widgetTypes->currentPage()-1)*$widgetTypes->perPage()+$widgetTypes->count() }} out of {{ $widgetTypes->total() }} results</span>
                        </div>
                        <div class="col-sm-5">
                            <div class="pagination-wrapper">
                                {!! $widgetTypes->appends(Input::except('page'))->render() !!}
                            </div>
                        </div>
                    </div>
                
                    @include('partials.modal-delete')
                @else
                    <div class="alert alert-warning">No widget types found!</div>
                @endif
            </div>
        </div>
    </section>
@endsection