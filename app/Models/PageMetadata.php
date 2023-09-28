<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PageMetadata extends Model 
{
    protected $guarded = [ 'id', '_id' ];
    protected $fillable = [ 'name', 'value' ];
    protected $hidden = [ 'id', '_id' ];
}