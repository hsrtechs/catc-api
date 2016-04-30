<?php

namespace hsrtech\catc;

use Validator;
use Illuminate\Support\ServiceProvider;

/**
 * Class CatCServiceProvider
 * @package hsrtech\catc
 */
class CatCServiceProvider extends ServiceProvider
{

    /**
     * Regestiring Validations
     */
    public function boot()
    {

        Validator::extend('ram', function($attribute, $value, $parameters, $validator) {
            return (is_numeric($value) && is_integer(intval($value/512)));
        });

        Validator::extend('cpu', function($attribute, $value, $parameters, $validator) {
            return (is_numeric($value) && is_integer(intval($value)));
        });

        Validator::extend('storage', function($attribute, $value, $parameters, $validator) {
            return (is_numeric($value) && is_integer(intval($value/10)));
        });
    }
    /**
     * Registering the Cloud at cost API Constructor
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
