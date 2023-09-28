<?php

namespace App\Widgets;

class SerpListWidget
{
    const ID = 'serp-widget';
    const NAME = '9. SerpList widget';

    public static function configure()
    {
        return [
            //'form' => view('widget.configure.content-block')->render(),
            'form' => view('widget.configure.serp-list')->render(),
        ];
    }
}
