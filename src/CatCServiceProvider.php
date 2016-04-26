<?php

namespace hsrtech\catc;

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

    }
    /**
     * Registering the Cloud at cost API
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Wrapper::class, function (){
            $parms = [
                'api_key' => env('API_KEY'),
                'email' => env('API_EMAIL'),
            ];
            return (new Wrapper($parms));
        });

    }
}
