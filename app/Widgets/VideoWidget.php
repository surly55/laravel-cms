<?php

namespace App\Widgets;

class VideoWidget
{
    const ID = 'video';
    const NAME = 'Video';

    public static function configure(array $data = null) 
    {
        return [
            'form' => view('widget.configure.video', [ 'data' => $data ])->render(),
        ];
    }
}