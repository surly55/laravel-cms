<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Translation extends Model
{
    protected $collection = 'translations';

    protected $guarded = [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'key', 'source', 'site_id', 'translations' ];

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class);
    }
}