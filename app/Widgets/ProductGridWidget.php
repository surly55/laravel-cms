<?php

namespace App\Widgets;

class ProductGridWidget
{
    const ID = 'product-grid';
    const NAME = 'Product Grid';

    public static function configure(array $data = null) 
    {
        return [
            'form' => view('widget.product-grid.configure', [ 'data' => $data ])->render(),
        ];
    }
}