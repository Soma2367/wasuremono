<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->register(BladeHeroiconsServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
