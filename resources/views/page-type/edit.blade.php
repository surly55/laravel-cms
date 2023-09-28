@extends('layouts.master')

@section('javascripts')
<script src="/js/typeahead.bundle.min.js"></script>
<script src="/js/jqueryui.min.js"></script>
<script src="/js/util.min.js"></script>
<script src="/js/page-types.min.js"></script>
<script>
var sites = {!! json_encode($sites) !!};
var templates = {!! json_encode($pageTemplates) !!};
$(function() {
    $('#site_id').on('change', function() {
        loadLocalesNew($(this).val(), '#locales');
        $('#locales option').prop('selected', true);
    });
});
</script> 
@endsection

@section('content')
    {!! Form::model($pageType, [ 'method' => 'PATCH', 'route' => [ 'page-type.update', $pageType->id ], 'id' => 'formPageType', 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit page type <div class="action-buttons"><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('page-type.index') }}">Page types</a></li>
            <li class="active">Edit <strong>{{ $pageType->name }}</strong></li>
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
                        @include('page-type._form', [ 'action' => 'edit' ])
                    </div>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Templates</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('page-type._form-templates', [ 'action' => 'edit' ])
                    </div>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Widgets</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('page-type._form-widgets', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Fields</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('page-type._form-fields', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}

    @include('page-type._modal-no-fields')
@endsection