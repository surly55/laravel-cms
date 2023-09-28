<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Page;

class View extends Model
{
    protected $guarded =  [ 'id', '_id', 'created_at', 'updated_at' ];
    protected $fillable = [ 'name', 'display', 'items_per_page' ];

    public function criterias()
    {
        return $this->embedsMany(\App\Models\ViewCriteria::class);
    }

    public function sortRules()
    {
        return $this->embedsMany(\App\Models\ViewSortRule::class);
    }

    public function buildQuery()
    {
        $query = Page::query();
        foreach($this->criterias as $criteria) {
            switch($criteria->rule) {
                case 'site':
                    $query->where('site_id', $criteria->value);
                    break;
                case 'locale':
                    $query->where('site_locale_id', $criteria->value);
                    break;
                case 'page-type':
                    $query->where('type_id', $criteria->value);
                    break;
            }
        }
        foreach($this->sortRules as $sortRule) {
            switch($sortRule->rule) {
                case 'created':
                case 'updated':
                    $orderBy = $sortRule->rule . '_at';
                    break;
                default:
                    if(substr($sortRule->rule, 0, 6) == 'field:') {
                        $orderBy = 'content.' . substr($sortRule->rule, 6);
                    }
            }
            $query = $query->orderBy($orderBy, $sortRule->order);
        }
        if($this->items_per_page > 0) {
            $query->take((int)$this->items_per_page);
        }

        return $query;
    }
}
