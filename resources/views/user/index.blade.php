@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('user.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-users"></i>Users <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('user.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create user</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $users->total() }} Users</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($users->count() > 0)
                <form action="{{ route('site.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-users">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-6" data-sort="username" data-order="{{ $sortRule == 'username' ? $sortOrder : 'asc' }}">Username <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-5" data-sort="email" data-order="{{ $sortRule == 'email' ? $sortOrder : 'asc' }}">E-mail <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1">Actions</th>
                        </tr>
                        <tr>
                            <td><input name="username" type="text" class="form-control" value="{{ $search['username'] or '' }}" placeholder="Username" tabindex="2"></td>
                            <td><input name="email" type="text" class="form-control" value="{{ $search['email'] or '' }}" placeholder="E-mail" tabindex="3"></td>
                            <td><button type="submit" class="btn btn-primary btn-block" tabindex="4"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="resource-{{ $user->id }} user-{{ $user->id }}" data-id="{{ $user->id }}">
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default" href="{{ route('user.edit', [ 'id' => $user->id ]) }}" /><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $user->id }}" data-delete-url="{{ route('user.destroy', [ 'id' => $user->id ]) }}"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($users->currentPage()-1)*$users->perPage()+1 }} to {{ ($users->currentPage()-1)*$users->perPage()+$users->count() }} out of {{ $users->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $users->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                @include('partials.modal-delete')
            @else
                <div class="alert alert-warning">No users found!</div>
            @endif
            </div>
        </div>
    </section>
@endsection