<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    // Force HTTPS for ngrok tunnels
    if (str_contains(request()->getHost(), 'ngrok') || config('app.env') !== 'local') {
        URL::forceScheme('https');
    }
}
}
