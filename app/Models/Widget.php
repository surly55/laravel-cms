<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = [ 'name', 'subtitle', 'widget_id', 'type', 'site_id', 'site_locale_id', 'header' ];

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class);
    }

    public function locale()
    {
        return $this->belongsTo(\App\Models\SiteLocale::class, 'site_locale_id');
    }
}
