@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('javascripts')
    {!! Html::script('/js/util.min.js') !!}
    <script>

    var _url = '{{ route('menu.show', [ 'id' => '%id%' ]) }}';
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
      <h1><i class="fa fa-bars"></i>Menus&Search <div class="action-buttons"><a class="btn btn-primary btn-xs" href="{{ route('menu.create') }}" tabindex="1"><i class="fa fa-plus" aria-hidden="true"></i>Create menu or search</a></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Menus&Search</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
              Menues & Searches
            </div>
            <div class="box-body">
            <div class="messages"></div>
            @if(1==1)
               <form action="{{ route('menu.index') }}" method="GET">
               <table class="table table-striped table-hover table-bordered table-resources table-menus">
                   <thead>
                       <tr style="text-transform: uppercase;">
                           <th class="col-sm-4" data-sort="title" >Title <i class="fa fa-sort pull-right"></i></th>
                           <th class="col-sm-4" data-sort="type" >Type <i class="fa fa-sort pull-right"></i></th>
                           <th class="col-sm-4" data-sort="locale" >Actions <i class="fa fa-sort pull-right"></i></th>
                      </tr>

                   </thead>
                   <tbody>

                       @foreach($search as $sh)
                            <tr class="resource-{{ $sh->id }} search-{{ $sh->id  }}" data-id="{{ $sh->id  }}">
                                 <td>{{ $sh->title }}</td>
                                 <td>search</td>
                                 <td>
                                   <a class="btn btn-default" href="{{ route('menu.edit', [ 'id' => $sh->id ]) }}"><i class="fa fa-pencil"></i><span class="xs-hidden">Edit</span></a>
                                   <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $sh->id }}" data-delete-url="{{ route('menu.destroy', [ 'id' => $sh->id ]) }}"><i class="fa fa-trash"></i><span class="xs-hidden">Delete</span></button>
                                 </td>
                             </tr>
                        @endforeach
                        @foreach($menu as $mu)
                             <tr class="resource-{{ $sh->id }} search-{{ $sh->id  }}" data-id="{{ $sh->id  }}">
                                  <td>{{ $mu->title }}</td>
                                  <td>{{ $mu->type }}</td>
                                  <td>
                                    <a class="btn btn-default" href="{{ route('menu.edit', [ 'id' => $sh->id ]) }}"><i class="fa fa-pencil"></i><span class="xs-hidden">Edit</span></a>
                                    <button type="button" class="btn btn-danger btn-delete" data-resource-id="{{ $sh->id }}" data-delete-url="{{ route('menu.destroy', [ 'id' => $sh->id ]) }}"><i class="fa fa-trash"></i><span class="xs-hidden">Delete</span></button>
                                  </td>
                              </tr>
                         @endforeach
                   </tbody>
               </table>
               </form>
               <div class="row">
                   <div class="col-sm-7" style="padding-top: 5px">
                  </div>
                   <div class="col-sm-5">
                       <div class="pagination-wrapper">
                       </div>
                   </div>
               </div>

               @include('partials.modal-delete')
           @else
               <div class="alert alert-warning">No menus found!</div>
           @endif

          </div> <!-- end of box-body-->
        </div>

    </section>

@endsection
