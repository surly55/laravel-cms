<?php

namespace App\Widgets;

class TwoColumnCardsWidget
{
    const ID = 'twocolumncards-widget';
    const NAME = '10. TwoColumnCards widget';

    public static function configure()
    {
        return [
            //'form' => view('widget.configure.content-block')->render(),
            'form' => view('widget.configure.twocolumncards')->render(),
        ];
    }
}
