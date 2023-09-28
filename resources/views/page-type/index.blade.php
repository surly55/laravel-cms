@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('page-type.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-file-text"></i>Page Types <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('page-type.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create page type</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Page types</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $pageTypes->total() }} Page Types</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($pageTypes->count() > 0)
                <form action="{{ route('page-type.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-page-types">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-1">Actions</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="name" class="form-control" value="{{ $search['name'] or '' }}" placeholder="Name" tabindex="2"></td>
                            <td><button type="submit" class="btn btn-primary btn-block" tabindex="3"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pageTypes as $pageType)
                            <tr class="resource-{{ $pageType->id }} page-type-{{ $pageType->id }}" data-id="{{ $pageType->id }}">
                                <td>{{ $pageType->name }}</td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default" href="{{ route('page-type.edit', [ 'id' => $pageType->id ]) }}"><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $pageType->id }}" data-delete-url="{{ route('page-type.destroy', [ 'id' => $pageType->id ]) }}" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($pageTypes->currentPage()-1)*$pageTypes->perPage()+1 }} to {{ ($pageTypes->currentPage()-1)*$pageTypes->perPage()+$pageTypes->count() }} out of {{ $pageTypes->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $pageTypes->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                @include('partials.modal-delete', [ 'modalMode' => 'danger', 'warningMessage' => 'WARNING! All pages with this page type will no longer be editable!' ])
            @else
                <div class="alert alert-warning">No page types found!</div>
            @endif
        </div>
    </section>
@endsection
