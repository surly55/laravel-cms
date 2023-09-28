<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class SiteLocale extends Model
{
    protected $guarded = [ 'id', '_id' ];

    protected $fillable = [ 'name', 'site_id', 'locale_id', 'type', 'subdomain', 'url_prefix', 'active' ];

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class);
    }

    public function locale()
    {
        return $this->belongsTo(\App\Models\Locale::class);
    }

    public function pageTypes()
    {
        return $this->belongsToMany(\App\Models\PageType::class, null, 'page_type_ids', 'site_locale_ids');
    }
}
