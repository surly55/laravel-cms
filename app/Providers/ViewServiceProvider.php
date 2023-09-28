<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer('layouts.master', 'App\Http\ViewComposers\AdministrationComposer');
    }

    public function register()
    {

    }

}