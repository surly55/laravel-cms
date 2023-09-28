<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ViewCriteria extends Model
{
    protected $guarded =  [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'rule', 'condition', 'value' ];
}
