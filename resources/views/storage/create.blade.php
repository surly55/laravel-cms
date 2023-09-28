@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>Create storage</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('storage.index') }}">Storages</a></li>
            <li class="active">Create storage</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Storage data</h3>
            </div>
            {!! Form::open([ 'route' => 'storage.store', 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
            <div class="box-body">@include('storage._form', [ 'action' => 'create' ])</div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection