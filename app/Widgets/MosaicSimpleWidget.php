<?php

namespace App\Widgets;

use App\Models\Media;
use App\Models\Page;

class MosaicSimpleWidget
{
    const ID = 'mosaic-simple';
    const NAME = 'Mosaic (Simple)';

    public function configure(array $data = null) 
    {
        if($data) {
            foreach($data['tiles'] as &$tile) {
                if(isset($tile['link_type']) && $tile['link_type'] == 'page') {
                    $page = Page::find($tile['link']);
                    if($page !== null) {
                        $tile['page'] = $page->title . ' (' . $page->url . ')';
                    } else {
                        $tile['page'] = 'Page missing';
                    }
                }
            }
        }

        return [
            'requires' => [ 'jqueryui.min.js', 'handlebars.min.js', 'typeahead.bundle.min.js', 'levenshtein.js', 'modal/library.min.js', 'widgets/tiles.min.js' ],
            'form' => view('widget.configure.tiles-variant', [ 'data' => $data, 'layouts' => $this->getLayouts(), 'simpleMosaic' => true, 'minTiles' => 2 ])->render(),
        ];
    }

    public function transform(array $data)
    {
        foreach($data['tiles'] as &$tile) {
            $media = Media::findOrFail($tile['image']);
            $tile['image'] = '/uploads/' . $media->filename;
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
            'twoTiles' => [
                'name' => '2 tiles (equal width)',
                'tiles' => 2,
            ],
            'twoTilesVariantA' => [
                'name' => '2 tiles (1st tile wider)',
                'tiles' => 2,
            ],
            'twoTilesVariantB' => [
                'name' => '2 tiles (2nd tile wider)',
                'tiles' => 2,
            ],
            'threeTiles' => [
                'name' => '3 tiles',
                'tiles' => 3,
            ],
            'fiveTiles' => [
                'name' => '5 tiles (1 large & 4 smaller)',
                'tiles' => 5,
            ]
        ];
    }
}