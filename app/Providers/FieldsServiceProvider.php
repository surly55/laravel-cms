<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Fields\Factory as FieldFactory;

class FieldsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register() 
    {
        $this->app->singleton('App\Fields\Factory', function() {
            return new FieldFactory();
        });
    }

    public function provides()
    {
        return [ 'App\Fields\Factory' ];
    }
}