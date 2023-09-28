<?php

namespace App\Widgets;

class TilesWidget
{
    const ID = 'tiles';
    const NAME = 'Tiles';

    public static function configure() 
    {
        //$mediaCategories = DB::collection('medias')->distinct('category')->get();

        return [
            //'scripts' => array('bootstrap.min.js', 'boxes.widget.js'),
            'requires' => [ 'widgets/tiles.min.js' ],
            'form' => view('widget.configure.tiles')->render(),
        ];
    }

    /*public static function render($data = array())
    {
        $mediaCategories = DB::collection('medias')->distinct('category')->get();
        for($i = 0; $i < count($data['boxes']); $i++) {
            $data['boxes'][$i]['page'] = Page::find($data['boxes'][$i]['page']);
        }

        return array(
            'scripts' => array('bootstrap.min.js', 'boxes.widget.js'),
            'form' => View::make('widget.render.boxes', array('data' => $data, 'mediaCategories' => $mediaCategories))->render(),
        );
    }

    public static function data($data) 
    {
        $widgetData = array();
        foreach($data['boxes'] as $id => $box) {
            $page = Page::find($box['page']);
            $widgetData[$id] = array('url' => $page->url);
        }
        return $widgetData;
    }*/
}