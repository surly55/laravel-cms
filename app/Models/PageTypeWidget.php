<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PageTypeWidget extends Model
{
    protected $guarded = [ '_id' ];
    protected $fillable = [ 'widget_id', 'site_locale_id', 'template_id', 'region', 'weight' ];
    protected $appends = [ 'widget_name', 'region_name' ];

    public function widget()
    {
        return $this->belongsTo(\App\Models\Widget::class, 'widget_id');
    }

    public function getWidgetNameAttribute()
    {
        return $this->widget->name;
    }

    public function template()
    {
        return $this->belongsTo(\App\Models\PageTemplate::class);
    }

    public function getRegionNameAttribute()
    {
        return $this->template->getRegion($this->attributes['region'])['name'];
    }

    public function locale()
    {
        return $this->belongsTo(\App\Models\SiteLocale::class, 'site_locale_id');
    }
}