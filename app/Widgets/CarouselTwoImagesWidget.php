<?php

namespace App\Widgets;

class CarouselTwoImagesWidget
{
    const ID = 'carouseltwocolumns-widget';
    const NAME = '3. CarouselTwoImages widget';

    public static function configure()
    {
        return [
            'form' => view('widget.configure.carouseltwoimages')->render(),
        ];
    }
}
