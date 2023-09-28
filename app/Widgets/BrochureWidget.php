<?php

namespace App\Widgets;

class BrochureWidget
{
    const ID = 'brochure-widget';
    const NAME = '2. Brochure widget';

    public static function configure()
    {
        return [
            //'form' => view('widget.configure.content-block')->render(),
            'form' => view('widget.configure.brochure')->render(),
        ];
    }
}
