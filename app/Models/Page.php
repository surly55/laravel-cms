<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Field;
//use App\Models\PageType;
use FieldFactory;

class Page extends Model
{
    protected $guarded =  [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'title', 'url',  'page_type', 'page_theme' , 'type_id', 'template_id', 'site_id', 'site_locale_id', 'published', 'content', 'widgets' ];

    public function parent()
    {
        return $this->belongsTo(\App\Models\Page::class);
    }

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class, 'site_id');
    }

    public function locale()
    {
        return $this->belongsTo(\App\Models\SiteLocale::class, 'site_locale_id');
    }

  public function type()
    {
        return $this->belongsTo(\App\Models\PageType::class, 'type_id');
    }

    public function template()
    {
        return $this->belongsTo(\App\Models\PageTemplate::class, 'template_id');
    }

    public function metadata()
    {
        return $this->embedsMany(\App\Models\PageMetadata::class);
    }

    public function menu()
    {
        return $this->embedsMany(\App\Models\PageMenu::class);
    }

    public function search()
    {
        return $this->embedsMany(\App\Models\PageSearch::class);
    }

    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = ($value == '0') ? false : true;
    }

    public function setContentAttribute($value)
    {
        if(!isset($this->attributes['content'])) {
            $this->attributes['content'] = [];
        }
       $pageType = PageType::find($this->attributes['type_id']);
        $fieldFactory = new FieldFactory();
        foreach($pageType->fields as $fieldId => $fieldData) {
            $field = Field::find($fieldData['field']);
            $fieldClass = $fieldFactory->make($field->type);
            if(method_exists($fieldClass, 'set')) {
                $this->attributes['content'][$fieldId] = $fieldClass->set($value[$fieldId]);
            } else {
                $this->attributes['content'][$fieldId] = $value[$fieldId];
            }
        }

    }
}
