<?php

namespace App\Widgets;

class CarouselWidget
{
    const ID = 'carousel-widget';
    const NAME = '4. Carousel widget';

    public static function configure()
    {
        return [
            //'form' => view('widget.configure.content-block')->render(),
            'form' => view('widget.configure.carousel')->render(),
        ];
    }
}
