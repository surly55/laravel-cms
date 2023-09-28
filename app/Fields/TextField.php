<?php

namespace App\Fields;

class TextField 
{
    const ID = 'text';
    const NAME = 'Text';
    
    public static function render($id, array $field, $data = null) 
    {
        $html = view('fields.text.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
        ])->render();

        return [
            'id' => $id,
            'html' => $html
        ];
    }

}