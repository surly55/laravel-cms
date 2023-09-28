<?php

namespace App\Widgets;

use App\Models\Media;

class NicheWidget
{
    const ID = 'niche';
    const NAME = 'Niche';

    public static function configure(array $data = null) 
    {
        return [
            'requires' => [ 'modal/library.min.js', 'widgets/niche.min.js' ],
            'form' => view('widget.niche.configure', [ 'data' => $data ])->render(),
        ];
    }

    public static function transform(array $data)
    {
        $background = Media::findOrFail($data['background']);
        $data['background'] = '/uploads/' . $background->filename;
        
        return $data;
    }
}