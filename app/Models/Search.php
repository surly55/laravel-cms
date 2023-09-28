<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [ 'title', 'site_id', 'site_locale_id','searchCollapsed','itemSearchLocation','itemSearchAccomodation','itemSearchFrom','itemSearchTo', 'itemSearchAdults','itemSearchKids' ];

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
