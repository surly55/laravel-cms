<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class WidgetType extends Model
{
    protected $fillable = [ 'name', 'uri', 'description' ];
}