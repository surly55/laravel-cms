@extends('layouts.master')

@section('content')
    {!! Form::model($widget, [ 'method' => 'PATCH', 'route' => [ 'widget.update', 'id' => $widget->id ], 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit widget <div class="action-buttons"><button class="btn btn-primary" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('widget.index') }}">Widgets</a></li>
            <li class="active">Edit <strong>{{ $widget->name }}</strong></li>
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
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="widget.details"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">@include('widget._form')</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Configuration</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>            
                    <div class="box-body">
                        <fieldset class="widget">
                            <div class="text-center loading"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection

@section('javascripts')
<script src="/js/widgets.min.js"></script>
<script src="/js/util.min.js"></script>
<script>
var routeURL = "{{ route('widget.configure', array('type' => '%TYPE%')) }}";
var sites = {!! json_encode($sites) !!};

$(function() {
    loadWidget('{{ $widget->id }}');
});
</script>
@endsection