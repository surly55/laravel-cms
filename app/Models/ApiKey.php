<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = 'api_keys';

    protected $guarded = array('id', 'created_at', 'updated_at');
    protected $fillable = array('key', 'secret', 'active');
}