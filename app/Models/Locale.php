<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Locale extends Model
{
    public $timestamps = false;

    protected $guarded = [ 'id', '_id' ];
    protected $fillable = [ 'name', 'code' ];
}
