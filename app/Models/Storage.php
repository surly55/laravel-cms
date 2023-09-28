<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [ 'name', 'type', 'options' ];
}