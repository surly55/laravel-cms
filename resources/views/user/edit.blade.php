@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>Edit user <small>{{ $user->username }}</small></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('user.index') }}">Users</a></li>
            <li class="active">Edit user</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">User details</h3>
            </div>
            {!! Form::model($user, [ 'method' => 'PATCH', 'route' => [ 'user.update', $user->id ], 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
            <div class="box-body">@include('user._form', [ 'action' => 'edit' ])</div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-file"></i> Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection