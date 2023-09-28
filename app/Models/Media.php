<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [ 'caption', 'category', 'storage_id', 'filename', 'metadata' ];

    public function storage()
    {
        return $this->belongsTo(\App\Models\Storage::class);
    }
}