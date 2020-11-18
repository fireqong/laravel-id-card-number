<?php


namespace Church\IDCard;


use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $validator = $this->app['validator'];
        $validator->extend('idNumber', function ($attribute, $value, $paramters) {
            return  (new IDCard($value))->isValid();
        });
    }
}
