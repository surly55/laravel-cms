@extends('layouts.master')

@section('javascripts')
<script src="/js/typeahead.bundle.min.js"></script>
<script src="/js/sites.min.js"></script>
@endsection

@section('content')
    {!! Form::model($site, [ 'method' => 'PATCH', 'route' => [ 'site.update', $site->id ], 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-globe-pencil"></i>Edit site <div class="action-buttons"><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('site.index') }}">Sites</a></li>
            <li class="active">Edit <strong>{{ $site->name }}</strong></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid box-primary box-site-details">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="site.details"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form', [ 'action' => 'edit' ])
                    </div>
                </div>

                <div class="box box-site-locales">
                    <div class="box-header with-border">
                        <h3 class="box-title">Locales</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-locales', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="display:none;">
                <div class="box box-default box-site-options">
                    <div class="box-header with-border">
                        <h3 class="box-title">Options</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-options', [ 'action' => 'edit' ])
                    </div>
                </div>

                <div class="box box-default box-site-layout">
                    <div class="box-header with-border">
                        <h3 class="box-title">Layout</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="site.layout"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-layout', [ 'action' => 'edit' ])
                    </div>
                </div>

                <div class="box box-default box-site-layout">
                    <div class="box-header with-border">
                        <h3 class="box-title">Widgets</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('widget.create') }}" target="_blank" class="btn btn-xs btn-default">Create widget</a>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="site.widgets"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-widgets', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection
