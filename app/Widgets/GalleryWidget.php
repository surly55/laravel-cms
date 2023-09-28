<?php

namespace App\Widgets;

use App\Models\Media;

class GalleryWidget
{
    const ID = 'gallery';
    const NAME = 'Gallery';

    public static function configure(array $data = null) 
    {
        return [
            'requires' => [ 'jqueryui.min.js', 'modal/library.min.js', 'widgets/gallery.min.js' ],
            'form' => view('widget.configure.gallery', [ 'data' => $data ])->render(),
        ];
    }

    public function transform(array $data)
    {
        foreach($data['images'] as &$image) {
            if(!isset($image['source']) || $image['source'] == 'media') {
                $media = Media::findOrFail($image['image']);
                $image['path'] = '/uploads/' . $media->filename;
            }
        }
        
        return $data;
    }
}