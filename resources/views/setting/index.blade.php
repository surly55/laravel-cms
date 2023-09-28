@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    <section class="content-header">
        <h1>Settings</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="messages"></div>

                <table class="table table-bordered" id="apiKeys">
                    <legend>API keys</legend>
                    <thead>
                        <tr>
                            <th class="col-sm-4">Key</th>
                            <th class="col-sm-5">Secret</th>
                            <th class="col-sm-1">Active</th>
                            <th class="col-sm-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($apiKeys->count())
                            @foreach($apiKeys as $apiKey)
                            <tr>
                                <td>{{ $apiKey->key }}</td>
                                <td>{{ $apiKey->secret }}</td>
                                <td>{{ $apiKey->active }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a class="btn btn-warning" href="#">Deactivate</a>
                                        <a class="btn btn-danger" href="#">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="no-api-key-alert">
                                <td colspan="3"><div class="alert alert-warning">No API keys defined. Add come by using the form below.</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><input class="form-control" type="text" name="api_key" id="apiKey" placeholder="Key" /></td>
                            <td><input class="form-control" type="text" name="api_secret" id="apiSecret" placeholder="Secret" /></td>
                            <td colspan="2">
                                <button type="button" class="btn btn-default" id="generateKey">Generate</a>
                                <button type="button" class="btn btn-primary" id="addKey">Add key</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('javascripts')
    <script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $('#generateKey').click(function() {
            var chars = '0123456789abcdef';
            // Generate key
            var key = '';
            for(var i = 0; i < 32; i++) {
                key += chars[Math.floor(Math.random()*16)];
            }
            $('#apiKey').val(key);
            // Generate secret
            var secret = '';
            for(var i = 0; i < 64; i++) {
                secret += chars[Math.floor(Math.random()*16)];
            }
            $('#apiSecret').val(secret);
        });
        $('#addKey').click(function() {
            $.post('{{ route('setting.add-api-key') }}', { key: $('#apiKey').val(), secret: $('#apiSecret').val() }, function(data) {
                if(data.success) {
                    $('#apiKeys tbody').append('<tr><td>' + data.api_key.key + '</td><td>' + data.api_key.secret + '</td><td>' + data.api_key.active + '</td></tr>');
                    $('#apiKeys tr.no-api-key-alert').remove();
                    $('#apiKey, #apiSecret').val('');
                }
            });
        });
    });
    </script>
@endsection