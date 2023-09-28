<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ViewSortRule extends Model
{
    protected $guarded =  [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'rule', 'order' ];
}