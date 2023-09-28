<?php

namespace App\Fields;

class WysiwygField 
{
    const ID = 'wysiwyg';
    const NAME = 'WYSIWYG';

    public static function render($id, array $field, $data = null) 
    {
        $html = view('fields.wysiwyg.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
        ])->render();

        return [
            'id' => $id,
            'requires' => [ 'ckeditor/ckeditor.js', 'fields/wysiwyg.min.js' ],
            'html' => $html,
            'init' => 'wysiwyg',
            'globals' => [
                'CKEDITOR_BASEPATH' => '/js/ckeditor/',
            ]
        ];
    }
}