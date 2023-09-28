<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [ 'position', 'label', 'labelHtml', 'type', 'link', 'parent', 'tags' ];

    public function items()
    {
        return $this->embedsMany(\App\Models\MenuItem::class);
    }

    public function page()
    {
        return $this->hasOne(\App\Models\Page::class, '_id', 'link');
    }

    /**
     * I don't know how else to make this relationship work
     */
    public function menu()
    {
        return Menu::find($this->attributes['link']);
        //return $this->hasOne(\App\Models\Menu::class, '_id', 'link');
    }
}
