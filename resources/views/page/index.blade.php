@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>
    var _url = '{{ route('page.show', [ 'id' => '%id%' ]) }}';
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
        <h1><i class="fa fa-file-text"></i>Pages <div id="create_page_div" class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('page.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create page</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pages</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ ($pages->total() > 0) ? $pages->total() : 'No' }} Pages</h3>
            </div>
            <div class="box-body">
            <div class="messages"></div>

            @if(isset($hasSites))
            @if(!$hasSites)
            <script>document.getElementById("create_page_div").style.display="none";</script>
            @endif
            @endif
            @if($pages->count() > 0)
                <form action="{{ route('page.index') }}" method="GET">
                <table class="table table-striped table-hover table-bordered table-resources table-pages">
                    <thead>
                        <tr style="text-transform: uppercase;">
                          <?php
                          $sorter = "desc";

                            if($sortOrder=="asc"){
                              $sorter = "desc";

                            }
                            if($sortOrder=="desc"){
                              $sorter = "asc";
                            }
                          ?>
                            <th class="col-sm-3 th-title" data-order="{{$sorter}}" data-sort="title">Title <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-2 th-title" data-order="{{$sorter}}" data-sort="url" >URL <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1 th-title" data-order="{{$sorter}}" data-sort="site" >Site <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1 th-title" data-order="{{$sorter}}" data-sort="locale" >Locale <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1 th-title" data-order="{{$sorter}}" data-sort="updated_at" >Updated <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1 th-title" data-order="{{$sorter}}" data-sort="published" >Publish <i class="fa fa-sort pull-right"></i></th>
                            <th class="col-sm-1">Duplicate</th>
                            <th class="col-sm-1">Actions</th>
                            <th class="col-sm-1">Prevew</th>

                        </tr>
                        <tr>
                            <td><input name="title" type="text" class="form-control" value="{{ $search['title'] or '' }}" placeholder="Title" tabindex="2"></td>
                            <td><input name="url" type="text" class="form-control" value="{{ $search['url'] or '' }}" placeholder="URL" tabindex="3"></td>
                            <td>

                            </td>
                            <td>
                                <select name="site" class="form-control" tabindex="5">
                                    <option value="">Any</option>
                                    @foreach($sites as $site)
                                    <option value="{{ $site->_id }}" @if(isset($search['site']) && $search['site'] == $site->_id) selected @endif>{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="locale" id="locale" class="form-control" tabindex="6">
                                    <option value="">Any</option>
                                    @foreach($locales as $code => $name)
                                    <option value="{{ $code }}" @if(isset($search['locale']) && $search['locale'] == $code) selected @endif>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-block" tabindex="6"><i class="fa fa-search"></i><span class="hidden-xs">Search</span></button>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr class="resource-{{ $page->id }} site-{{ $page->id }}" data-id="{{ $page->id }}">
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->url }}</td>

                                <td>{{ $page->site->name }}</td>
                                <td>{{ $page->locale->name or '' }}</td>
                                <td>{{ $page->updated_at->format('d.m.Y. H:i') }}</td>
                                <td>
                                  @if($page->published==1)
                                    Published
                                  @endif
                                  @if($page->published==0)
                                    Not Published
                                  @endif
                                </td>
                                  <td style="padding-top: 4px; padding-bottom: 4px">
                                      <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-info " href="{{ route('page.duplicate', [ 'id' => $page->id ]) }}" /><i class="fa fa-copy"></i><span class="hidden-xs">Duplicate</span></a>
                                      </div>
                                  </td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                        <a class="btn btn-default " href="{{ route('page.edit', [ 'id' => $page->id ]) }}" /><i class="fa fa-pencil"></i><span class="hidden-xs">Edit</span></a>
                                        <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $page->id }}" data-delete-url="{{ route('page.destroy', [ 'id' => $page->id ]) }}"><i class="fa fa-trash"></i><span class="hidden-xs">Delete</span></button>
                                    </div>
                                </td>
                                <td style="padding-top: 4px; padding-bottom: 4px">
                                    <div class="btn-group btn-group-sm" style="display: flex">
                                      <a class="btn btn-info " href="{{ route('page.preview', [ 'id' => $page->id ]) }}" /><i class="fa fa-eye"></i><span class="hidden-xs">Preview</span></a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>

                <div class="row">
                    <div class="col-sm-7" style="padding-top: 5px">
                        <span>Showing {{ ($pages->currentPage()-1)*$pages->perPage()+1 }} to {{ ($pages->currentPage()-1)*$pages->perPage()+$pages->count() }} out of {{ $pages->total() }} results</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="pagination-wrapper">
                            {!! $pages->appends(Input::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                @include('partials.modal-delete')
            @elseif(empty($search))
                <div class="alert alert-info" role="alert">You don't have any pages.
                    @if(!$hasSites)
                    But first, you need to <a href="{{ route('site.create') }}">create a site</a>!
                    @elseif(!$hasPageTypes)

                    @else
                    <a href="{{ route('page.create') }}">Create your first one!</a></div>
                    @endif
            @else
                <div class="alert alert-warning" role="alert">No pages found!</div>
              @endif
        </div>
        </div>
    </section>
@endsection
