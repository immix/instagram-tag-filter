<?php

namespace App\Providers;

use App\Services\Instagram;
use Illuminate\Support\ServiceProvider;

class InstagramServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Instagram::class, function($app) {
            return new Instagram();
        });
    }
}
