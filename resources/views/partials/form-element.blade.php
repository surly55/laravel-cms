<div class="form-group {{ $errors->has($input['name']) ? 'has-error' : '' }}">
    {!! Form::label($input['name'], $input['label'], [ 'class' => 'col-sm-2 control-label' ]) !!}
    <div class="col-sm-10">
        @if($input['type'] == 'password')
        {!! Form::password($input['name'], [ 'class' => 'form-control', 'tabindex' => $input['index'] ]) !!}
        @elseif($input['type'] == 'select')
        {!! Form::select($input['name'], $input['data'], $input['selected'],  [ 'class' => 'form-control', 'tabindex' => $input['index'] ]) !!}
        @else
        {!! Form::{$input['type']}($input['name'], null, [ 'class' => 'form-control', 'tabindex' => $input['index'] ]) !!}
        @endif
        @if($errors->has($input['name']))
            <span class="help-block">
            @foreach($errors->get($input['name']) as $message)
                {{ $message }}
            @endforeach
            </span>
        @endif
    </div>
</div>