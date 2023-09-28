<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TaxonomicGroup extends Model
{
    protected $guarded =  [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'name' ];

    public function terms()
    {
        return $this->embedsMany(\App\Models\TaxonomicTerm::class);
    }
}