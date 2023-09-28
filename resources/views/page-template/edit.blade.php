@extends('layouts.master')

@section('javascripts')
<script src="/js/page-templates.min.js"></script>
@endsection

@section('content')
    {!! Form::model($pageTemplate, [ 'method' => 'PATCH', 'route' => [ 'page-template.update', $pageTemplate->id ], 'id' => 'formPageTemplate', 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit page template <div class="action-buttons"><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('page-template.index') }}">Page templates</a></li>
            <li class="active">Edit <strong>{{ $pageTemplate->name }}</strong></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('page-template._form', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Regions</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('page-template._form-regions', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection