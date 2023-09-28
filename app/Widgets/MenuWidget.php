<?php

namespace App\Widgets;

use App\Models\Menu;

class MenuWidget
{
    const ID = 'menu';
    const NAME = 'Menu';

    public static function configure(array $data = null) 
    {
        return [
            'requires' => [ 'widgets/menu.min.js' ],
            'form' => view('widget.configure.menu', [ 'data' => $data ])->render(),
        ];
    }

    public function transform(array $data)
    {
        $menuId = $data['menu'];
        $menu = Menu::find($menuId);
        $data['menu'] = [ 'items' => $this->generateMenu($menu) ]; 
        return $data;
    }

    private function generateMenu(Menu $menu)
    {
        $menuItems = [];
        foreach($menu->items as $item) {
            $menuItem = $item->toArray();
            switch($item->type) {
                case 'menu':
                    $menu = Menu::find($item->link);
                    if($menu === null) {
                        $menuItems['items'] = [];
                    } else {
                        $menuItem['items'] = $this->generateMenu($menu);
                    }
                    break;
                case 'page':
                    if($item->page) {
                        $menuItem['link'] = $item->page->url;
                    } else {
                        // If we can't find the linked page don't add it to menu
                        $menuItem = null;
                    }
                    break;
            }
            if($menuItem) {
                $menuItems[] = $menuItem;
            }
        }
        return $menuItems;
    }

}