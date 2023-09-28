@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>Widget type <small>{{ $widgetType->name }}</small></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('widget-type.index') }}">Widget types</a></li>
            <li class="active">View widget type</li>
        </ol>
    </section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Widget type data</h3>
        </div>

        <div class="box-body">
            <dl>
                <dt>ID</dt>
                <dd>{{ $widgetType->id }}</dd>
                <dt>Name</dt>
                <dd>{{ $widgetType->name }}</dd>
                <dt>URI</dt>
                <dd>{{ $widgetType->uri }}</dd>
                <dt>Description</dt>
                <dd>{{ $widgetType->description }}</dd>
            </dl>      
        </div>
    </div>
</section>
@endsection