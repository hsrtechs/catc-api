<?php

namespace hsrtech\catc;

use \hsrtech\catc;
use \Illuminate\Foundation\AliasLoader;
use \Illuminate\Support\ServiceProvider;

/**
 * Class CatCServiceProvider
 * @package hsrtech\catc
 */
class CatCServiceProvider extends ServiceProvider
{

    /**
     * Registering the Alias for the wrapper
     */
    public function boot(){
        $loader = AliasLoader::getInstance();
        $loader->alias('catc','hsrtech\catc\wrapper');
    }
    /**
     * Registering the Cloud at cost API
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('catc', function (){
            return new catc\Wrapper([env('API_KEY'),env('API_EMAIL')]);
        });
    }
}
