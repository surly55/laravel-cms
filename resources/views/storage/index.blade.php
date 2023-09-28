@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('storage.show', [ 'id' => '%id%' ]) }}';
    $(function() {
        $('.table-resources tr[data-id]').on('click', function() {
            window.location = _url.replace('%id%', $(this).data('id'));
        });
        $('.table-resources button[data-toggle="modal"]').on('click', function(e) {
            $($(this).data('target')).modal();
            e.stopPropagation();
        });
    });
    </script>
@endsection

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-hdd-o"></i>Storages <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('storage.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>Create storage</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Storages</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $storages->total() }} Storages</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($storages->count() > 0)
                <form action="{{ route('storage.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-storages">
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th class="col-sm-6">Name</th>
                            <th class="col-sm-5">Type</th>
                            <th class="col-sm-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($storages as $storage)
                            <tr class="resource-{{ $storage->id }} storage-{{ $storage->id }}" data-id="{{ $storage->id }}">
                                <td>{{ $storage->name }}</td>
                                <td>{{ $storage->type }}</td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex;">
                                        <a class="btn btn-default" href="{{ route('storage.edit', [ 'id' => $storage->id ]) }}"><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger" data-resource-id="{{ $storage->id }}" data-delete-url="{{ route('storage.destroy', [ 'id' => $storage->id ]) }}" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($storages->currentPage()-1)*$storages->perPage()+1 }} to {{ ($storages->currentPage()-1)*$storages->perPage()+$storages->count() }} out of {{ $storages->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $storages->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                @include('partials.modal-delete')
            @else
                <div class="alert alert-warning">No storages found!</div>
            @endif
            </div>
        </div>
    </section>
@endsection