<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class AdministrationComposer
{

    public function compose(View $view)
    {
        if(request()->route()) {
            $route = request()->route()->getName();
            $routeGroup = $routeAction = null;
            if(strpos($route, '.')) {
                list($routeGroup, $routeAction) = explode('.', request()->route()->getName());
            }

            $view->with(compact('route', 'routeGroup', 'routeAction'));
        }
    }

}