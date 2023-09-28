@extends('layouts.master')

@section('content')
    {!! Form::model($translation, [ 'method' => 'PATCH', 'route' => [ 'translation.update', 'id' => $translation->id ], 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit translation <div class="action-buttons"><button class="btn btn-primary" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('translation.index') }}">Translations</a></li>
            <li class="active">Edit <strong>{{ $translation->key }}</strong></li>
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
                    <div class="box-body">@include('translation._form', [ 'action' => 'edit' ])</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Translations</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>            
                    <div class="box-body">@include('translation._form-translations', [ 'action' => 'edit' ])</div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection

@section('javascripts')
<script>
var sitesLocales = {
    @foreach($sites as $site)
    '{{ $site->_id }}': 
        @if(isset($site->locales) && !empty($site->locales))
            {
            @foreach($site->locales as $lc)
                '{{ $lc['code'] }}': '{{ $lc['name'] }}',
            @endforeach
            }
        @else
            null
        @endif
    ,
    @endforeach
}

function loadTranslations(siteId)
{
    $('fieldset.translations').html('');
    if(sitesLocales[siteId] !== null) {
        Object.keys(sitesLocales[siteId]).forEach(function(k) {
            $('fieldset.translations').append('<div class="form-group">Locale: <strong>' + sitesLocales[siteId][k] + '</strong><textarea name="translations[' + k + ']" class="form-control" rows="5"></textarea></div>');
        });
    }
}

$(function() {
    $('#site_id').on('change', function() {
        loadTranslations($('#site_id').val());
    });
});
</script>
@endsection