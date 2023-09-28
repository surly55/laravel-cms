<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PageTemplate extends Model
{
    public $timestamps = false;
    protected $guarded = [ 'id' ];
    protected $fillable = [ 'name', 'template_id', 'description', 'regions' ];

    public function pageTypes()
    {
        return $this->belongsToMany('App\Models\PageType');
    }

    public function getRegion($id)
    {
        foreach($this->attributes['regions'] as $region) {
            if($region['id'] == $id) {
                return $region;
            }
        }
        return null;
    }
}