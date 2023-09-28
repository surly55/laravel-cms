@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('taxonomy.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-book"></i>Taxonomy <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('taxonomy.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create group</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Taxonomy</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ ($taxonomicGroups->total() > 0) ? $taxonomicGroups->total() : 'No' }} Groups</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($taxonomicGroups->count() > 0)
                <form action="{{ route('taxonomy.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-taxonomy">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-10" data-sort="name" data-order="{{ $sortRule == 'name' ? invertSortOrder($sortOrder) : 'asc' }}">Name <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1" data-sort="updated_at" data-order="{{ $sortRule == 'updated_at' ? invertSortOrder($sortOrder) : 'desc' }}">Updated <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1">Actions</th>
                        </tr>
                        <tr>
                            <td><input name="name" type="text" class="form-control" value="{{ $search['name'] or '' }}" placeholder="Name" tabindex="2"></td>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-block" tabindex="3"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taxonomicGroups as $tg)
                            <tr class="resource-{{ $tg->id }}" data-id="{{ $tg->id }}">
                                <td>{{ $tg->name }}</td>
                                <td>{{ $tg->updated_at->format('d.m.Y. H:i') }}</td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default " href="{{ route('taxonomy.edit', [ 'id' => $tg->id ]) }}" /><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $tg->id }}" data-delete-url="{{ route('taxonomy.destroy', [ 'id' => $tg->id ]) }}"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($taxonomicGroups->currentPage()-1)*$taxonomicGroups->perPage()+1 }} to {{ ($taxonomicGroups->currentPage()-1)*$taxonomicGroups->perPage()+$taxonomicGroups->count() }} out of {{ $taxonomicGroups->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $taxonomicGroups->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
                
                @include('partials.modal-delete')
            @elseif(empty($search))
                <div class="alert alert-info" role="alert">You don't have any groups. <a href="{{ route('taxonomy.create') }}">Create your first one!</a></div>
            @else
                <div class="alert alert-warning" role="alert">No groups found!</div>
            @endif
        </div>
        </div>
    </section>
@endsection