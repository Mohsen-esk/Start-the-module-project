<?php

namespace Modules\Post;

use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load Migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        // Load Views
        $this->loadViewsFrom(__DIR__.'/Views', 'Post');
    }
}