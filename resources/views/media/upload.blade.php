@extends('layouts.master')

@section('javascripts')
<script src="/js/media.min.js"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-photo"></i> Upload media</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('media.index') }}">Media</a></li>
            <li class="active">Upload media</li>
        </ol>
    </section>

    <section class="content">
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Media data</h3>
            </div>
            {!! Form::open([ 'route' => 'media.store', 'class' => 'form', 'role' => 'form', 'files' => true ]) !!}
            <div class="box-body">
                <div class="form-group {{ $errors->has('storage_id') ? 'has-error' : '' }}">
                    <label for="storage_id">Storage</label>
                    <select name="storage_id" id="storage_id" class="form-control">
                        @foreach($storages as $id => $name)
                        <option value="{{ $id }}" @if(old('storage_id') == $id)selected="selected"@endif>{{ $name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('storage_id'))
                        <span class="help-block">
                            @foreach($errors->get('storage_id') as $message)
                                {{ $message }}
                            @endforeach
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('caption') ? 'has-error' : '' }}">
                    <label for="caption">Caption</label>
                    <input name="caption" id="caption" type="text" class="form-control" tabindex="1" value="{{ old('caption', '') }}">
                    @if($errors->has('caption'))
                        <span class="help-block">
                        @foreach($errors->get('caption') as $message)
                            {{ $message }}
                        @endforeach
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                    <label for="category" style="display: block;">Category</label>
                    <select name="category" id="category" class="form-control" tabindex="2" style="width: auto; min-width: 200px; display: inline-block">
                        <option value="" selected="selected"></option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="addCategory" class="btn btn-success" data-toggle="modal" data-target="#modalCategory">New category</button>
                    @if($errors->has('category'))
                        <span class="help-block">
                        @foreach($errors->get('category') as $message)
                            {{ $message }}
                        @endforeach
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('upload_file') ? 'has-error' : '' }}">
                    <label for="upload_file">File <a href="#" data-toggle="tooltip" data-placement="right" title="Filename will be sanitized, all unsupported characters will be removed, spaces will be replaced by _."><i class="fa fa-question-circle"></i></a></label>
                    <input type="file" name="upload_file" id="upload_file" tabindex="3">
                    @if($errors->has('upload_file'))
                        <span class="help-block">
                        @foreach($errors->get('upload_file') as $message)
                            {{ $message }}
                        @endforeach
                        </span>
                    @endif
                </div>

                <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-upload"></i> Upload</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>

    @include('media.modal.category')
@endsection
