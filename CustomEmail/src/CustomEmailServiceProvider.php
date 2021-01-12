<?php
namespace Leadingdots\CustomEmail;

use Illuminate\Support\ServiceProvider;

class CustomEmailServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'customemail');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $this->publishes([
            __DIR__.'/public/assets' => public_path('leadingdots/customemail'),
        ], 'public');

        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/leadingdots/customemail'),
        ]);

        $this->publishes([
            __DIR__.'/config' => base_path('config'),
        ]);
    }

    public function register()
    {
        //
    }
}
