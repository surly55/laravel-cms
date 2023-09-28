@extends('layouts.master')

@section('javascripts')
<script src="/js/util.min.js"></script>
<script src="/js/views.min.js"></script>
@endsection

@section('content')
    {!! Form::model($view, [ 'method' => 'PATCH', 'route' => [ 'view.update', $view->id ], 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit view <div class="action-buttons"><button class="btn btn-primary" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('view.index') }}">Views</a></li>
            <li class="active">Edit <strong>{{ $view->name }}</strong></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>                    
                    <div class="box-body">@include('view.forms.details', [ 'action' => $action ])</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Criteria</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>                    
                    <div class="box-body">@include('view.forms.criteria', [ 'action' => $action ])</div>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Display</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>                    
                    <div class="box-body">@include('view.forms.display', [ 'action' => $action ])</div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection