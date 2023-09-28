<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use cebe\markdown\Markdown;

class MarkdownServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register() 
    {
        $this->app->singleton('cebe\markdown\Markdown', function() {
            $parser = new Markdown();
            $parser->html5 = true;
            return $parser;
        });
    }

    public function provides()
    {
        return [ 'cebe\markdown\Markdown' ];
    }
}