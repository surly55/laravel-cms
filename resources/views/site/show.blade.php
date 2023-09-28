@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>View site <small>{{ $site->name }}</small><a class="btn btn-primary btn-xs" href="{{ route('site.edit', [ 'id' => $site->id ]) }}" style="margin-left: 10px"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;&nbsp;Edit</a></h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Site information</h3>
        </div>

        <div class="box-body">
            <dl>
                <dt>ID</dt>
                <dd>{{ $site->id }}</dd>
                <dt>Name</dt>
                <dd>{{ $site->name }}</dd>
                <dt>Domain</dt>
                <dd>{{ $site->domain }}</dd>
            </dl>  

            <table class="table table-bordered table-condensed">
                <caption>Locales</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Locale</th>
                        <th>Type</th>
                        <th>URL prefix/subdomain</th>
                        <th>Active</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($site->locales as $locale)
                    <tr>
                        <td>{{ $locale->_id }}</td>
                        <td>{{ $locale->name }}</td>
                        <td>{{ $locale->locale->name }} ({{ $locale->locale->code }})</td>
                        @if($locale->type == 'url_prefix')
                        <td>URL prefix</td>
                        <td>{{ $locale->url_prefix }}</td>
                        @elseif($locale->type == 'subdomain')
                        <td>Subdomain</td>
                        <td>{{ $locale->subdomain }}</td>
                        @endif
                        <td>{{ $locale->active == 1 ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>    
        </div>
    </div>
</section>
@endsection