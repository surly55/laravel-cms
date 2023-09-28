<?php

namespace App\Widgets;

class PromotionWidget
{
    const ID = 'list';
    const NAME = '8. List widget';

    public static function configure(array $data = null)
    {
        return [
            'form' => view('widget.configure.promotion', [ 'data' => $data ])->render(),
        ];
    }
}
