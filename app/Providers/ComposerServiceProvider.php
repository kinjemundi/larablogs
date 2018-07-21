<?php

namespace App\Providers;
use App\Blog;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 
        View::composer(['partials.meta_dynamic','layouts.nav'], function ($view) {
            $view->with('blogs',Blog::where('status',1)->latest()->get());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
