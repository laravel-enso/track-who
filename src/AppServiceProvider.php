<?php

namespace LaravelEnso\TrackWho;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/config/trackWho.php', 'enso.trackWho');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'trackWho-config');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');
    }

    public function register()
    {
        //
    }
}
