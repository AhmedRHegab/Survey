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
        // Only force HTTPS. Do NOT forceRootUrl from APP_URL — a stale Railway
        // domain there makes CSS/JS load from the wrong host.
        if ((! app()->runningInConsole()) && request()->isSecure()) {
            URL::forceScheme('https');
        } elseif (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
