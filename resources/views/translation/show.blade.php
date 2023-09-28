@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-flag"></i>Translation <small>{{ $translation->key }}</small></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('translation.index') }}">Translations</a></li>
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
                <dl>
                    <dt>Key</dt>
                    <dd>{{ $translation->key }}</dd>
                    <dt>Source</dt>
                    <dd>{{ $translation->source }}</dd>
                    <dt>Site</dt>
                    <dd>{{ $translation->site->name }}</dd>
                </dl>

                <dl>
                    @foreach($translation->translations as $locale => $trans)
                    <dt>{{ $locale }}</dt>
                    <dd>{{ empty($trans) ? 'No translation!' : $trans }}</dd>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>
@endsection