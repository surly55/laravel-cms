<?php

namespace App\Fields;

use App\Models\Page;
use App\Models\View;

class ViewSelectField 
{
    const ID = 'view-select';
    const NAME = 'View Select';
    
    public static function render($id, array $field, $data = null) 
    {
        $views = View::orderBy('name')->get();

        $html = view('fields.view-select.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
            'views' => $views,
        ])->render();

        return [
            'id' => $id,
            'html' => $html
        ];
    }

    public static function transform($viewId)
    {
        $view = View::find($viewId);
        $pages = $view->buildQuery()->lists('_id')->toArray();
        
        return [
            'id' => $viewId,
            'pages' => $pages,
        ];
    }

}