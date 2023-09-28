@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>Widget <small>Details</small></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('widget.index') }}">Widgets</a></li>
            <li class="active">Widget details</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $widget->name }}</h3>
            </div>
            <div class="box-body">
                <dl>
                    <dt>ID</dt>
                    <dd>{{ $widget->id }}</dd>
                    <dt>Name</dt>
                    <dd>{{ $widget->name }}</dd>
                    <dt>Site</dt>
                    <dd>{{ $widget->site->name }}</dd>
                    <dt>Type</dt>
                    <dd>{{ $widget->type->name }}</dd>
                </dl>
            </div>
            <div class="box-footer">
                <a class="btn btn-primary" href="{{ route('widget.edit', [ 'id' => $widget->id ]) }}"><i class="fa fa-pencil"></i> Edit</a>
            </div>
        </div>
    </section>
@endsection