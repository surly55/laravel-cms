<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PageType extends Model
{
    public $timestamps = false;
    protected $guarded = [ 'id' ];
    protected $fillable = [ 'uri', 'name', 'site_id', 'description', 'fields' ];

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class);
    }

    public function pages()
    {
        return $this->hasMany(\App\Models\Page::class);
    }

    public function locales()
    {
        return $this->belongsToMany(\App\Models\SiteLocale::class, null, 'site_locale_ids');
    }

    public function templates()
    {
        return $this->belongsToMany(\App\Models\PageTemplate::class);
    }

    public function attachedWidgets()
    {
        return $this->embedsMany(\App\Models\PageTypeWidget::class);
    }
}