<?php

namespace App\Widgets;

class EventsWidget
{
    const ID = 'events';
    const NAME = 'Events';

    public static function configure(array $data = null) 
    {
        return [
            'form' => view('widget.configure.events', [ 'data' => $data ])->render(),
        ];
    }
}