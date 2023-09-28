<?php

namespace App\Fields;

use App\Models\Media;

class ImageField 
{
    const ID = 'image';
    const NAME = 'Image';
    
    public static function render($id, array $field, $data = null) 
    {
        $html = view('fields.image.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
        ])->render();

        return [
            'id' => $id,
            'requires' => [ 'modal/library.min.js', 'fields/image.min.js' ],
            'html' => $html,
            'init' => 'image',
        ];
    }

    public function transform($mediaId)
    {
        $media = Media::find($mediaId);
        if($media) {
            return '/uploads/' . $media->filename;
        }
        return null;
    }
}