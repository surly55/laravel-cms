@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>User <small>Details</small></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('user.index') }}">Users</a></li>
            <li class="active">User details</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $user->username }}</h3>
            </div>
            <div class="box-body">
                <dl>
                    <dt>ID</dt>
                    <dd>{{ $user->id }}</dd>
                    <dt>Username</dt>
                    <dd>{{ $user->username }}</dd>
                    <dt>E-mail</dt>
                    <dd><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
                </dl>
            </div>
            <div class="box-footer">
                <a class="btn btn-primary" href="{{ route('user.edit', [ 'id' => $user->id ]) }}"><i class="fa fa-pencil"></i> Edit</a>
            </div>
        </div>
    </section>
@endsection