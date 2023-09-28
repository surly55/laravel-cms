<?php

namespace App\Widgets;

class ContentBlockWidget
{
    const ID = 'text-widget';
    const NAME = '5. Text widget';

    public static function configure()
    {
        return [
            'form' => view('widget.configure.content-block')->render(),
        ];
    }
}
