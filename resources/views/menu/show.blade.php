@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>View menu <small>{{ $menu->title }}</small><a class="btn btn-primary btn-xs" href="{{ route('menu.edit', [ 'id' => $menu->id ]) }}" style="margin-left: 10px"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;&nbsp;Edit</a></h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Menu information</h3>
        </div>

        <div class="box-body">
            <dl>
                <dt>ID</dt>
                <dd>{{ $menu->id }}</dd>
                <dt>Title</dt>
                <dd>{{ $menu->title }}</dd>
                <dt>Site</dt>
                <dd>{{ $menu->site->name }}</dd>
            </dl>      
        </div>
    </div>
</section>
@endsection