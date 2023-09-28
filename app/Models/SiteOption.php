<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class SiteOption extends Model
{
    protected $guarded = [ 'id', '_id' ];

    protected $fillable = [ 'name', 'value', 'site_locale_id' ];

    public function locale()
    {
        return $this->belongsTo(\App\Models\SiteLocale::class, 'site_locale_id');
    }
}