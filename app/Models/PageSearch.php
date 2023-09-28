<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PageSearch extends Model
{
    protected $guarded = [ 'id', '_id' ];
    protected $fillable = [ 'id', 'name', 'value' ];
    protected $hidden = [ 'id', '_id' ];
}
