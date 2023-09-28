<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Field extends Model
{
    protected $guarded = [ 'id', '_id' ];
    protected $fillable = [ 'name', 'type', 'configuration' ];
}