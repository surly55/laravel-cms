@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>Create user</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('user.index') }}">Users</a></li>
            <li class="active">Create user</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">User details</h3>
            </div>
            {!! Form::open([ 'route' => 'user.store', 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
            <div class="box-body">@include('user._form', [ 'action' => 'create' ])</div>

            <div class="box-body">
                <label for="localeLocale">Permissions</label>
                <select id="localeLocale" class="form-control">
                    <option value="0" selected disabled>-- Select --</option>
                    <option>Admin</option>
                    <option>User</option>
                </select>
            </div>

            <div class="box-body">
                <label for="localeLocale">Sites</label>
                <select id="localeLocale" class="form-control">
                    <option value="0" selected disabled>-- Select --</option>
                    <option></option>
                    <option></option>
                </select>
            </div>

            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection
