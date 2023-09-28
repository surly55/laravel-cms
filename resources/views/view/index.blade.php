@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
<script src="/js/util.min.js"></script>
<script>
var _url = '{{ route('view.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-newspaper-o"></i>Views <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('view.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create view</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Views</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ ($views->total() > 0) ? $views->total() : 'No' }} Views</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($views->count() > 0)
                <form action="{{ route('view.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-pages">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-11" data-sort="name" data-order="{{ $sortRule == 'name' ? invertSortOrder($sortOrder) : 'asc' }}">Name <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1">Actions</th>
                        </tr>
                        <tr>
                            <td><input name="name" type="text" class="form-control" value="{{ $search['name'] or '' }}" placeholder="Name" tabindex="2"></td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-block" tabindex="3"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($views as $view)
                            <tr class="resource-{{ $view->id }} view-{{ $view->id }}" data-id="{{ $view->id }}">
                                <td>{{ $view->name }}</td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default" href="{{ route('view.edit', [ 'id' => $view->id ]) }}" /><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <a href="{{ route('view.duplicate', [ 'id' => $view->id ]) }}" class="btn btn-default"><i class="fa fa-copy"></i><span class="xs-hidden">Duplicate</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $view->id }}" data-delete-url="{{ route('view.destroy', [ 'id' => $view->id ]) }}"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($views->currentPage()-1)*$views->perPage()+1 }} to {{ ($views->currentPage()-1)*$views->perPage()+$views->count() }} out of {{ $views->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $views->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
                
                @include('partials.modal-delete')
            @elseif(empty($search))
                <div class="alert alert-info" role="alert">You don't have any views. <a href="{{ route('view.create') }}">Create your first one!</a></div>
            @else
                <div class="alert alert-warning" role="alert">No views found!</div>
            @endif
        </div>
        </div>
    </section>
@endsection