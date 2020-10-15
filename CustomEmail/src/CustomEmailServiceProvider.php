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
    }

    public function register()
    {
        //
    }
}
