@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('translation.show', [ 'id' => '%id%' ]) }}';
    $(function() {
        $('.table-resources tr[data-id]').on('click', function() {
            window.location = _url.replace('%id%', $(this).data('id'));
        });
        $('.table-resources button.btn-delete').on('click', function(e) {
            $('#modalDelete').modal('show', $(this));
            e.stopPropagation();
        });
    });
    </script>
@endsection

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-flag"></i>Translations <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('translation.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create translation</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Translations</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $translations->total() }} Translations</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($translations->count() > 0)
                <form action="{{ route('translation.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-translations">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-3" data-sort="key" data-order="{{ $sortRule == 'key' ? $sortOrder : 'asc' }}">Key <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-7" data-sort="source" data-order="{{ $sortRule == 'source' ? $sortOrder : 'asc' }}">Source <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1" data-sort="site" data-order="{{ $sortRule == 'site' ? $sortOrder : 'asc' }}">Site <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1">Actions</th>
                        </tr>
                        <tr>
                            <td><input name="key" type="text" class="form-control" value="{{ $search['key'] or '' }}" placeholder="Key" tabindex="2"></td>
                            <td><input name="source" type="text" class="form-control" value="{{ $search['source'] or '' }}" placeholder="Source" tabindex="3"></td>
                            <td>
                                <select name="site" class="form-control" tabindex="5">
                                    <option value="">Any</option>
                                    @foreach($sites as $site) 
                                    <option value="{{ $site->_id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><button type="submit" class="btn btn-primary btn-block" tabindex="6"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($translations as $translation)
                            <tr class="resource-{{ $translation->id }} translation-{{ $translation->id }}" data-id="{{ $translation->id }}">
                                <td>{{ $translation->key }}</td>
                                <td>{{ $translation->source }}</td>
                                <td>{{ $translation->site->name }}</td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default" href="{{ route('translation.edit', [ 'id' => $translation->id ]) }}" /><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $translation->id }}" data-delete-url="{{ route('translation.destroy', [ 'id' => $translation->id ]) }}"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($translations->currentPage()-1)*$translations->perPage()+1 }} to {{ ($translations->currentPage()-1)*$translations->perPage()+$translations->count() }} out of {{ $translations->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $translations->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
                
                @include('partials.modal-delete')
            @else
                <div class="alert alert-warning">No translations found!</div>
            @endif
        </div>
        </div>
    </section>
@endsection