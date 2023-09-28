<?php

namespace App\Widgets;

class AccomodationCardsWidget
{
    const ID = 'accomodationcards-widget';
    const NAME = '1. AccomodationCards widget';

    public static function configure()
    {
        return [
            //'form' => view('widget.configure.content-block')->render(),
            'form' => view('widget.configure.accomodationcards')->render(),
        ];
    }
}
