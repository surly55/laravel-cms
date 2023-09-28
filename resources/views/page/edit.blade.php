@extends('layouts.master')

@section('javascripts')
<script src="/js/handlebars.min.js"></script>
<script src="/js/typeahead.bundle.min.js"></script>
<script src="/js/util.min.js"></script>
<script src="/js/pages.min.js"></script>
<script>
var routeURL = "{{ route('page-type.render', [ 'id' => '_id_', 'page' => $page->id ]) }}";
var siteUrl = "{{ route('site.show', [ 'id' => '_id_' ]) }}";
var sites = {!! json_encode($sites) !!};
var pageId = "{{ $page->id }}";
$(function() {
    $('#locale').on('change', function() {
        var siteId = $('#site_id').val();
        var locale = $(this).val();
        $('#type_id').find('option').remove();
        if(sites[siteId].page_types !== null) {
            var options = '';
            sites[siteId].page_types.forEach(function(pt) {
                if(pt.site_locale_ids.indexOf(locale) !== -1) {
                    options += '<option value="' + pt._id + '">' + pt.name + '</option>';
                }
            });
            $('#type_id').append(options).trigger('change').parent().show();
        } else {
            $('#type_id').parent().hide();
        }
    });
});
</script>
@endsection

@section('content')
    {!! Form::model($page, [ 'method' => 'PATCH', 'route' => [ 'page.update', $page->id ], 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit page <div class="action-buttons"><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('page.index') }}">Pages</a></li>
            <li class="active">Edit <strong>{{ $page->title }}</strong></li>
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
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>                    
                    <div class="box-body">@include('page._form', [ 'action' => 'edit' ])</div>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Fields</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <fieldset class="fields">
                            <div class="text-center loading"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Widgets</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">@include('page._form-widgets', [ 'action' => 'edit' ])</div>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Metadata</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">@include('page._form-metadata', [ 'action' => 'edit' ])</div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection

@section('modals')
    @include('_modals.warning', [ 
        'modal' => [
            'id' => 'modalWarningType',
            'title' => 'Confirm page type change',
            'message' => 'Changing the page type will result in loss of all content and attached widgets. Are you sure you want to continue?',
        ]
    ])
@endsection