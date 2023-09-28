<?php

namespace App\Widgets;

use App\Models\Media;

class SliderWidget
{
    const ID = 'slider';
    const NAME = 'Slider';

    public static function configure(array $data = null)
    {
        return [
            'requires' => [ 'modal/library.min.js', 'widgets/slider.min.js' ],
            'form' => view('widget.slider.form', [ 'data' => $data ])->render(),
        ];
    }

    public static function transform(array $data)
    {
        foreach($data['slides'] as &$slide) {
            $media = Media::findOrFail($slide['image']);
            $slide['image'] = '/uploads/' . $media->filename;
        }
        
        return $data;
    }
}