<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Railway terminates TLS at the proxy; force correct public asset URLs.
        if ($root = config('app.url')) {
            URL::forceRootUrl(rtrim($root, '/'));
        }

        if (config('app.env') === 'production' || substr((string) config('app.url'), 0, 8) === 'https://') {
            URL::forceScheme('https');
        }
    }
}
