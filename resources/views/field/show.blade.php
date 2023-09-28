@extends('layouts.master')

@section('content')
    {!! Form::open([ 'route' => 'field.store', 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-tasks"></i>Field <small>{{ $field->name }}</small></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('field.index') }}">Fields</a></li>
            <li class="active">Show</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                </div>
            </div>
            <div class="box-body">
                <dt>Name</dt>
                <dd>{{ $field->name }}</dd>
            </div>
        </div>
    </section>
@endsection