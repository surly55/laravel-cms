<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TaxonomicTerm extends Model
{
    protected $guarded =  [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'name', 'key', 'description' ];
}