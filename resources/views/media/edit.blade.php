@extends('layouts.master')

@section('javascripts')
<script src="/js/media.min.js"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-photo"></i> Edit media</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('media.index') }}">Media</a></li>
            <li class="active">Edit media <strong>{{ $media->caption }}</strong></li>
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
            {!! Form::model($media, [ 'method' => 'PATCH', 'route' => [ 'media.update', $media->id ], 'class' => 'form', 'role' => 'form' ]) !!}
            <div class="box-body">
                <div class="form-group {{ $errors->has('caption') ? 'has-error' : '' }}">
                    <label for="caption">Caption</label>
                    <input name="caption" id="caption" type="text" class="form-control" tabindex="1" value="{{ old('caption', $media->caption) }}">
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
                        <option value="" @if($media->category == null) selected @endif></option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" @if($media->category == $category) selected @endif>{{ $category }}</option>
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

                <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-file"></i> Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>

    @include('media.modal.category')
@endsection
