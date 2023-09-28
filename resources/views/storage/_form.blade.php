{!! input('name', 'text', isset($storage->name) ? $storage->name : '', 'Name', [ 'tabindex' => 1 ]) !!}
{!! select('type', $storageTypes, null, 'Type', [ 'tabindex' => 2 ]) !!}
<fieldset>
    <legend>Options</legend>
    {!! input('options[host]', 'text', '', 'Host') !!}
    {!! input('options[port]', 'text', '', 'Port') !!}
    {!! input('options[username]', 'text', '', 'Username') !!}
    {!! input('options[password]', 'password', '', 'Password') !!}
    {!! input('options[baseUrl]', 'text', '', 'Base URL') !!}
</fieldset>