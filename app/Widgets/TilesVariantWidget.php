<?php

namespace App\Widgets;

use App\Models\Media;
use App\Models\Page;

class TilesVariantWidget
{
    const ID = 'tiles-variant';
    const NAME = 'Tiles (Mosaic)';

    public function configure(array $data = null) 
    {
        if($data) {
            foreach($data['tiles'] as &$tile) {
                if(isset($tile['link_type']) && $tile['link_type'] == 'page') {
                    $page = Page::findOrFail($tile['link']);
                    $tile['page'] = $page->title . ' (' . $page->url . ')';
                }
            }
        }

        return [
            'requires' => [ 'jqueryui.min.js', 'handlebars.min.js', 'typeahead.bundle.min.js', 'levenshtein.js', 'modal/library.min.js', 'widgets/tiles.min.js' ],
            'form' => view('widget.configure.tiles-variant', [ 'data' => $data, 'layouts' => $this->getLayouts(), 'minTiles' => 2 ])->render(),
        ];
    }

    public static function transform(array $data)
    {
        foreach($data['tiles'] as &$tile) {
            $media = Media::find($tile['image']);
            $tile['image'] = null;
            if($media) {
                $tile['image'] = '/uploads/' . $media->filename;
            }
            if(isset($tile['link_type']) && $tile['link_type'] == 'page') {
                $page = Page::find($tile['link']);
                if($page) {
                    $tile['link'] = $page->url;
                } else {
                    $tile['link'] = '';
                }
            }
        }
        
        return $data;
    }

    public function saveData($data)
    {
        $data['tiles'] = array_values($data['tiles']);
        $layouts = $this->getLayouts();
        $data['tiles'] = array_slice($data['tiles'], 0, $layouts[$data['layout']]['tiles']);
        
        return $data;
    }

    private function getLayouts()
    {
        return [
            'fiveTiles' => [
                'name' => '5 tiles (1 large & 4 smaller)',
                'tiles' => 5,
            ],
            'fiveTilesAlt' => [
                'name' => '5 tiles alt. (2 in first row, 3 in second)',
                'tiles' => 5,
            ],
            'tenTiles' => [
                'name' => '10 tiles (combination of two 5 tile layouts)',
                'tiles' => 10,
            ],
            'tenTilesAlt' => [
                'name' => '10 tiles alt. (in third row first tile is smaller than the other one)',
                'tiles' => 10,
            ],
        ];
    }
}