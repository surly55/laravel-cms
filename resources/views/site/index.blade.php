@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('site.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-globe"></i>Sites <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('site.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create site</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Sites</li>        
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $sites->total() }} Sites</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($sites->count() > 0)
                <form action="{{ route('site.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-sites">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-6" data-sort="name" data-order="{{ $sortRule == 'name' ? $sortOrder : 'asc' }}">Name <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-5" data-sort="domain" data-order="{{ $sortRule == 'name' ? $sortOrder : 'asc' }}">Domain <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1">Actions</th>
                        </tr>
                        <tr>
                            <td><input name="name" type="text" class="form-control" value="{{ $search['name'] or '' }}" placeholder="Name" tabindex="2"></td>
                            <td><input name="domain" type="text" class="form-control" value="{{ $search['domain'] or '' }}" placeholder="Domain" tabindex="3"></td>
                            <td><button type="submit" class="btn btn-primary btn-block" tabindex="4"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sites as $site)
                            <tr class="resource-{{ $site->id }} site-{{ $site->id }}" data-id="{{ $site->id }}">
                                <td>{{ $site->name }}</td>
                                <td><a href="http{{ $site->https === true ? 's' : '' }}://{{ $site->domain }}" target="_blank">{{ $site->domain }}</a></td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default" href="{{ route('site.edit', [ 'id' => $site->id ]) }}"><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger" data-resource-id="{{ $site->id }}" data-delete-url="{{ route('site.destroy', [ 'id' => $site->id ]) }}" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($sites->currentPage()-1)*$sites->perPage()+1 }} to {{ ($sites->currentPage()-1)*$sites->perPage()+$sites->count() }} out of {{ $sites->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $sites->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                @include('partials.modal-delete')
            @else
                <div class="alert alert-warning">No sites found!</div>
            @endif
            </div>
        </div>
    </section>
@endsection