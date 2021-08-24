<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
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
        //Solution for language switcher
        UrlGenerator::macro('toLanguage', function (string $language) {
            $currentRoute = app('router')->current();
            $newRouteParameters = array_merge(
                $currentRoute->parameters(), compact('language')
            );
            return $this->route($currentRoute->getName(), $newRouteParameters);
        });
    }
}
