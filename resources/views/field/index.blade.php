@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('field.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-tasks"></i>Items <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('field.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create item</a></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Items</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ $fields->total() }} Fields</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if($fields->count() > 0)
                <form action="{{ route('field.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources">
                  <thead>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Action</th>
                    <th>Preview</th>
                  </thead>
                  <tbody>
                        @foreach($fields as $field)
                            <tr class="resource-{{ $field->id }}" data-id="{{ $field->id }}">
                                <td>{{ $field->name }}</td>
                                <td>
                                  @if($field->type==1)
                                    Header
                                  @endif
                                  @if($field->type==2)
                                    Footer
                                  @endif
                                </td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex;">
                                        <a class="btn btn-default " href="{{ route('field.edit', [ 'id' => $field->id ]) }}"><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $field->id }}" data-delete-url="{{ route('field.destroy', [ 'id' => $field->id ]) }}"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" style="display: flex;">
                                      <button type="button" class="btn btn-info btn-info" data-resource-id="{{ $field->id }}" data-delete-url="{{ route('field.preview', [ 'id' => $field->id ]) }}"><i class="fa fa-eye"></i><span class="hidden-xs">Preview</span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($fields->currentPage()-1)*$fields->perPage()+1 }} to {{ ($fields->currentPage()-1)*$fields->perPage()+$fields->count() }} out of {{ $fields->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $fields->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                @include('partials.modal-delete')
            @else
                <div class="alert alert-warning">No items found!</div>
            @endif
            </div>
        </div>
    </section>
@endsection
