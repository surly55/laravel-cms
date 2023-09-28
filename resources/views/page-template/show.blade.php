@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>View page template <small>{{ $pageTemplate->name }}</small><a class="btn btn-primary btn-xs" href="{{ route('page-template.edit', [ 'id' => $pageTemplate->id ]) }}" style="margin-left: 10px"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;&nbsp;Edit</a></h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Details</h3>
        </div>

        <div class="box-body">
            <dl>
                <dt>ID</dt>
                <dd>{{ $pageTemplate->id }}</dd>
                <dt>Name</dt>
                <dd>{{ $pageTemplate->name }}</dd>
            </dl>      
        </div>
    </div>
</section>
@endsection