@extends('layouts.master')

@section('javascripts')
<script src="/js/taxonomy.min.js"></script>
<script src="/js/transliteration.min.js"></script>
@endsection

@section('content')
    {!! Form::open([ 'route' => 'taxonomy.store', 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-plus"></i>Create group <div class="action-buttons"><button class="btn btn-primary" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('taxonomy.index') }}">Taxonomy</a></li>
            <li class="active">Create group</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                @if(count($errors) > 0)
                <div class="box box-solid box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Errors</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <dl style="margin-bottom: 0">
                            @foreach($errors->getMessages() as $input => $errorMessages)
                                <dt>{{ $input }}</dt>
                                <dd>{{ implode(' ', $errorMessages) }}</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>
                @endif

                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">@include('taxonomy.forms.details', [ 'action' => 'create' ])</div>

                    <div>SHARE</div>
                      <div>CURENCIES</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Terms</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">@include('taxonomy.forms.terms', [ 'action' => 'create' ])</div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection
