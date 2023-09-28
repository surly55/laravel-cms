<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Site extends Model
{
    protected $collection = 'sites';

    protected $guarded =  [ 'id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'name', 'domain', 'https', 'layout' ,'languages','currencies', 'share','newsletter' ];

    protected $attributes = [
        'https' => false,
    ];

    public function setHttpsAttribute($value)
    {
        $this->attributes['https'] = !is_bool($value) ? (bool) $value : $value;
    }

    public function locales()
    {
        //return $this->hasMany(\App\Models\SiteLocale::class);
        return $this->embedsMany(\App\Models\SiteLocale::class);

    }

    public function pageTypes()
    {
        return $this->hasMany(\App\Models\PageType::class)->orderBy('name');
    }


    public function options()
    {
        return $this->embedsMany(\App\Models\SiteOption::class);
    }

    public function attachedWidgets()
    {
        return $this->embedsMany(\App\Models\SiteWidget::class);
    }
}
