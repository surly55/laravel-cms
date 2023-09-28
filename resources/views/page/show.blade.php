@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>View page <small>{{ $page->title }}</small></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Page information</h3>
            </div>

            <div class="box-body">
                <dl>
                    <dt>ID</dt>
                    <dd>{{ $page->id }}</dd>
                    <dt>Title</dt>
                    <dd>{{ $page->title }}</dd>
                    <dt>URL</dt>
                    <dd>{{ $page->url }}</dd>
                    <dt>Type</dt>
                    <dd><a href="{{ route('page-type.show', $page->type->_id) }}">{{ $page->type->name }}</a></dd>
                    <dt>Site</dt>
                    <dd><a href="{{ route('site.show', $page->site->_id) }}">{{ $page->site->name }}</a></dd>
                </dl>
            </div>
        </div>
    </section>
@endsection
