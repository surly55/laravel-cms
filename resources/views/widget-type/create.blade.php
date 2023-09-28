@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>Create widget type</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('widget-type.index') }}">Widget types</a></li>
            <li class="active">Create widget type</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Widget type data</h3>
            </div>
            {!! Form::open([ 'route' => 'widget-type.store', 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
            <div class="box-body">@include('widget-type._form', [ 'action' => 'create' ])</div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection