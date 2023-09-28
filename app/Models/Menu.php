<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [ 'title', 'type', 'site_id', 'site_locale_id' ];

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class);
    }

    public function locale()
    {
        return $this->belongsTo(\App\Models\SiteLocale::class, 'site_locale_id');
    }

    public function items()
    {
        return $this->embedsMany(\App\Models\MenuItem::class);
    }
}
