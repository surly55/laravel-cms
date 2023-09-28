@extends('layouts.master')

@section('content')
    {!! Form::open([ 'route' => 'menu.store', 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-plus"></i>Create menu <div class="action-buttons"><button class="btn btn-primary" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('menu.index') }}">Menus</a></li>
            <li class="active">Create</li>
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
                    <div class="box-body">@include('menu._form', [ 'action' => 'create' ])</div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="box box-default box-items">
                    <div class="box-header with-border">
                        <h3 class="box-title">Items</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">@include('menu._form-items', [ 'action' => 'create' ])</div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection

@section('javascripts')
<script src="/js/jqueryui.min.js"></script>
<script src="/js/typeahead.bundle.min.js"></script>
<script src="/js/lodash.min.js"></script>
<script src="/js/util.min.js"></script>
<script src="/js/menus-functions.js"></script>
<script>
var itemCount = 0;
</script>
@endsection
