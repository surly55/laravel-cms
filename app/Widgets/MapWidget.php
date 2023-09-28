<?php

namespace App\Widgets;

class MapWidget
{
    const ID = 'map-widget';
    const NAME = '7. Map widget';

    public static function configure()
    {
        return [
            //'form' => view('widget.configure.content-block')->render(),
            'form' => view('widget.configure.map')->render(),
        ];
    }
}
